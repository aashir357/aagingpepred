<?php
/**
 * config.php - Path configuration for cross-system compatibility
 * 
 * This file handles system-specific paths that can be overridden 
 * using environment variables or a local config file.
 */

// Define a function to get configuration with fallbacks
function getConfigPath($key, $default = null) {
    // First check if there's an environment variable set
    $envVar = getenv($key);
    if ($envVar !== false) {
        return $envVar;
    }
    
    // Check if we have a local config file
    $localConfigFile = __DIR__ . '/local_config.php';
    static $localConfig = null;
    
    if ($localConfig === null && file_exists($localConfigFile)) {
        $localConfig = include($localConfigFile);
    }
    
    // Return from local config if available
    if (is_array($localConfig) && isset($localConfig[$key])) {
        return $localConfig[$key];
    }
    
    // Fall back to default
    return $default;
}

// Helper function for safe directory creation
function safeCreateDirectory($path) {
    if (!file_exists($path)) {
        $result = @mkdir($path, 0777, true); // Use 0777 for maximum compatibility
        if (!$result) {
            error_log("Warning: Could not create directory: $path. Please check permissions.");
            return false;
        }
    }
    return true;
}

// Base directory of the application
define('BASE_DIR', realpath(__DIR__));

// Configure paths with smart defaults that work in most environments
$paths = [
    // Matplotlib temp directory - use a subdirectory of the application
    'MPLCONFIGDIR' => getConfigPath('MPLCONFIGDIR', BASE_DIR . '/tmp/matplotlib'),
    
    // Python path - try to detect based on common locations
    'PYTHON_EXECUTABLE' => getConfigPath('PYTHON_EXECUTABLE', '/usr/bin/python3'),

    'PYTHONPATH' => getConfigPath('PYTHONPATH', implode(PATH_SEPARATOR, [
        '/usr/local/lib/python3.10/site-packages',
        '/usr/lib/python3.10/site-packages',
        BASE_DIR . '/python/lib'
    ])),
    
    // Path extensions for executables
    'PATH_EXTENSIONS' => getConfigPath('PATH_EXTENSIONS', implode(PATH_SEPARATOR, [
        '/usr/bin',
        '/usr/local/bin',
        BASE_DIR . '/bin'
    ])),
    
    'PYTHON_EXECUTABLE' => getConfigPath('PYTHON_EXECUTABLE', '/opt/lampp/htdocs/cgntlab/aagingpepred/python_wrapper.sh'),

    // Pred directory - relative to the application
    'PRED_DIR' => getConfigPath('PRED_DIR', BASE_DIR . '/Pred'),
    
    // C++ Libraries path
    'CPP_LIB_PATH' => getConfigPath('CPP_LIB_PATH', '/lib/x86_64-linux-gnu'),
    
    // For MEME software
    'MEME_DIR' => getConfigPath('MEME_DIR', '/usr/local/meme'),
    
    // For EMBOSS tools
    'EMBOSS_DIR' => getConfigPath('EMBOSS_DIR', '/usr/bin'),
    
    // For sequence search tools
    'SSEARCH_DIR' => getConfigPath('SSEARCH_DIR', '/usr/bin'),
    
    // If using miniconda in some places
    'CONDA_DIR' => getConfigPath('CONDA_DIR', '/home/cgntlab1/miniconda3'),
    
    // Project specific directories
    'PROJECT_DIR' => getConfigPath('PROJECT_DIR', BASE_DIR),
    
    // Temporary directory
    'TEMP_DIR' => getConfigPath('TEMP_DIR', BASE_DIR . '/tmp'),
    
    // Downloads directory
    'DOWNLOADS_DIR' => getConfigPath('DOWNLOADS_DIR', BASE_DIR . '/downloads'),
    
    // Results directory
    'RESULTS_DIR' => getConfigPath('RESULTS_DIR', BASE_DIR . '/results'),
    
    // Web base path for URLs
    'WEB_BASE_PATH' => getConfigPath('WEB_BASE_PATH', '/aagingpepred')
];

// Apply the paths to the environment
foreach ($paths as $key => $value) {
    if ($key === 'PATH_EXTENSIONS') {
        // For PATH, we append to the existing PATH
        putenv('PATH=' . $value . PATH_SEPARATOR . getenv('PATH'));
    } else {
        putenv($key . '=' . $value);
    }
}

// Set LD_LIBRARY_PATH to include both system and local libraries
$localLibPath = BASE_DIR . '/libs';
$cppLibPath = getenv('CPP_LIB_PATH');
putenv("LD_LIBRARY_PATH={$localLibPath}:{$cppLibPath}:" . getenv("LD_LIBRARY_PATH"));

// Enable error reporting for development
ini_set('display_errors', getConfigPath('DISPLAY_ERRORS', '1'));
ini_set('display_startup_errors', getConfigPath('DISPLAY_STARTUP_ERRORS', '1'));
error_reporting(E_ALL);

// Create all necessary directories with better error handling
$dirsToCreate = [
    // Main directories
    $paths['TEMP_DIR'],
    $paths['MPLCONFIGDIR'],
    $paths['DOWNLOADS_DIR'],
    $paths['RESULTS_DIR'],
    
    // Pred subdirectories
    $paths['PRED_DIR'] . '/peptide/downloads',
    $paths['PRED_DIR'] . '/pep_card/downloads',
    $paths['PRED_DIR'] . '/motif_scanning/mast_output',
    $paths['PRED_DIR'] . '/protein_mutant/downloads',
    $paths['PRED_DIR'] . '/protein_scanning/downloads',
    $paths['PRED_DIR'] . '/design/downloads'
];

// Try to create directories, but don't halt execution if we can't
$dirCreationFailed = false;
foreach ($dirsToCreate as $dir) {
    if (!safeCreateDirectory($dir)) {
        $dirCreationFailed = true;
    }
}

// Provide a helper function for file operations throughout the application
function safeFileOperation($operation, $path, $data = null) {
    // First, try to create the directory if needed
    if ($operation === 'write' || $operation === 'mkdir') {
        $dirPath = ($operation === 'mkdir') ? $path : dirname($path);
        if (!file_exists($dirPath)) {
            @mkdir($dirPath, 0777, true);
        }
    }
    
    switch ($operation) {
        case 'write':
            // Try to write to file with error suppression
            $result = @file_put_contents($path, $data);
            if ($result === false) {
                error_log("Failed to write to file: $path");
                return false;
            }
            return true;
            
        case 'read':
            // Try to read file with error suppression
            if (!file_exists($path)) {
                error_log("File does not exist: $path");
                return null;
            }
            $content = @file_get_contents($path);
            if ($content === false) {
                error_log("Failed to read file: $path");
                return null;
            }
            return $content;
            
        case 'mkdir':
            // Try to create directory with error suppression
            if (file_exists($path)) {
                return true;
            }
            if (@mkdir($path, 0777, true) === false) {
                error_log("Failed to create directory: $path");
                return false;
            }
            return true;
            
        default:
            return false;
    }
}

// Return the paths array so it can be used if this file is included
return $paths;