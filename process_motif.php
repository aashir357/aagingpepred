<?php
   

  // Start output buffering to prevent any output until we're ready
  ob_start();


      $config = require_once __DIR__ . '/config.php';
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);

      

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Specify a custom temporary directory path
  $predDir = getenv('PRED_DIR');
  $tempDir = $predDir . '/motif_scanning';
  
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
  if ($sequenceLength < 5 || $sequenceLength > 50) {
    echo "Sequence length should be between 5 and 50 amino acids.";
    return;
  }

  // Get the directory of the temporary file
  $tempFileDir = dirname($tempFile);

  // Move the temporary file to the desired folder with .fasta extension
  $queryFile = $tempFileDir . '/motif.fasta';
  rename($tempFile, $queryFile);

 // Clear any output buffer
 ob_end_clean();

 // Simply redirect to the results page 
  header("Location:result_motif.php");
  exit();
}
?>