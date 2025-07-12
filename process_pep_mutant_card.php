<?php

// Start output buffering to prevent any output until we're ready 
ob_start();

$config = require_once __DIR__ . '/config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['sequence']) && isset($_GET['model'])) {
    // Retrieve the sequence and model from the URL parameters
    $sequence = urldecode($_GET['sequence']);
    $model = urldecode($_GET['model']);

    // Use $sequence and $model as needed
    echo "Sequence: $sequence<br>";
    echo "Model: $model";

    // Directory to save the sequence file
    $predDir = getenv('PRED_DIR');
    $tempDir = $predDir . '/mutant_card';

    // Save the sequence as a FASTA file
    $fastaContent = ">sequence\n" . $sequence;
    $fastaFilePath = $tempDir . '/output.fasta';
    file_put_contents($fastaFilePath, $fastaContent);

    echo "Sequence saved as $fastaFilePath";

    // Set the working directory to the Python script directory
    chdir($tempDir);

    // Get the Python wrapper path
    $pythonExe = getenv('PYTHON_EXECUTABLE');

    // Execute shell scripts
    $design = shell_exec('./modify_sequences.sh 2>&1');
    echo "$design";

    // Execute the shell script for feature calculation
    $output = shell_exec('./calc_features_design.sh 2>&1');
    echo "$output";
    
    // Execute Python feature scripts
    $featuresOutput_rdm = shell_exec($pythonExe . ' features_design_rdm.py 2>&1');
    $featuresOutput_swp = shell_exec($pythonExe . ' features_design_swp.py 2>&1');
   
    echo "<pre>$featuresOutput_rdm</pre>";
    echo "<pre>$featuresOutput_swp</pre>";
    
    if ($featuresOutput_rdm === null || $featuresOutput_swp === null) {
        echo "Error executing Python script.";
    }
    
    // Check if feature calculation was successful
    if (!file_exists('rfe_features_rdm.csv')) {
        // Check if the file exists in another directory
        $sourceFile = $predDir . '/peptide/rfe_features_rdm.csv';
        if (file_exists($sourceFile)) {
            // Copy the file to the current directory
            copy($sourceFile, 'rfe_features_rdm.csv');
            echo "Copied rfe_features_rdm.csv from peptide directory<br>";
        } else {
            echo "Error: rfe_features_rdm.csv file not found<br>";
        }
    }

    // Determine which Python script to run based on the model parameter
    if (isset($_POST['model']) || isset($_GET['model'])) {
        $model = isset($_POST['model']) ? $_POST['model'] : $_GET['model'];
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
    } else {
        echo "Error: No model selected.";
        return;
    }
    
    // Construct the Python command
    $pythonCommand = $pythonExe . ' ' . $pythonScript . ' 2>&1';  
    
    // Execute the Python script
    $pythonOutput = shell_exec($pythonCommand);
    
    // Output the result
    echo "<pre>$pythonOutput</pre>";
    
    if ($pythonOutput === null) {
        echo "Error executing Python script.";
    }
    
    // Store the current working directory and full path to design.csv for the results page
    $currentDir = getcwd();
    $designCsvPath = $currentDir . '/design.csv';
    file_put_contents($currentDir . '/path_info.txt', $designCsvPath);
    
    // Check if design.csv exists before redirecting
    if (file_exists($designCsvPath)) {
        echo "<!-- Design CSV file created successfully at: $designCsvPath -->";
    } else {
        echo "Warning: design.csv was not created.";
    }
    
    // Clear any output buffer ob_end_clean();
    ob_end_clean();

    // Redirect to the result page
    echo "<script>window.location.href = 'result_pep_card_mutant.php?model=" . urlencode($model) . "';</script>";
}
?>