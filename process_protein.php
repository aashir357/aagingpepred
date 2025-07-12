<!doctype html>
<html lang="en">
  
<?php include ("header.html")?>




<section class="explore-section section-padding" id="section_2" style="padding-bottom: 50px;">
<div class="container">

<?php

// Start output buffering to prevent any output until we're ready
ob_start();

// Include the configuration
$config = require_once __DIR__ . '/config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the Pred directory path from configuration
$predDir = getenv('PRED_DIR');

// Specify the protein scanning directory using the configuration
$tempDir = $predDir . '/protein_scanning';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted sequences from the textarea
    $sequences = $_POST['sequences'];

    // Retrieve the uploaded files
    $files = $_FILES['files'];

    // Process sequences from the textarea
    if (!empty($sequences)) {
        // Generate a unique filename for the temporary sequence file
        $tempFile = $tempDir . DIRECTORY_SEPARATOR . 'sequences_' . uniqid() . '.fasta';
        file_put_contents($tempFile, $sequences);
        processSequenceFile($tempFile);
    }

    // Process uploaded files
    if (!empty($files['tmp_name'][0])) {
        // Create an array to store the temporary file paths
        $tempFiles = [];

        // Save each uploaded file to a temporary file in the custom directory
        foreach ($files['tmp_name'] as $index => $tmpName) {
            $tempFile = $tempDir . DIRECTORY_SEPARATOR . 'file_' . uniqid() . '.fasta';
            move_uploaded_file($tmpName, $tempFile);
            $tempFiles[] = $tempFile;
            processSequenceFile($tempFile);
        }
    }
}

function processSequenceFile($tempFile) {
    // Get the Pred directory path
    $predDir = getenv('PRED_DIR');
    $tempDir = $predDir . '/protein_scanning';
    
    // Read the sequence from the temporary file
    $sequence = file_get_contents($tempFile);

    // Remove the FASTA header line
    $sequence = preg_replace('/>.*/', '', $sequence);

    // Remove any whitespace and newlines
    $sequence = trim(preg_replace('/\s+/', '', $sequence));

    // Convert the sequence to uppercase
    $sequence = strtoupper($sequence);

    // Check the length of the sequence
    $sequenceLength = strlen($sequence);
    if ($sequenceLength < 80 || $sequenceLength > 2000) {
        echo "Sequence length should be between 80 and 2000 amino acids.";
        return;
    }
    
    // Putting sequence back into tempFile
    file_put_contents($tempFile, $sequence);

    // Get the directory of the temporary file
    $tempFileDir = dirname($tempFile);

    // Move the temporary file to the desired folder with .fasta extension
    $queryFile = $tempFileDir . '/protein_sequence.fasta';
    rename($tempFile, $queryFile);

    // Set the working directory to the Python script directory
    chdir($tempDir);
    
    // Retrieve the selected fragment length
    $fragmentLength = $_POST['chunkSize'];

    // Get the Python executable
    $pythonExe = getenv('PYTHON_EXECUTABLE');
    
    // Execute Python scripts with proper working directory
    $fasta = shell_exec($pythonExe . ' fasta_creation.py 2>&1');

    // Pass the fragment length as an argument to the shell script
    $design = shell_exec("./break_protein.sh $fragmentLength 2>&1");

    // Execute the shell script for features    
    $output = shell_exec('./calc_features_protein.sh 2>&1');

    // Execute features.py with Python wrapper
    $featuresOutput_rdm = shell_exec('cd ' . $tempDir . ' && ' . $pythonExe . ' features_rdm.py 2>&1');
    $featuresOutput_swp = shell_exec('cd ' . $tempDir . ' && ' . $pythonExe . ' features_swp.py 2>&1');
    
    echo "<pre>$featuresOutput_rdm</pre>";
    echo "<pre>$featuresOutput_swp</pre>";
    
    if ($featuresOutput_rdm === null || $featuresOutput_swp === null) {
        echo "Error executing Python script.";
    }
    
   // Determine which Python script to run based on the selected model
if (isset($_POST['model'])) {
    $model = $_POST['model'];
} elseif (isset($_GET['model'])) {
    $model = $_GET['model'];
} else {
    // Set a default model if none is selected
    $model = 'all_features_randomfeatures';
    echo "No model selected, using default model: $model<br>";
}

$pythonScript = '';
if ($model === 'all_features_randomfeatures') {
    $pythonScript = 'model_prediction_all_features_random.py';
} elseif ($model === 'all_features_swissprot') {
    $pythonScript = 'model_prediction_all_features_swissprot.py';
} elseif ($model === 'rfe_features_randomfeatures') {
    $pythonScript = 'model_prediction_rfe_features_random.py';
} elseif ($model === 'rfe_features_swissprot') {
    $pythonScript = 'model_prediction_rfe_features_swissprot.py';
} else {
    echo "Error: Invalid model selected.";
    return;
}

    // Execute the Python model prediction script
    $pythonCommand = 'cd ' . $tempDir . ' && ' . $pythonExe . ' ' . $pythonScript . ' 2>&1';
    $pythonOutput = shell_exec($pythonCommand);

    // Output the result
    echo "<pre>$pythonOutput</pre>";

    if ($pythonOutput === null) {
        echo "Error executing Python script.";
    }

    echo "Script started";

 
    // Commented out these lines to prevent the header redirect issue
    // header("Location: result_protein.php?model=" . urlencode($_POST['model']));
    // exit();
    
    // Clear any output buffer
     ob_end_clean();

    // Instead, use JavaScript for redirection
    echo "<script>window.location.href = 'result_protein.php?model=" . urlencode($_POST['model']) . "';</script>";
}
?>






    
</div>
</section>
</main>

<?php include ("footer.html")?>

    </body>
</html>

