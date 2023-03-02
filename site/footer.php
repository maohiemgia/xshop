<!DOCTYPE html>
<html lang="en">

<head>
     <style>
          .footer {
               background: #0b1a33;
               min-height: 450px;
               margin-top: 100px;
          }

          .logo-footer {
               font-size: 45px;
          }

          .footer-logo-text {
               font-weight: 400;
               font-size: 13px;
               color: #ffffff;
               border-top: 1px solid rgba(255, 255, 255, 0.3);
               padding: 10px 0;
          }

          .footer-header {
               font-weight: 700;
               font-size: 16px;
               text-transform: capitalize;
               color: #ffffff;
          }

          .footer-follow-us {
               color: #fff;
          }

          .social-icon>a {
               text-decoration: none;
               color: #fff;
               text-transform: capitalize;
               margin-bottom: 10px;
               padding-left: 0;
          }

          .social-icon>a>i {
               padding-right: 10px;
               font-size: 18px;
          }

          .social-icon>a:hover {
               color: #ff0056;
          }
     </style>
</head>

<body>
     <footer id="footer-section" class="footer px-3 py-5 row mx-0 justify-content-between">
          <div class="col-sm-3 col">
               <a class="navbar-brand logo logo-footer" href="<?= $linkString ?>index.php">
                    xshop
               </a>
               <p class="footer-logo-text mt-3">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
               </p>
          </div>
          <div class="col-sm-3 col footer-follow-us">
               <p class="footer-header">Theo dõi chúng tôi</p>
               <div class="row mx-0 social-icon">
                    <a href="#">
                         <i class="fa-brands fa-facebook"></i> facebook
                    </a>
               </div>
               <div class="row mx-0 social-icon">
                    <a href="#">
                         <i class="fa-brands fa-instagram"></i> instagram
                    </a>
               </div>
               <div class="row mx-0 social-icon">
                    <a href="#">
                         <i class="fa-brands fa-linkedin"></i> linkedin
                    </a>
               </div>
          </div>
          <div class="col-sm-3 col footer-follow-us">
               <div class="row">
                    <p class="footer-header">liên hệ</p>
                    <div class="row mx-0 social-icon">
                         <a href="#">
                              <i class="fa-solid fa-square-phone"></i> 000.000.000
                         </a>
                    </div>
                    <div class="row mx-0 social-icon">
                         <a href="#">
                              <i class="fa-solid fa-square-phone"></i> 000.000.000
                         </a>
                    </div>
                    <div class="row mx-0 social-icon">
                         <a href="#">
                              <i class="fa-solid fa-square-phone"></i> 000.000.000
                         </a>
                    </div>
               </div>
               <div class="row mt-3">
                    <p class="footer-header">địa chỉ</p>
                    <div class="row mx-0 social-icon">
                         <a href="#">
                              <i class="fa-solid fa-location-dot"></i> eooeo, reoreor , 4343 , vn
                         </a>
                    </div>
                    <div class="row mx-0 social-icon">
                         <a href="#">
                              <i class="fa-solid fa-location-dot"></i> eooeo, reoreor , 4343 , vn
                         </a>
                    </div>
                    <div class="row mx-0 social-icon">
                         <a href="#">
                              <i class="fa-solid fa-location-dot"></i> eooeo, reoreor , 4343 , vn
                         </a>
                    </div>
               </div>
          </div>
     </footer>

</body>

</html>