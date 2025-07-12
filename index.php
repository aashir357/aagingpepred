<!DOCTYPE html>
<html lang="en">
  
<?php include ("header.html")?>
<style>
   .explore-section section-padding{
    padding-bottom: 10px;
   }
 .custom-block-image2 {
    display: block;
    width: 100%;
    height: 350px;
    margin-top: 5px;
}


.col-lg-6_1 {
    flex: 0 0 auto;
    width: 100%;
}
    </style>

<section class="explore-section section-padding" id="section_2" style="padding-bottom: 50px;">
                <div class="container">
<div class="col-12 text-center">
                            <h2 class="mb-4">Welcome to AagingPEPred</h1><hr>
                        </div>

                        <p style="text-align:justify">AagingPred is a machine learning-based tool designed to predict anti-aging peptides. 
					It employs models trained on descriptors that can be calculated from amino acid sequences. 
					The tool is capable of accepting peptide sequences in Fasta format, with lengths ranging from 5 to 50 amino acid residues.
				
				<p class="dummy_text">For detailed instructions on how to utilize the tool, users are advised to refer to the <a href="help.php">Help</a> page, which provides comprehensive information on the tool's usage,
 					features, and functionalities.</p>

					 <p class="dummy_text">To gain a deeper understanding of the methods and models employed by AagingPred, individuals can visit the <a href="model.php">Model</a> page. 
					This resource offers insights into the underlying techniques, algorithms, and data employed in the development of AagingPred's predictive models.</p>

</div>
<!--<div class="col-12 text-center mt-5">
                            
                                <a href="pep_pred.php" class="btn custom-btn custom-border-btn ms-3">PREDICT</a>
                           
                        </div>-->
</section>

            <section class="explore-section section-padding" id="section_2" style="padding-top: 10px;">
                <div class="container">
                    <div class="row">

                        <div class="col-12 text-center">
                            <h2 class="mb-4">Specifications</h1>
                        </div>

                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="design-tab" data-bs-toggle="tab" data-bs-target="#design-tab-pane" type="button" role="tab" aria-controls="design-tab-pane" aria-selected="true">Tools</button>
                            </li>

                            <!--<li class="nav-item" role="presentation">
                                <button class="nav-link" id="marketing-tab" data-bs-toggle="tab" data-bs-target="#marketing-tab-pane" type="button" role="tab" aria-controls="marketing-tab-pane" aria-selected="false">Visualization</button>
                            </li>-->

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="finance-tab" data-bs-toggle="tab" data-bs-target="#finance-tab-pane" type="button" role="tab" aria-controls="finance-tab-pane" aria-selected="false">Models</button>
                            </li>

                           <!-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="music-tab" data-bs-toggle="tab" data-bs-target="#music-tab-pane" type="button" role="tab" aria-controls="music-tab-pane" aria-selected="false">Music</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="education-tab" data-bs-toggle="tab" data-bs-target="#education-tab-pane" type="button" role="tab" aria-controls="education-tab-pane" aria-selected="false">Education</button>
                            </li>-->
                        </ul>
                    </div>
                </div>

                <div class="container">
                    <div class="row">

                        <div class="col-12">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="design-tab-pane" role="tabpanel" aria-labelledby="design-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="design_pep.php">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Design Peptides</h5>

                                                            <p class="mb-0">Create mutant anti-aging peptides</p>
                                                        </div>

                                                       <!-- <span class="badge bg-design rounded-pill ms-auto">14</span>-->
                                                    </div>

                                                    <!--<img src="images/topics/undraw_Remote_design_team_re_urdx.png" class="custom-block-image img-fluid" alt="">-->
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="protein_scan.php">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Protein Scanning</h5>

                                                                <p class="mb-0">Look for anti-aging fragments in a protein of interest</p>
                                                        </div>

                                                        <!--<span class="badge bg-design rounded-pill ms-auto">75</span>-->
                                                    </div>

                                                    <!--<img src="images/topics/undraw_Redesign_feedback_re_jvm0.png" class="custom-block-image img-fluid" alt="">-->
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="motif_scan.php">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Visualization</h5>

                                                                <p class="mb-0">Get to know the calculated physicochemical features of peptide of interest in graphical representations.</p>
                                                        </div>

                                                      <!--  <span class="badge bg-design rounded-pill ms-auto">100</span>-->
                                                    </div>

                                                   <!-- <img src="images/topics/colleagues-working-cozy-office-medium-shot.png" class="custom-block-image img-fluid" alt="">-->
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="marketing-tab-pane" role="tabpanel" aria-labelledby="marketing-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                                <div class="custom-block bg-white shadow-lg">
                                                    <a href="topics-detail.html">
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">Data tables</h5>

                                                                <p class="mb-0">Get to know the calculated physicochemical features of peptide of interest.</p>
                                                            </div>

                                                            <!--<span class="badge bg-advertising rounded-pill ms-auto">30</span>-->
                                                        </div>

                                                       <!-- <img src="images/topics/undraw_online_ad_re_ol62.png" class="custom-block-image img-fluid" alt="">-->
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                                <div class="custom-block bg-white shadow-lg">
                                                    <a href="topics-detail.html">
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">Amino acid compositions</h5>

                                                                <p class="mb-0">Graphical representation of amino acid compositions of the peptide of interest.</p>
                                                            </div>

                                                            <!--<span class="badge bg-advertising rounded-pill ms-auto">65</span>-->
                                                        </div>

                                                        <!--<img src="images/topics/undraw_Group_video_re_btu7.png" class="custom-block-image img-fluid" alt="">-->
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-12">
                                                <div class="custom-block bg-white shadow-lg">
                                                    <a href="topics-detail.html">
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">Secondary structure compositions</h5>

                                                                <p class="mb-0">Graphical representation of secondary structure compositions such as helix, turn and sheet fractions 
                                                                    of the peptide of interest.</p>
                                                            </div>

                                                            <!--<span class="badge bg-advertising rounded-pill ms-auto">50</span>-->
                                                        </div>

                                                        <!--<img src="images/topics/undraw_viral_tweet_gndb.png" class="custom-block-image img-fluid" alt="">-->
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                  </div>

                                <div class="tab-pane fade" id="finance-tab-pane" role="tabpanel" aria-labelledby="finance-tab" tabindex="0">   <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                       <!-- <div>
                                                            <h5 class="mb-2">Investment</h5>

                                                            <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                        </div>-->

                                                        <!--<span class="badge bg-finance rounded-pill ms-auto">30</span>-->
                                                    </div>

                                                    <img src="images/ROC_Random_481_RFC.png" class="custom-block-image2 img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <!--<div>
                                                            <h5 class="mb-2">Investment</h5>

                                                           <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                        </div>-->

                                                       <!--<span class="badge bg-finance rounded-pill ms-auto">30</span>-->
                                                    </div>

                                                    <img src="images/ROC_Random_RFE_RFC.png" class="custom-block-image2 img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>
   
                                        <!--<div class="col-lg-6 col-md-6 col-12">
                                            <div class="custom-block custom-block-overlay">
                                                <div class="d-flex flex-column h-100">
                                                    <img src="images/businesswoman-using-tablet-analysis-graph-company-finance-strategy-statistics-success-concept-planning-future-office-room.jpg" class="custom-block-image img-fluid" alt="">

                                                    <div class="custom-block-overlay-text d-flex">
                                                        <div>
                                                            <h5 class="text-white mb-2">Finance</h5>

                                                            <p class="text-white">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sint animi necessitatibus aperiam repudiandae nam omnis</p>

                                                            <a href="topics-detail.html" class="btn custom-btn mt-2 mt-lg-3">Learn More</a>
                                                        </div>

                                                        <span class="badge bg-finance rounded-pill ms-auto">25</span>
                                                    </div>

                                                    <div class="social-share d-flex">
                                                        <p class="text-white me-4">Share:</p>

                                                        <ul class="social-icon">
                                                            <li class="social-icon-item">
                                                                <a href="#" class="social-icon-link bi-twitter"></a>
                                                            </li>

                                                            <li class="social-icon-item">
                                                                <a href="#" class="social-icon-link bi-facebook"></a>
                                                            </li>

                                                            <li class="social-icon-item">
                                                                <a href="#" class="social-icon-link bi-pinterest"></a>
                                                            </li>
                                                        </ul>

                                                        <a href="#" class="custom-icon bi-bookmark ms-auto"></a>
                                                    </div>

                                                    <div class="section-overlay"></div>
                                                </div>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="music-tab-pane" role="tabpanel" aria-labelledby="music-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Composing Song</h5>

                                                            <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                        </div>

                                                        <span class="badge bg-music rounded-pill ms-auto">45</span>
                                                    </div>

                                                    <img src="images/topics/undraw_Compose_music_re_wpiw.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Online Music</h5>

                                                            <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                        </div>

                                                        <span class="badge bg-music rounded-pill ms-auto">45</span>
                                                    </div>

                                                    <img src="images/topics/undraw_happy_music_g6wc.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Podcast</h5>

                                                            <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                        </div>

                                                        <span class="badge bg-music rounded-pill ms-auto">20</span>
                                                    </div>

                                                    <img src="images/topics/undraw_Podcast_audience_re_4i5q.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="education-tab-pane" role="tabpanel" aria-labelledby="education-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-3">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Graduation</h5>

                                                            <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                        </div>

                                                        <span class="badge bg-education rounded-pill ms-auto">80</span>
                                                    </div>

                                                    <img src="images/topics/undraw_Graduation_re_gthn.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.html">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Educator</h5>

                                                            <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>
                                                        </div>

                                                        <span class="badge bg-education rounded-pill ms-auto">75</span>
                                                    </div>

                                                    <img src="images/topics/undraw_Educator_re_ju47.png" class="custom-block-image img-fluid" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </section>


      


            <section class="faq-section section-padding" id="section_4">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6_1 col-12">
                            <h2 class="mb-4" style="text-align:center;">About the model</h2><hr>
                        </div>

                        <div class="clearfix"></div>

                        <!--<div class="col-lg-5 col-12">
                            <img src="images/faq_graphic.jpg" class="img-fluid" alt="FAQs">
                        </div>-->

                        <div class="col-lg-6_1 col-12 m-auto1">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        About AagingPEPred
                                        </button>
                                    </h2>

                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <!--Topic Listing is free Bootstrap 5 CSS template. <strong>You are not allowed to redistribute this template</strong> on any other 
                                            template collection website without our permission. Please contact TemplateMo for more detail. Thank you.-->
                                            AagingPEPred is a machine learning model for predicting peptide anti-aging potential. Users input peptides in fasta format (5-50 amino acids) to obtain predictions. 
                                            Using machine learning techniques, AagingPEPred analyzes peptide characteristics to assess anti-aging potential, aiding researchers in exploring peptide properties for therapeutic interventions.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Datasets
                                    </button>
                                    </h2>

                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                        A predictive model for assessing peptide anti-aging potential requires balanced datasets. We sourced 216 positive peptides from AagingBase and generated an equivalent negative dataset of 216 peptides using Python's random library. 
                                        This balanced dataset facilitates model development.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Descriptors
                                    </button>
                                    </h2>

                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                        The positive and negative datasets underwent feature calculation using modlAMP and Pfeatures, generating 481 descriptors each. Feature selection was performed using RFECV, a tool for machine learning and data mining. 
The top 24 ranked features, selected for their relevance in predicting anti-aging potential, were used for model training.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                                        Algorithms
                                    </button>
                                    </h2>

                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                        We developed a prediction model for anti-aging peptides using various AI/ML algorithms. 
                                        The algorithms employed in this study included Support Vector Machine (SVM), Random Forest Classification (RFC), XG Boost (XGB), and Multilayer Perceptron (MLP). 
                                        Among these algorithms, XG Boost (XGB) demonstrated the highest accuracy for both the training and test datasets, achieving an accuracy of 80%. 
                                        Based on this outcome, XGB was selected as the preferred model for further analysis, specifically in the context of AagingPEPred.
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


           <!-- <section class="contact-section section-padding section-bg" id="section_5">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12 text-center">
                            <h2 class="mb-5">Get in touch</h2>
                        </div>

                        <div class="col-lg-5 col-12 mb-4 mb-lg-0">
                            <iframe class="google-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2595.065641062665!2d-122.4230416990949!3d37.80335401520422!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858127459fabad%3A0x808ba520e5e9edb7!2sFrancisco%20Park!5e1!3m2!1sen!2sth!4v1684340239744!5m2!1sen!2sth" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mb-3 mb-lg- mb-md-0 ms-auto">
                            <h4 class="mb-3">Head office</h4>

                            <p>Bay St &amp;, Larkin St, San Francisco, CA 94109, United States</p>

                            <hr>

                            <p class="d-flex align-items-center mb-1">
                                <span class="me-2">Phone</span>

                                <a href="tel: 305-240-9671" class="site-footer-link">
                                    305-240-9671
                                </a>
                            </p>

                            <p class="d-flex align-items-center">
                                <span class="me-2">Email</span>

                                <a href="mailto:info@company.com" class="site-footer-link">
                                    info@company.com
                                </a>
                            </p>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mx-auto">
                            <h4 class="mb-3">Dubai office</h4>

                            <p>Burj Park, Downtown Dubai, United Arab Emirates</p>

                            <hr>

                            <p class="d-flex align-items-center mb-1">
                                <span class="me-2">Phone</span>

                                <a href="tel: 110-220-3400" class="site-footer-link">
                                    110-220-3400
                                </a>
                            </p>

                            <p class="d-flex align-items-center">
                                <span class="me-2">Email</span>

                                <a href="mailto:info@company.com" class="site-footer-link">
                                    info@company.com
                                </a>
                            </p>
                        </div>

                    </div>
                </div>
            </section>-->
        </main>



        <?php include ("footer.html")?>

    </body>
</html>
