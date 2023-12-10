 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
ul {
    margin: 0px;
   
}
.footer-section {
  background: #486581;
  position: relative;
}

.single-cta i {
  color: #ff5e14;
  font-size: 30px;
  float: left;
  margin-top: 8px;
}
.cta-text {
  padding-left: 15px;
  display: inline-block;
}
 .copyright-text {
        text-align: center;
    }
.cta-text h4 {
  color: #fff;
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 2px;
}
.cta-text span {
  color: #757575;
  font-size: 15px;
}
.footer-content {
  position: relative;
  z-index: 2;
  padding: 0;
  margin-top: 0;
  margin-bottom: 0;
}


.footer-pattern img {
  position: absolute;
  top: 0;   
  left: 0;
  height: 330px;
  background-size: cover;
  background-position: 100% 100%;
}
.footer-logo {
  margin-bottom: 30px;
}
.footer-logo img {
    max-width:250px;
}
.footer-text p {
  margin-bottom: 14px;
  font-size: 14px;
      color: #7e7e7e;
  line-height: 28px;
}
.footer-social-icon span {
  color: #fff;
  display: block;
  font-size: 20px;
  font-weight: 700;
  font-family: 'Poppins', sans-serif;
  margin-bottom: 20px;
}
.footer-social-icon a {
  color: blue;
  font-size: 16px;
  margin-right: 15px;
}
.footer-social-icon i {
  height: 40px;
  width: 40px;
  text-align: center;
  line-height: 38px;
  border-radius: 50%;
}
.facebook-bg{
  background: white;
}
.twitter-bg{
  background: white;
}

.footer-widget-heading h3 {
  color: #fff;
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 40px;
  position: relative;
}
.footer-widget-heading h3::before {
  content: "";
  position: absolute;
  left: 0;
  bottom: -15px;
  height: 2px;
  width: 50px;
  background: white;
}
.footer-widget ul li {
  display: inline-block;
  float: left;
  width: 50%;
  margin-bottom: 12px;
}
.footer-widget ul li a:hover{
  color: #ff5e14;
}
.footer-widget ul li a {
  color: #878787;
  text-transform: capitalize;
}

.copyright-area{
  background: #202020;
  padding: 25px 0;
}
.copyright-text p {
  margin: 0;
  font-size: 14px;
  color: #878787;
}
.copyright-text p a{
  color: #ff5e14;
}
.footer-menu li {
  display: inline-block;
  margin-left: 20px;
}
.footer-menu li:hover a{
  color: #ff5e14;
}
.paragraph-text {
        color: white;
    }
.footer-menu li a {
  font-size: 14px;
  color: #878787;
}</style>
<footer class="footer-section">
        <div class="container">
            <div class="footer-cta pt-5 pb-5">
                <div class="row">
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="fas fa-map-marker-alt" style="color: white;"></i>
                            <div class="cta-text">
                                <h4>Find us</h4>
                                <span style="color: white;">Poblacion, San Teodoro, Oriental Mindoro</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="fas fa-phone" style="color: white;"></i>

                            <div class="cta-text">
                                <h4>Call us</h4>
                                <span style="color: white;">09094881709</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="far fa-envelope-open" style="color: white;"></i>
                            <div class="cta-text">
                                <h4>Mail us</h4>
                                <span style="color: white;">ferlan_merchanidse@gmail.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-content pt-2 pb-2">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 mb-50">
                        <div class="footer-widget">
                         <div class="footer-logo">
    <a href="{{ route('home') }}">
        <img src="{{ asset('frontend/img/logo4.png') }}" alt="logo">
    </a>
</div>

                            <div class="footer-text">
                                <p style="color: white;">Lorem ipsum dolor sit amet, consec tetur adipisicing elit, sed do eiusmod tempor incididuntut consec tetur adipisicing
                                elit,Lorem ipsum dolor sit amet.</p>
                            </div>
                          <div class="footer-social-icon">
    <span>Follow us</span>
    <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f facebook-bg"></i></a>
    <a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter twitter-bg"></i></a>
   
</div>

                        </div>  
                    </div>
                    
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                        <div class="footer-widget">
                            <div class="footer-widget-heading"  >
                                <h3>About Us</h3>
                            </div>
                            <div class="footer-text mb-25">
                               <p style="color: white;">Ferlan Merchandise is your go-to destination for high-quality products. We take pride in offering a curated selection of items that cater to your needs and preferences. Our commitment is to provide an exceptional shopping experience, ensuring that you find the perfect products that align with your lifestyle.</p>

                            </div>
                            
                        </div>
                        
                    </div>
                </div>
                
            </div>
             <div class="copyright-text">
                           <p style="color: white;">&copy; 2023 Ferlan Merchandise. All rights reserved.</p> 
                        </div>
        </div>
        
                </div>
            </div>
        </div>
    </footer>