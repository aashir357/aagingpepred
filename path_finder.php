<?php
/**
 * path_finder.php - Script to locate hard-coded paths in PHP files
 * 
 * This script helps you identify which files contain hard-coded paths
 * that need to be updated to use the new config system.
 * 
 * Usage: php path_finder.php
 */

// Directory to scan (current directory by default)
$scanDir = __DIR__;

// Patterns to search for
$patterns = [
    'putenv\(\'PYTHONPATH=([^\']+)',  // PYTHONPATH environment variables
    'putenv\(\'PATH=([^\']+)',        // PATH environment variables
    'putenv\(\'MPLCONFIGDIR=([^\']+)', // MPLCONFIGDIR environment variables
    'putenv\(\'LD_LIBRARY_PATH=([^\']+)', // LD_LIBRARY_PATH environment variables
    '\/home\/[a-z0-9]+\/',           // Home directory paths
    '\/usr\/bin\/',                   // /usr/bin paths
    '\/usr\/local\/',                 // /usr/local paths
    '\.\/(?!\.\.)[a-zA-Z0-9]+_tmp_dir', // Relative temporary directories
    'exec\(\s*["\']python[23]?\s+\/[^"\']+', // Python execution with absolute paths
];

// File extensions to scan
$extensions = ['php', 'html', 'js'];

// Skip directories
$skipDirs = ['.git', 'vendor', 'node_modules'];

// Store results
$results = [];

// Function to scan files recursively
function scanFiles($dir, $patterns, $extensions, $skipDirs, &$results) {
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..' || in_array($file, $skipDirs)) {
            continue;
        }
        
        $path = $dir . '/' . $file;
        
        if (is_dir($path)) {
            scanFiles($path, $patterns, $extensions, $skipDirs, $results);
        } else {
            // Check file extension
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if (in_array($ext, $extensions)) {
                // Read file content
                $content = file_get_contents($path);
                
                // Check each pattern
                foreach ($patterns as $pattern) {
                    if (preg_match_all('/' . $pattern . '/i', $content, $matches, PREG_OFFSET_CAPTURE)) {
                        if (!isset($results[$path])) {
                            $results[$path] = [];
                        }
                        
                        foreach ($matches[0] as $match) {
                            $line = substr_count(substr($content, 0, $match[1]), "\n") + 1;
                            $context = getContext($content, $match[1], 100);
                            
                            $results[$path][] = [
                                'pattern' => $pattern,
                                'match' => $match[0],
                                'line' => $line,
                                'context' => $context
                            ];
                        }
                    }
                }
            }
        }
    }
}

// Get context around a match
function getContext($content, $position, $contextLength) {
    $start = max(0, $position - $contextLength);
    $length = min(strlen($content) - $start, $position - $start + $contextLength);
    
    $context = substr($content, $start, $length);
    
    // Highlight the match
    $relativePos = $position - $start;
    $matchEnd = strpos($context, "\n", $relativePos);
    if ($matchEnd === false) {
        $matchEnd = strlen($context);
    }
    
    // Get the line containing the match
    $lineStart = strrpos(substr($context, 0, $relativePos), "\n");
    if ($lineStart === false) {
        $lineStart = 0;
    } else {
        $lineStart++;
    }
    
    return trim(substr($context, $lineStart, $matchEnd - $lineStart));
}

// Run the scan
scanFiles($scanDir, $patterns, $extensions, $skipDirs, $results);

// Output results
echo "====== Found " . count($results) . " files with hard-coded paths ======\n\n";

foreach ($results as $file => $matches) {
    $relPath = str_replace($scanDir . '/', '', $file);
    echo "FILE: $relPath\n";
    echo str_repeat('-', strlen($relPath) + 6) . "\n";
    
    $uniqueMatches = [];
    foreach ($matches as $match) {
        $key = $match['line'] . ':' . $match['match'];
        if (!isset($uniqueMatches[$key])) {
            $uniqueMatches[$key] = $match;
            echo "Line {$match['line']}: {$match['context']}\n";
        }
    }
    
    echo "\n";
}

echo "=== Scan complete ===\n";
echo "Run this script again after making changes to verify all hard-coded paths have been updated.\n";

