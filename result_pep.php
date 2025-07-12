<!doctype html>
<html lang="en">
<link href="DataTables/datatables.min.css" rel="stylesheet">
 
 <script src="DataTables/datatables.min.js"></script>
 
 
 <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
 <!-- DataTables CSS -->
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
 <!-- DataTables JS -->
 <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
 <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  
<?php include ("header.html")?>

<style>

#csvTable {
        margin: 0 auto; /* Center the table horizontally */
        width: 80%; /* Set the width of the table, adjust as needed */
       
    }

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
  .container1 {
     width: 100%;
     padding-right: 40px;
     padding-left: 40px;
     margin-right: auto;
     margin-left: auto;
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

.row1 {
    display: flex;
    flex: wrap;
    flex-wrap: wrap;
    flex-direction: row-reverse;
    justify-content: center;
    align-items: center;
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
<!-----------------------------------------------------------------------------------STYLING ENDS---------------------------------------------------------------->


<section class="explore-section section-padding" id="section_2" style="padding-bottom: 50px;">
<div class="container1">
<div class="col-12 text-center">
<h2 class="mb-4">Result page</h2>
<hr>
</div>

<?php
$config = require_once __DIR__ . '/config.php';


// Debug - Let's see what paths we're working with
echo "<!-- Debug Info: -->";
echo "<!-- Pred Dir: " . getenv('PRED_DIR') . " -->";

// Get the Pred directory path
$predDir = getenv('PRED_DIR');

// Fix the path to the CSV file - use the full path with $predDir
$csvFile = $predDir . '/peptide/prediction.csv';

// Debug - Check if the file exists
echo "<!-- CSV File Path: " . $csvFile . " -->";
echo "<!-- File exists: " . (file_exists($csvFile) ? "YES" : "NO") . " -->";




// Initialize arrays
$headers = [];
$data = [];
$model = urldecode($_GET['model']);
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
    echo '<th>' . $header . '</th>';
}

echo '</tr></thead>';
echo '<tbody>';

// Output data rows
foreach ($data as $row) {
  echo '<tr>';
  foreach ($row as $key => $value) {
      echo '<td>';
      
      // Check if the current column is the 'sequence' column (lowercase 's')
      if ($headers[$key] === 'Sequence') {
          // Make the sequence clickable
          echo '<a class="sequence-link" href="pep_card.php?sequence=' . urlencode($value) . '&model=' . urlencode($_GET['model']) . '">' . $value . '</a>';
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


?>
<!-- Add a client-side download button -->
<div style="text-align: center; margin-top: 20px;">
<a href="#" id="downloadButton" class="btn-download">Download CSV</a></div>

<script>
document.getElementById('downloadButton').addEventListener('click', function() {
    // Create CSV content
    let csvContent = "data:text/csv;charset=utf-8,";
    
    // Add headers
    csvContent += "<?php echo implode(",", $headers); ?>\r\n";
    
    // Add data rows
    <?php foreach($data as $row): ?>
    csvContent += "<?php echo implode(",", array_map(function($cell) { return str_replace('"', '""', $cell); }, $row)); ?>\r\n";
    <?php endforeach; ?>
    
    // Create download link
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "prediction_data.csv");
    document.body.appendChild(link);
    link.click();
});
</script>




    
</div>
</section>
</main>

<?php include ("footer.html")?>
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
