<?php
// Output buffering and loading page removed for direct processing

$config = require_once __DIR__ . '/config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the Pred directory path from configuration
$predDir = getenv('PRED_DIR');

// Check if this is an example sequence access via GET parameters
if (isset($_GET['sequence']) && !isset($_POST['sequences'])) {
    // This is an example sequence accessed directly
    
    // Create the temp directory path
    $tempDir = $predDir . '/design';
    
    // Get the sequence from the URL parameter
    $sequence = $_GET['sequence'];
    
    // Generate a temporary file
    $tempFile = $tempDir . '/sequences_' . uniqid() . '.fasta';
    file_put_contents($tempFile, $sequence);
    
    // Process this file
    processSequenceFile($tempFile);
    exit;
}

// Normal form processing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Specify a custom temporary directory path
  $tempDir = $predDir . '/design';

  // Retrieve the submitted sequences from the textarea
  $sequences = $_POST['sequences'];

  // Retrieve the uploaded files
  $files = $_FILES['files'];

  // Process sequences from the textarea
  if (!empty($sequences)) {
    // Generate a unique filename for the temporary sequence file
    $tempFile = $tempDir . '/sequences_' . uniqid() . '.fasta';
    file_put_contents($tempFile, $sequences);
    processSequenceFile($tempFile);
  }

  // Process uploaded files
  if (!empty($files['tmp_name'][0])) {
    // Create an array to store the temporary file paths
    $tempFiles = [];

    // Save each uploaded file to a temporary file in the custom directory
    foreach ($files['tmp_name'] as $index => $tmpName) {
      $tempFile = $tempDir . '/file_' . uniqid() . '.fasta';
      move_uploaded_file($tmpName, $tempFile);
      $tempFiles[] = $tempFile;
      processSequenceFile($tempFile);
    }
  }
}

function processSequenceFile($tempFile) {
  // Get the Pred directory path
  $predDir = getenv('PRED_DIR');
  $tempDir = $predDir . '/design';
  
  // Read the sequence from the temporary file
  $sequence = file_get_contents($tempFile);

  // Remove the FASTA header line
  $sequence = preg_replace('/>.*/', '', $sequence);

  // Remove any whitespace and newlines
  $sequence = trim(preg_replace('/\s+/', '', $sequence));

  // Convert the sequence to uppercase
  $sequence = strtoupper($sequence);

  // Store the input sequence for later reference
  file_put_contents($tempDir . '/last_input_sequence.txt', $sequence);

  // Check the length of the sequence
  $sequenceLength = strlen($sequence);
  if ($sequenceLength < 5 || $sequenceLength > 50) {
    echo "<div style='text-align:center; margin-top:50px; font-family:Arial, sans-serif;'>";
    echo "<h2>Error</h2>";
    echo "<p>Sequence length should be between 5 and 50 amino acids.</p>";
    echo "<p><a href='javascript:history.back()'>Go Back</a></p>";
    echo "</div>";
    exit;
  }

  // Putting sequence back into tempFile
  file_put_contents($tempFile, $sequence);

  // Generate a unique ID for this processing job
  $jobId = uniqid('job_');
  
  // Get the directory of the temporary file
  $tempFileDir = dirname($tempFile);

  // Move the temporary file to the desired folder with .fasta extension
  $queryFile = $tempFileDir . '/output_sequence.fasta';
  rename($tempFile, $queryFile);

  // Set the working directory to the Python script directory
  chdir($tempDir);

  // Get the Python wrapper path
  $pythonExe = getenv('PYTHON_EXECUTABLE');
  
  // Execute Python scripts - capture output but don't display
  $fasta = shell_exec($pythonExe . ' fasta_creation.py 2>&1');
  $design = shell_exec('./modify_sequences.sh 2>&1');
  $output = shell_exec('./calc_features_design.sh 2>&1');
  $featuresOutput_rdm = shell_exec($pythonExe . ' features_design_rdm.py 2>&1');
  $featuresOutput_swp = shell_exec($pythonExe . ' features_design_swp.py 2>&1');
  
  // Check for errors but don't display output unless there's an error
  $hasErrors = false;
  if ($featuresOutput_rdm === null || $featuresOutput_swp === null) {
      $hasErrors = true;
  }

  // Determine which Python script to run based on the selected model
  if (isset($_POST['model'])) {
    $model = $_POST['model'];
  } elseif (isset($_GET['model'])) {
    $model = $_GET['model'];
  } else {
    // Set a default model if none is selected
    $model = 'all_features_randomfeatures';
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
    echo "<div style='text-align:center; margin-top:50px; font-family:Arial, sans-serif;'>";
    echo "<h2>Error</h2>";
    echo "<p>Invalid model selected.</p>";
    echo "<p><a href='javascript:history.back()'>Go Back</a></p>";
    echo "</div>";
    exit;
  }

  // Construct the Python command
  $pythonCommand = $pythonExe . ' ' . $pythonScript . ' 2>&1';
  
  // Execute the Python script
  $pythonOutput = shell_exec($pythonCommand);

  // Check for errors with the Python script
  if ($pythonOutput === null) {
      $hasErrors = true;
  }

  // Create a job-specific results file by copying design.csv
  $currentDir = getcwd();
  $designCsvPath = $currentDir . '/design.csv';
  $jobSpecificPath = $currentDir . '/design_' . $jobId . '.csv';
  
  if (file_exists($designCsvPath)) {
      // Copy the design.csv to a job-specific file
      copy($designCsvPath, $jobSpecificPath);
      
      // Store the job-specific path for the results page
      file_put_contents($currentDir . '/path_info.txt', $jobSpecificPath);
  } else {
      $hasErrors = true;
  }

  // If there were errors, show an error page
  if ($hasErrors) {
    echo "<div style='text-align:center; margin-top:50px; font-family:Arial, sans-serif;'>";
    echo "<h2>Error Processing Peptide Design</h2>";
    echo "<p>We encountered an error while processing your request. Please try again later.</p>";
    echo "<p><a href='javascript:history.back()'>Go Back</a></p>";
    echo "</div>";
    exit;
  }

  // Redirect directly to the results page without showing a loading page
  header("Location: result_pep_design.php?model=" . urlencode($model) . "&job_id=" . urlencode($jobId) . "&sequence=" . urlencode($sequence));
  exit;
}
?>