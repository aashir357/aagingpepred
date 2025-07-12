<?php
$config = require_once __DIR__ . '/config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the Pred directory path from configuration
$predDir = getenv('PRED_DIR');

// Specify the peptide directory using the configuration
$tempDir = $predDir . '/peptide';

// Ensure the directory exists
if (!file_exists($tempDir)) {
    mkdir($tempDir, 0755, true);
}

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
    
    // Read the sequence from the temporary file
    $sequence = file_get_contents($tempFile);

    // Check the length of each sequence
    $lines = explode("\n", $sequence);
    foreach($lines as $line) {
        $line = trim($line);
        if($line === '') {
            continue; }
        
        if(strpos($line, '>') !== 0) {
            $sequenceLength = strlen($line);
            if ($sequenceLength < 5 || $sequenceLength > 50) {
                echo "Sequence length should be between 5 and 50 amino acids.";
                return;
            }       
        }
    }
    
    // Putting sequence back into tempFile
    file_put_contents($tempFile, $sequence);


    // Get the directory of the temporary file
    $tempFileDir = dirname($tempFile);

    // Move the temporary file to the desired folder with .fasta extension
    $queryFile = $tempFileDir . '/query.fasta';
    rename($tempFile, $queryFile);


    // Set the working directory to the Python script directory
    chdir($predDir . '/peptide');

    // Execute calc_features.sh
    $calcFeaturesOutput = shell_exec('./calc_features.sh 2>&1');  

    // Execute features.py with absolute path to wrapper script
    $featuresOutput_rdm = shell_exec('/opt/lampp/htdocs/cgntlab/aagingpepred/python_wrapper.sh features_rdm.py 2>&1');
    $featuresOutput_swp = shell_exec('/opt/lampp/htdocs/cgntlab/aagingpepred/python_wrapper.sh features_swp.py 2>&1');
    echo "<pre>$featuresOutput_rdm</pre>";
    echo "<pre>$featuresOutput_swp</pre>";




    // Determine which Python script to run based on the selected radio button
    if (isset($_POST['model'])) {
        $model = $_POST['model'];
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



    // Construct the Python command

    // Before executing Python commands:
    echo "Current working directory: " . getcwd() . "<br>";
    echo "Python executable: " . getenv('PYTHON_EXECUTABLE') . "<br>";
    echo "LD_LIBRARY_PATH: " . getenv('LD_LIBRARY_PATH') . "<br>";

    // When executing Python:
    // Execute the Python script with complete path 
    $pythonExe = getenv('PYTHON_EXECUTABLE');
    $pythonCommand = 'cd ' . $predDir . '/peptide && ' . $pythonExe . ' ' . $pythonScript;
    echo "Executing model command: $pythonCommand<br>";
    $pythonOutput = shell_exec($pythonCommand . ' 2>&1');
    echo "Model output:<br><pre>$pythonOutput</pre>";

    //  debug line
    echo "Testing Python execution...<br>";
    $debugOutput = shell_exec('python3 -c "print(\'Python works\')" 2>&1');
    echo "Debug output: " . $debugOutput . "<br>";

    // Output the result
    echo "<pre>$pythonOutput</pre>";

    if ($pythonOutput === null) {
        echo "Error executing Python script.";
    }

    echo "Script started";

    // Comment out these lines to prevent redirection

    // Redirect to the result page
    header("Location: result_pep.php?model=" . urlencode($_POST['model']));
    exit();

}
?>