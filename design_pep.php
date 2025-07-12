<!doctype html>
<html lang="en">

<!------------------------------------------------------------------------------------PROCESSING END-------------------------------------------------------------------------------->


<?php include ("header.html")?>

<style>
   .explore-section section-padding{
    padding-bottom: 10px;
   }

    .center {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .row1 {
    display: flex;
    flex-direction: row-reverse;
    flex-wrap: wrap;
    align-content: center;
    justify-content: center;
    align-items: center;
}
 
   
    /* Adjust form-floating class to ensure placeholder visibility */
    .form-floating .form-control::placeholder {
  color: #6c757d; /* Placeholder text color */
}

.example-button {
  background-color: #667fa5;
  border: 1px solid #ece5e5;
  color: #ebf1f3;
  text-decoration: none;
  transition: background-color 0.3s ease;
  padding: 1px 6px;
  border-radius: 15px;
}

.example-button:hover {
  background-color: #000000;
  color: #ffffff;
}


</style>

<script type="text/javascript">
function pasteExample() {
    var fastaFormat = ">seq1\nYPSKPDNPGEDAPAEDMARYYSALRHYINLITRQRY";
    document.getElementsByName("sequences")[0].value = fastaFormat;
    
    // Select a default model
    document.getElementById("all_features_randomfeatures").checked = true;
    
    return false; // Prevent form submission
}

function validateForm() {
    var sequences = document.getElementsByName("sequences")[0].value;
    var files = document.querySelector('input[type="file]').files;
    var model = document.querySelector('input[name="model"]:checked');
    
    if (!sequences.trim() && files.length === 0) {
        alert("Please enter a sequence or upload a FASTA file");
        return false;
    }
    
    if (!model) {
        alert("Please select a model");
        return false;
    }
    
    return true;
}

// Automatically call the pasteExample() function
pasteExample();
</script>

<section class="explore-section section-padding" id="section_2" style="padding-bottom: 50px;">
<div class="container">
<div class="col-12 text-center">
<h2 class="mb-4">Design page
</h1><hr></div>

    <section class="section-padding section-bg">
                <div class="container">
                    <div class="row1">

                        <div class="col-lg-12 col-12">
                            <h3 class="mb-4 pb-2" style="text-align:center">Query submission</h3>
                        </div>

                        <div class="col-lg-6 col-12">
                            <form action="process_pep_design.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" class="custom-form contact-form" role="form">
                                <div class="row">
    
                                        <div class="form-floating">
                                            <textarea class="form-control" name="sequences" rows="4" cols="50" placeholder="Enter your sequences in FASTA format (5-50 aa)"></textarea><br> 
                                        </div>
                                        <div>
                                        <button type="button" class="example-button" onclick="pasteExample()">Example</button><br><br>
                                        <label for="files">Upload Sequence File :</label>
                                        <input type="file" name="files[]" multiple><br></div>
                                    </div><br><br>
<div>
    <p>Select a model<span id="model_required" style="color: red;">*</span>:</p>
    <input type="radio" id="all_features_randomfeatures" name="model" value="all_features_randomfeatures" class="radio-spacing" checked>
                                    <label for="all_features_randomfeatures">All features Random_Features</label>

                                    <input type="radio" id="all_features_swissprot" name="model" value="all_features_swissprot" class="radio-spacing">
                                    <label for="all_features_swissprot">All features SwissProt</label><br>

                                    <input type="radio" id="rfe_features_randomfeatures" name="model" value="rfe_features_randomfeatures" class="radio-spacing">
                                    <label for="rfe_features_randomfeatures">Selected features Random_Features</label>

                                    <input type="radio" id="rfe_features_swissprot" name="model" value="rfe_features_swissprot" class="radio-spacing">
                                    <label for="rfe_features_swissprot">Selected features SwissProt</label>
                                </div>
                                    <br><br>
                                
                                    <div class="col-lg-4 col-12 ms-auto">
                                        <button type="submit" class="form-control">Submit</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                
            </section>
</div>
</div>
                            
</div>
</section>
</main>

<?php include ("footer.html")?>

    </body>
</html>