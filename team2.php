<!doctype html>
<html lang="en">
  
<?php include ("header.html")?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>

.fa-envelope {
            font-size: 15px; /* Adjust icon size as needed */
        }

.grid {
  display: grid;
  grid-template-columns: 560px;
  grid-auto-rows: 220px;
  grid-gap: 30px;
  padding-left: 50px;
}

@media (min-width: 1200px) {
  .grid {
    grid-template-columns: repeat(2, 560px);
  }
}

ul li {
    color: #212529;
    font-size: var(--p-font-size);
    font-weight: 200;
}

.email-signature {
    padding: 8px 20px 18px 230px;
    max-height: 200px;
    background-color: white;
    border-radius: 100px;
    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);
    position: relative;
}

.email-signature .signature-icon {
  width: 194px;
  height: 194px;
  line-height: 186px;
  border-radius: 50%;
  border: 12px solid white;
  /*background-color: #03a9f4;*/
  color: white;
  font-size: 80px;
  text-align: center;
  box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.3);
  position: absolute;
  top: 1px;
  left: -2px;
}

.signature-icon {
    /* Set common styles for all signature icons */
    width: 24px; /* Adjust as needed */
    height: 24px; /* Adjust as needed */
    display: inline-block; /* Example */
    margin-right: 10px; /* Example */
    /* Set common background properties for all icons */
    background-size: cover; /* or contain, or specific size */
    background-position: center center;
}

/* Individual background images for different icons */
.signature-icon.heart {
    background-image: url("images/Dedeepya.jpg");
}
.signature-icon.arrow {
    background-image: url("images/kunjulakshmi.jpeg");
}

.signature-icon.star {
    background-image: url("images/avik.jpeg");
}

.signature-icon.envelope {
    background-image: url("images/kavita.jpeg");
}

.signature-icon.diamond {
    background-image: url("images/rahul.jpg");
}

.email-signature .signature-icon i {
  text-shadow: 8px 8px 12px rgba(0, 0, 0, 0.1);
}

.email-signature .signature-icon::before {
  content: "";
  background-color: transparent;
  border: 10px solid #03a9f4;
  border-radius: 50%;
  position: absolute;
  top: -15px;
  left: -15px;
  right: -15px;
  bottom: -15px;
}

.email-signature .signature-content {
  padding: 0;
  margin: 0;
  list-style: none;
  font-size: 14px;
  color: white;
}

.email-signature .signature-content .circle {
  border-radius: 50%;
  width: 50px;
  height: 50px;
  background-color: #7ed0c7d6;
  border: 4px solid white;
  z-index: 1;
}
.email-signature .signature-icon::before {
    content: "";
    background-color: transparent;
    border: 10px solid #30788fc4;
    border-radius: 50%;
    position: absolute;
    top: -15px;
    left: -15px;
    right: -15px;
    bottom: -15px;
}

.signature-icon.diamond::before {
    content: "";
    background-color: transparent;
    border: 10px solid #ff7f07ed;
    border-radius: 50%;
    position: absolute;
    top: -15px;
    left: -15px;
    right: -15px;
    bottom: -15px;
}

.email-signature .signature-content li {
  padding: 0;
  margin: 0;
  font-size: 14px;
  display: flex;
  align-items: center;
  text-align: center;
}

.email-signature .signature-content i {
  font-size: 28px;
  width: 40px;
  line-height: 40px;
}

.email-signature .signature-content span {
  background-color: #7ed0c7d6;
  padding: 6px 14px;
  margin-left: -4px;
  border-radius: 6px;
}

.email-signature .name {
  display: block;
  font-size: 20px;
  font-weight: 600;
  color: black;
  text-transform: uppercase;
  margin: 6px 0 7px 0;
}

.email-signature .title {
  display: block;
  font-size: 17px;
  font-weight: 600;
  color: #555;
  line-height: 1.1;
  padding: 0;
  margin: 0;
  letter-spacing: 2px;
}

    </style>


<section class="explore-section section-padding" id="section_2" style="padding-bottom: 50px;">
<div class="container">
<div class="col-12 text-center">
<h2 class="mb-4">Team</h2>
<hr>
</div>

<div class="grid" style="padding-top:30px;">


  <div class="email-signature">
  <div class="signature-icon arrow"></div>
        <h3 class="name">Kunjulakshmi R</h3>
        <h4 class="title">
    (BS MS-Biology Major)</h4>
    <ul class="signature-content">
    <li>
        <div class="circle">
          <i class="fa fa-envelope-o" aria-hidden="true"></i>
        </div>
        <span>kunjulakshmiperumal@gmail.com</span>
      </li>
    <div class="social container" style="padding: left 20px;">
    <a href="#" class="github"><i class="fab fa-github-square"></i></a>
    <a href="#" class="twitter"><i class="fab fa-twitter-square"></i></a>
    <a href="#" class="linkedin"><i class="fab fa-linkedin"></i></a>
  </div>
      
    </ul>
  </div>
  
  
  <div class="email-signature">
  <div class="signature-icon heart"></div>
        <h3 class="name">Dedeepya Mullapudi</h3>
        <h4 class="title">(MSc Biotechnology)</h4>
    <ul class="signature-content">
     
     <!-- <li>
      <div class="circle">
      <i class="fa-regular fa-address-card" aria-hidden="true" style="font-size: 22px;"></i>
      </div>
        <span>MSc Biotechnology</span>
      </li>-->
      <li>
      <div class="circle">
        <!--<i class="fa-regular fa-envelope" aria-hidden="true" style="font-size: 20px;"></i>-->
        <i class="fa fa-envelope-o" aria-hidden="true"></i>
      </div>
        <span>mullapudidedeepya@gmail.com</span>
      </li>
      <div class="social container" style="padding: left 20px;">
    <a href="#" class="github"><i class="fab fa-github-square"></i></a>
    <a href="#" class="twitter"><i class="fab fa-twitter-square"></i></a>
    <a href="#" class="linkedin"><i class="fab fa-linkedin"></i></a>
  </div>
    </ul>
  </div>

  <div class="email-signature">
  <div class="signature-icon star"></div>
        <h3 class="name">Avik Sengupta</h3>
        <h4 class="title">
    (PhD Scholar-CSIR SRF)</h4>
    <ul class="signature-content">
      <li>
        <div class="circle">
          <i class="fa fa-envelope-o" aria-hidden="true"></i>
        </div>
        <span>bo22resch01004@iith.ac.in</span>
      </li>
      <!--<li>
        <div class="circle">
          <i class="fa fa-map-marker" aria-hidden="true"></i>
        </div>
        <span>Planetbase</span>
      </li>-->
      <div class="social container" style="padding: left 20px;">
    <a href="#" class="github"><i class="fab fa-github-square"></i></a>
    <a href="#" class="twitter"><i class="fab fa-twitter-square"></i></a>
    <a href="#" class="linkedin"><i class="fab fa-linkedin"></i></a>
  </div>
    </ul>
  </div>
  <div class="email-signature">
  <div class="signature-icon envelope"></div>
        <h3 class="name">Kavita Kundal</h3>
        <h4 class="title">
        (PhD Scholar-PMRF)
    </h4>
    <ul class="signature-content">
      <li>
        <div class="circle">
          <i class="fa fa-envelope-o" aria-hidden="true"></i>
        </div>
        <span>bo22resch01003@iith.ac.in</span>
      </li>
     <!-- <li>
        <div class="circle">
          <i class="fa fa-map-marker" aria-hidden="true"></i>
        </div>
        <span>Sailflex</span>
      </li>-->
      <div class="social container" style="padding: left 20px;">
    <a href="#" class="github"><i class="fab fa-github-square"></i></a>
    <a href="#" class="twitter"><i class="fab fa-twitter-square"></i></a>
    <a href="#" class="linkedin"><i class="fab fa-linkedin"></i></a>
  </div>
    </ul>
  </div>
</div>
<div class="grid" style="padding: left 100px;padding: right 50px; margin-left: 300px; padding-top: 30px;">
  <div class="email-signature">
  <div class="signature-icon diamond"></div>
        <h3 class="name">Dr. Rahul Kumar</h3>
        <h4 class="title">Principal Investigator</h4>
    <ul class="signature-content">
      <li>
        <div class="circle">
          <i class="fa fa-envelope-o" aria-hidden="true"></i>
        </div>
        <span>rahulk@bt.iith.ac.in</span>
      </li>
      <li>
      <div class="circle">
      <i class="fa-regular fa-address-card" aria-hidden="true" style="font-size: 22px;"></i>
      </div>
        <span>Assistant Professor</span>
      </li>
      <!--<div class="social container" style="padding: left 20px;">
    <a href="#" class="github"><i class="fab fa-github-square"></i></a>
    <a href="#" class="twitter"><i class="fab fa-twitter-square"></i></a>
    <a href="#" class="linkedin"><i class="fab fa-linkedin"></i></a>
  </div>-->
    </ul>
  </div>

</div>




    
</div>
</section>
</main>

<?php include ("footer.html")?>

    </body>
</html>
