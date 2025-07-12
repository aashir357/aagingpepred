<!doctype html>
<html lang="en">
  
<?php include ("header.html")?>
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">



<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<style>

    .red-text { color: red; }


table{
  margin: 0 auto;
  width: 100%;
  border-collapse: collapse;
  text-align: left;
  overflow: visible;
}
 td, th{
    border-top: 1px solid #ECF0F1;
    padding: 10px;
  }
  
  td{
    border-left: 1px solid #ECF0F1;
    border-right: 1px solid #ECF0F1;
  }
  
  th{
    background-color: #4ECDC4;
  }
  
  tr:nth-of-type(even) td{
    background-color:#d7faf7;
  }
  
  .total{
    th{
      background-color: white;
    }
    
    td{
      text-align: right;
      font-weight: 700;
    }
  }

  .mobile-header{
    display: none;
  }

@media only screen and (max-width: 760px){
  p{
    display: block;
    font-weight: bold;
  }
  
  table{
    tr{
      td:not(:first-child), th:not(:first-child), td:not(.total-val){
        display: none;
      }
      
      &:nth-of-type(even) td:first-child{
        background-color: #4ECDC4;
      }
      &:nth-of-type(odd) td:first-child{
        background-color: white;
      }
      
      &:nth-of-type(even) td:not(:first-child){
        background-color: white;
      }
      
      th:first-child{
        width: 100%;
        display:block;
      }
      
      th:not(:first-child){
        width: 40%;
        transition: transform 0.4s ease-out;
        transform:translateY(-9999px);
        position: relative;
        z-index: -1;
      }
      
      td:not(:first-child){
        transition: transform 0.4s ease-out;
        transform:translateY(-9999px);
        width: 60%;
        position: relative;
        z-index: -1;
      }
      
      td:first-child{
        display: block;
        cursor: pointer;
      }
      
      &.total th{
        width: 25%;
        display: inline-block;
      }
      
      td.total-val{
        display: inline-block;
        transform: translateY(0);
        width: 75%;
      }
    }
  }
}

@media only screen and (max-width: 300px){
  table{
    tr{
      th:not(:first-child){
        width: 50%;
        font-size: 14px;
      }
      
      td:not(:first-child){
        width: 50%;
        font-size: 14px;
      }
    }
  }
}
    </style>
<?php
$config = require_once __DIR__ . '/config.php';
if (isset($_GET['sequence'])) {
    // Retrieve the sequence from the URL parameter
    $sequence = urldecode($_GET['sequence']);
    
    // Use $sequence as needed, for example, you can echo it
    echo "Sequence: $sequence";
} else {
    // Handle the case when the sequence parameter is not provided
    echo "Sequence parameter is missing.";
}
?>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Retrieve the sequence from the URL parameter
$sequence = $_GET['sequence'];

// Verify that the sequence is not empty
if (empty($sequence)) {
    echo "Error: Sequence parameter is missing.";
    exit();
}

// Create the FASTA content
$fastaContent = ">protein_seq\n" . $sequence;

// Save the sequence to a temporary FASTA file

$tempFastaFileName = '/opt/lampp/htdocs/cgntlab/aagingpepred/aagingpepred/Pred/protein_mutant/protein_design.fasta';
file_put_contents($tempFastaFileName, $fastaContent);

  // Set the working directory to the Python script directory
  $predDir = getenv('PRED_DIR');
  $tempDir = $predDir . '/protein_mutant';
  chdir($tempDir); 
 

  $design = shell_exec('./protein_modify_sequences.sh 2>&1');
  //echo "$design";
  // Execute the shell script, passing the environment variable explicitly
  $output = shell_exec('./protein_design_calc_features.sh 2>&1');
  //echo "$output";

  $featuresOutput_rdm = shell_exec('python3 features_design_rdm.py 2>&1');
  $featuresOutput_swp = shell_exec('python3 features_design_swp.py 2>&1');
  
  $predDir = getenv('PRED_DIR');
  $pythonCommand2 = 'python3 ' . $predDir . '/protein_mutant/model_prediction_rfe_features_random.py 2>&1';
  $pythonOutput2 = shell_exec($pythonCommand2);
  $pythonCommand3 = 'python3 ' . $predDir . '/protein_mutant/model_prediction_rfe_features_swissprot.py 2>&1';
  $pythonOutput3 = shell_exec($pythonCommand3);


  //echo "<pre>$pythonOutput2</pre>";
  
  //if ($pythonOutput2 === null) {
      //echo "Error executing Python script 2.";
  //}


  // Read and display the CSV file in a sortable HTML table
  $csvFile = $predDir . '/protein_mutant/prediction.csv';  $headers = [];
  $data = [];
  
  if (($handle = fopen($csvFile, 'r')) !== false) {
      $headers = fgetcsv($handle);
      while (($row = fgetcsv($handle)) !== false) {
          $data[] = $row;
      }
      fclose($handle);
  } else {
      echo "Error opening file: $csvFile";
  }
  ?>


<section class="explore-section section-padding" id="section_2" style="padding-bottom: 50px;">
<div class="container">
<div class="col-12 text-center">
<h2 class="mb-4">Protein mutants result page</h2>
<hr>
</div>

<table id="csvTable" class="display">
                  <thead>
                      <tr>
                          <?php
                          foreach ($headers as $header) {
                              echo '<th>' . $header . '</th>';
                          }
                          ?>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                     // Output data rows
foreach ($data as $index => $row) {
  echo '<tr>';
  foreach ($row as $key => $value) {
      echo '<td>';
      
      // Check if the current column is the 'Sequence' column
      if ($headers[$key] === 'Sequence') {
          // Apply color based on the specified conditions
          echo applyColorToSequence($value, $index);
      } else {
          // Output other columns
          echo $value;
      }

      echo '</td>';
  }
  echo '</tr>';
}

echo '</tbody>';
echo '</table>';

// Function to apply color to sequence based on row index
function applyColorToSequence($sequence, $index) {
  if ($index >= 1 && $index <= 19) {
      // Apply red color to the first letter for rows 2 to 20
      return '<span class="red-text">' . substr($sequence, 0, 1) . '</span>' . substr($sequence, 1);
  } elseif ($index >= 20 && $index <= 39) {
      // Apply red color to the second letter for rows 21 to 39
      return substr($sequence, 0, 1) . '<span class="red-text">' . substr($sequence, 1, 1) . '</span>' . substr($sequence, 2);
  } elseif ($index >= 40) {
      // Apply red color to the third letter for rows 40 and beyond
      return substr($sequence, 0, 2) . '<span class="red-text">' . substr($sequence, 2, 1) . '</span>' . substr($sequence, 3);
  } else {
      // No coloring for other rows
      return $sequence;
  }
}

// Create a temporary download file path
$downloadFileName = 'download.csv';
$downloadFilePath = $tempDir . '/downloads/' . $downloadFileName;

// Save the CSV data to the download file
$handle = fopen($downloadFilePath, 'w');
fputcsv($handle, $headers); // Write headers to the file
foreach ($data as $row) {
    fputcsv($handle, $row);
}
fclose($handle);

// Provide the download link to the user
echo '<a href="' . $tempDir . '/downloads/' . $downloadFileName . '" download>Download CSV</a>';

                      ?>
                  </tbody>
              </table>
             


    
</div>
</section>
</main>

<?php include ("footer.html")?>
<?php
              // Include DataTables library
              echo '<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>';
              // Initialize DataTable
              echo '<script>
                  $(document).ready(function() {
                      $("#csvTable").DataTable({
                          "order": [] // Disable initial sorting
                      });
                  });
              </script>';
              ?>
    </body>
</html>
