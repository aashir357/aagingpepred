<!doctype html>
<html lang="en">
  
<?php include ("header.html")?>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script type="text/javascript" src="https://cdn.canvasjs.com/canvasjs.min.js"></script>


<style>
.tabs2 {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #ddeff0;
    padding: 20px;
    font-size: medium;
    font-weight: bold;
}
.container1 {
     width: 100%;
     padding-right: 40px;
     padding-left: 40px;
     margin-right: auto;
     margin-left: auto;
 }

    .red-text { color: red; }
    .services_section_2 {
    width: 100%;
   float: left;
   margin-left: auto;
   margin-right: auto;
}

table{
  margin: 0 auto;
  width: 100%;
  border-collapse: collapse;
  text-align: left;
  overflow: visible;
  margin-left: auto;
  margin-right: auto;
}
 td, th{
    border-top: 1px solid #ECF0F1;
    padding: 10px;
  }
  
  td{
    border-left: 1px solid #ECF0F1;
    border-right: 1px solid #ECF0F1;
    border-bottom: 1px solid #111212;
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

.card-deck:has( > .card:hover ) .card:not(:hover){
  opacity: .5;
}
.services_item {
    width: 100%;
    float: center;
    margin-top: 20px;
}
.layout_padding {
    padding-top: 60px;
    padding-bottom: 0px;
    padding-left: 20px;
    padding-right: 20px;
}
.container{
    padding-left: 5px;
    padding-right: 5px;
}

.row1{
  /*padding-left: 20px;
    padding-right: 20px;*/
    margin-right: 20px;
    margin-left: 20px;
}
.container{
    margin-right: auto;
    margin-left: auto;
}
/*.card {
  background: #2196F3;
  aspect-ratio: 9/5;
  border-radius: 1rem;
  transition: opacity .2s;
}*/

.card {
  height: 400px;
  text-align: center;
  width: 100%;
  margin-right: 15px;
    margin-bottom: 0;
    margin-left: 15px;
  box-shadow: 0 5px 9px 0 #0000008c;
  border-radius: 8px;
}
.card-deck {
  /*background-color: #9e9e9e17;*/
  display: grid;
  gap: 1rem;
  grid-template-columns: repeat( 2, 1fr);
  padding: 1rem;
  margin-right: 15px;
    margin-bottom: 0;
    margin-left: 15px;
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
// Include the configuration
$config = require_once __DIR__ . '/config.php';

if (isset($_GET['sequence'])) {
    // Retrieve the sequence from the URL parameter
    $sequence = urldecode($_GET['sequence']);
    //echo $sequence;
    // Use $sequence as needed, for example, you can echo it
    //echo "Sequence: $sequence";
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

// Get paths from environment variables
$predDir = getenv('PRED_DIR');
$projectDir = getenv('PROJECT_DIR');

// Create the FASTA content
$fastaContent = ">Seq\n" . $sequence;

// Save the sequence to a temporary FASTA file
$tempFastaFileName = $predDir . '/pep_card/pep_card.fasta';
file_put_contents($tempFastaFileName, $fastaContent);

// Also save a copy to query.fasta for the composition generator
$queryFastaFileName = $predDir . '/pep_card/query.fasta';
file_put_contents($queryFastaFileName, $fastaContent);

// Set the working directory to the Python script directory
chdir($predDir . '/pep_card');

// Get the Python executable from config
$pythonExe = getenv('PYTHON_EXECUTABLE');

// Execute the shell script for feature calculation
$output = shell_exec('cd ' . $predDir . '/pep_card && ./pep_card_calc_features.sh 2>&1');

// Generate fresh composition data directly from the input sequence
// Add this new line to generate composition data
$genCompCommand = 'cd ' . $predDir . '/pep_card && ' . $pythonExe . ' generate_composition.py 2>&1';
$genCompOutput = shell_exec($genCompCommand);

// Run the existing scripts to process the data
$pythonCommand3 = 'cd ' . $predDir . '/pep_card && ' . $pythonExe . ' pep_card_csv.py 2>&1';
$pythonOutput3 = shell_exec($pythonCommand3);

$pythonCommand = 'cd ' . $predDir . '/pep_card && ' . $pythonExe . ' canvas_js.py 2>&1';
$pythonOutput = shell_exec($pythonCommand);

?>
 
<!----------------------------------------------------------CARD DISPLAY----------------------------------------------------------------------------------------->
<section class="explore-section section-padding" id="section_2" style="padding-bottom: 50px;">
<div class="container1">
<div class="col-12 text-center">
<h2 class="mb-4">Peptide Card</h2>
<hr>
</div>

          
<div class="row1">
          
<?php
$predDir = getenv('PRED_DIR');
$csvFile = $predDir . '/pep_card/Card_features.csv'; // Update path with environment variable
$headers = [];
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

<!--------------------------------------Data table----------------------------------------------------------------------------------------------------------------------->

<?php
//Output DataTable

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
        
        // Check if the current column is the 'Sequence' column
        if ($headers[$key] === 'Sequence') {
            // Make the sequence clickable
            //echo '<a class="sequence-link" href="pep_card.php?sequence=' . urlencode($value) . '">' . $value . '</a>';
            echo '<a class="sequence-link" href="process_pep_mutant_card.php?sequence=' . urlencode($value) . '&model=' . urlencode($_GET['model']) . '">' . $value . '</a>';
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

<?php
$predDir = getenv('PRED_DIR');

// Create a temporary download file path
$downloadFileName = 'download.csv';
$downloadFilePath = $predDir . '/pep_card/downloads/' . $downloadFileName;
// Save the CSV data to the download file
$handle = fopen($downloadFilePath, 'w');
fputcsv($handle, $headers); // Write headers to the file
foreach ($data as $row) {
    fputcsv($handle, $row);
}
fclose($handle);
// Provide the download link to the user - using relative path for browser access
echo '<a href="Pred/pep_card/downloads/' . $downloadFileName . '" download>Download CSV</a>';
?>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<br><br>
        <div class=tabs2><h3> Compositions</h3></div>
          <div class="card-deck">
  <div class="card"> 
  
  
  
  
  
  
  <script>
        // Function to fetch CSV data and create the first chart (Amino Acid Composition)
        function createChart1() {
            // Add a timestamp to prevent caching
            var timestamp = new Date().getTime();
            $.get('Pred/pep_card/card_aac_vertical.csv?t=' + timestamp, function(data) {
                var dataPoints = getDataPointsFromCSV(data);

                // Create a new chart
                var chart = new CanvasJS.Chart('chartContainer1', {
                    title: {
                        text: 'Amino Acid Composition',
                        fontFamily: "Times New Roman",
                        fontColor: "blue",
                        fontSize: 20,
                    },
                    axisY: {
                        title: 'Composition',
                        suffix: '%',
                        titleFontColor: "blue",
                        titleFontFamily: "Times New Roman",
                        titleFontSize: 20,
                    },
                    axisX: {
                        title: 'Amino Acids',
                        titleFontColor: "blue",
                        interval: 1,
                        titleFontFamily: "Times New Roman",
                        titleFontSize: 20,
                    },
                    data: [{
                        type: 'column',
                        dataPoints: dataPoints
                    }]
                });

                // Render the chart
                chart.render();
            });
        }

        // Function to parse CSV data and extract data points
        function getDataPointsFromCSV(csv) {
            var dataPoints = [];
            var csvLines = csv.split(/\r\n|\n|\r/);

            for (var i = 1; i < csvLines.length; i++) {
                if (csvLines[i].length > 0) {
                    var points = csvLines[i].split(',');
                    dataPoints.push({
                        label: points[0],
                        y: parseFloat(points[1])
                    });
                }
            }

            return dataPoints;
        }

        // Call the function to create the first chart
        createChart1();
</script>

<div id="chartContainer1" style="width:100%; height:400px;"></div>
  </div> 
  <div class="card"> 
  <script>
        // Function to fetch CSV data and create the chart
        function createChart() {
            $.get('Pred/pep_card/Card_SS_Vertical.csv', function(data) {
                var dataPoints = getDataPointsFromCSV(data);

                // Create a new chart
                var chart = new CanvasJS.Chart('chartContainer2', {
                    title: {
                        text: 'Secondary Structure Fraction',
                        fontFamily: "Times New Roman",
                        fontColor: "blue",
                        fontSize: 20,
                    },
                    axisY: {
                        title: 'Composition',
                        suffix: '%',
                        titleFontColor: "blue",
                        titleFontFamily: "Times New Roman",
                        titleFontSize: 20,
                    },
                    axisX: {
                        title: 'Amino Acids',
                        titleFontColor: "blue",
                        interval: 1,
                        titleFontFamily: "Times New Roman",
                        titleFontSize: 20,
                    },
                    data: [{
                        type: 'pie',
                        dataPoints: dataPoints
                    }]
                });

                // Render the chart
                chart.render();
            });
        }

        // Function to parse CSV data and extract data points
        function getDataPointsFromCSV(csv) {
            var dataPoints = [];
            var csvLines = csv.split(/\r\n|\n|\r/);

            for (var i = 1; i < csvLines.length; i++) {
                if (csvLines[i].length > 0) {
                    var points = csvLines[i].split(',');
                    dataPoints.push({
                        label: points[0],
                        y: parseFloat(points[1])
                    });
                }
            }

            return dataPoints;
        }






        // Call the function to create the chart
        createChart();
    </script>
<div id="chartContainer2" style="width:100%; height:400px;"></div>
  </div> 
  </div>
    </div>
    </div>
</section>
</main>

<?php include ("footer.html")?>

    </body>
</html>
