<!doctype html>
<html lang="en">
  
<?php include ("header.html")?>

<section class="explore-section section-padding" id="section_2" style="padding-bottom: 50px;">
<div class="container">
<div class="col-12 text-center">
<h2 class="mb-4">Motif alignment result</h2>
<hr>
</div>


<?php
$config = require_once __DIR__ . '/config.php';
// Get environment paths
$predDir = getenv('PRED_DIR');
$memeDir = getenv('MEME_DIR');
$embossDir = getenv('EMBOSS_DIR');
$ssearchDir = getenv('SSEARCH_DIR');
$projectDir = getenv('PROJECT_DIR');

// Set the working directory to the motif scanning directory
chdir($predDir . '/motif_scanning');

// Write sequence to FASTA file
$file_name = $predDir . '/motif_scanning/motif.fasta';

// Commented lines updated with environment variables
#$a = shell_exec($embossDir . "/water -asequence " . $projectDir . "/tmp_blastp_short/sequence.fasta -bsequence " . $projectDir . "/tmp_blastp_short/peptide_seq.fasta -outfile " . $projectDir . "/tmp_blastp_short/alignment.txt -gapopen 10 -gapextend 10 2>&1");
#$a = shell_exec($ssearchDir . "/ssearch36 -m 8 -f -g -2 -s BL62 -n -W 3 " . $projectDir . "/tmp_blastp_short/sequence.fasta " . $projectDir . "/tmp_blastp_short/peptide_seq.fasta > " . $projectDir . "/tmp_blastp_short/ssearch.txt 2>&1");

// Run MEME tools
$a = shell_exec($memeDir . "/bin/mast " . $predDir . "/motif_scanning/motifs.meme " . $predDir . "/motif_scanning/motif.fasta -o " . $predDir . "/motif_scanning/mast_output -mt 0.1 2>&1");

// Extract lines from mast.txt
$output = shell_exec("tail -n +61 " . $predDir . "/motif_scanning/mast_output/mast.txt > " . $predDir . "/motif_scanning/mast_output/mast_extracted.txt");

// Check if mast_extracted.txt file exists and is readable
$mast_output_file = "./mast_output/mast_extracted.txt";
if (file_exists($mast_output_file) && is_readable($mast_output_file)) {
    // Get contents of mast_extracted.txt file
    $mast_output = file_get_contents($mast_output_file);
    
    // Display mast output
    echo "<div class='container'>";
    echo "<div id='content'>";
    // Commented heading
    //echo  "<h3 style='margin:20px; text-align: center;'>Smith-Waterman similarity search result</h3>";
    //echo  "<hr class='new'>";   
    echo "</div>";
    
    echo "<pre>$mast_output</pre>";
    
    echo "</div>";
}
?>

</div>
</section>
</main>

<?php include ("footer.html")?>

    </body>
</html>