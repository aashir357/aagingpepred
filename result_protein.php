<!doctype html>
<html lang="en">
<link href="DataTables/datatables.min.css" rel="stylesheet">
 
<script src="DataTables/datatables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
 
<?php include ("header.html")?>

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

.btn-download {
    padding: 10px 20px;
    background-color: #4ECDC4;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-weight: bold;
    border: 1px solid #4ECDC4;
}

.btn-download:hover {
    background-color: #3db8b8;
    border-color: #3db8b8;
}




</style>

<section class="explore-section section-padding" id="section_2" style="padding-bottom: 50px;">
<div class="container">
<div class="col-12 text-center">
<h2 class="mb-4">Result for protein scanning</h2>
<hr>
</div>

<div class="row1">

<?php
$csvFile = 'Pred/protein_scanning/prediction.csv';  // Change this to your CSV file name

// Initialize arrays
$headers = [];
$data = [];

// Read CSV file
if (($handle = fopen($csvFile, 'r')) !== false) {
    // Read the header row
    $headers = fgetcsv($handle);
    
    // Read and store each row of data
    while (($row = fgetcsv($handle)) !== false) {
        $data[] = $row;
    }

    fclose($handle);
} else {
    echo "Error opening file: $csvFile";
}

// Output DataTable
echo '<table id="csvTable" class="display">';
echo '<thead><tr>';

// Output header columns
foreach ($headers as $header) {
    echo '<th>' . htmlspecialchars($header) . '</th>';
}

echo '</tr></thead>';
echo '<tbody>';

// Output data rows
foreach ($data as $row) {
    echo '<tr>';
    foreach ($row as $key => $value) {
        echo '<td>';
        
        // Check if the current column is the 'Sequence' column
        if ($headers[$key] === 'Sequence') {
            // Make the sequence clickable
            $modelParam = isset($_GET['model']) ? $_GET['model'] : '';
            echo '<a class="sequence-link" href="pep_card.php?sequence=' . urlencode($value) . '&model=' . urlencode($modelParam) . '">' . htmlspecialchars($value) . '</a>';
        } else {
            // Output other columns
            echo htmlspecialchars($value);
        }
        
        echo '</td>';
    }
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

// Create downloads directory
$downloadsDir = dirname($csvFile) . '/downloads';
if (!is_dir($downloadsDir)) {
    mkdir($downloadsDir, 0755, true);
}

// Set up download file
$downloadFileName = 'download_' . uniqid() . '.csv';
$downloadFilePath = $downloadsDir . '/' . $downloadFileName;

// Save CSV data to download file
$handle = fopen($downloadFilePath, 'w');
fputcsv($handle, $headers);
foreach ($data as $row) {
    fputcsv($handle, $row);
}
fclose($handle);

// Provide the download link
$relativeDownloadPath = 'Pred/protein_scanning/downloads/' . $downloadFileName;
echo '<div style="margin-top: 20px; text-align: center;">';
echo '<a href="' . $relativeDownloadPath . '" download class="btn-download">Download CSV</a>';echo '</div>';
?>

</div>
</div>
</section>
</main>

<?php include ("footer.html")?>
<!--------------------------------------------ALWAYS KEEP THE SORTING, FILTERING DATATABLE SCRIPT AFTER FOOTER------------------>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#csvTable').DataTable({
            "order": [] // Disable initial sorting
        });
    });
</script>
</body>
</html>