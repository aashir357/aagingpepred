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

<section class="explore-section section-padding" id="section_2" style="padding-bottom: 50px;">
<div class="container">
<div class="col-12 text-center">
<h2 class="mb-4">Mutant peptides</h2>
<hr>
</div>

<div class="row1">
<?php
// Include the configuration file
$config = require_once __DIR__ . '/config.php';

// Get the Pred directory from config
$predDir = getenv('PRED_DIR');

// Set the path to the CSV file using the environment variable
$csvFile = $predDir . '/mutant_card/design.csv';

// Initialize arrays
$headers = [];
$data = [];

// Read CSV file
if (file_exists($csvFile) && ($handle = fopen($csvFile, 'r')) !== false) {
    // Read the header row
    $headers = fgetcsv($handle);

    // Read and store each row of data
    while (($row = fgetcsv($handle)) !== false) {
        $data[] = $row;
    }

    fclose($handle);
} else {
    echo "Error opening file: $csvFile";
    // Additional debugging info
    echo "<p>The file does not exist or cannot be read.</p>";
    echo "<p>Check path: " . $csvFile . "</p>";
    echo "<p>PRED_DIR setting: " . $predDir . "</p>";
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
foreach ($data as $index => $row) {
    echo '<tr>';
    foreach ($row as $key => $value) {
        echo '<td>';
        
        // Check if the current column is the 'Sequence' column
        if ($headers[$key] === 'Sequence') {
            // Create a link for the sequence with model parameter
            $model = isset($_GET['model']) ? urlencode($_GET['model']) : '';
            echo '<a class="sequence-link" href="pep_card.php?sequence=' . urlencode($value) . '&model=' . $model . '">' . applyColorToSequence($value, $index) . '</a>';
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

// Client-side download solution instead of server-side file creation
?>
<!-- Add a client-side download button -->
<div style="text-align: center; margin-top: 20px;">
    <a href="#" id="downloadButton" class="btn btn-primary" style="padding: 10px 20px; background-color: #4ECDC4; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">Download CSV</a>
</div>

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
    link.setAttribute("download", "mutant_peptides.csv");
    document.body.appendChild(link);
    link.click();
});
</script>

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