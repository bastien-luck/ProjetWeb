<?php 
    include('server_objet_a_vendre.php') ;

  /*if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: inscription.php');
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: inscription.php");
  }*/
?>

<!DOCTYPE html>
<html lang="en">
 <body> 
    <?php include('header.php'); ?>
    <?php include('navbar.php'); ?>
        
        
        <!--================Header Menu Area =================-->
        
        <!--================Home Banner Area =================-->
        <section class="home_banner_area">
            <div class="banner_inner d-flex align-items-center">
            	<div class="overlay bg-parallax" data-stellar-ratio="0.9" data-stellar-vertical-offset="0" data-background=""><img src="images/slider-1.jpg"></div>
				<div class="container">
					<div class="banner_content text-center">
						<h3>TOP <span>BUILDER</span></h3>
						<p>"Parpaing par parpaing... vers l'avenir !"</p>
						<a class="black_btn" href="#">Discover Now</a>
					</div>
				</div>
            </div>
        </section>
        <!--================End Home Banner Area =================-->
        
        <!--================Services Area =================-->
        <section class="services_area p_120">
        	<div class="container">
        		<div class="main_title">
        			<h2>Our Offered Services</h2>
        			
        		</div>
        		<div class="row services_inner">
        			<div class="col-lg-4">
        				<div class="services_item">
        					<img src="images/s1.png" alt="">
        					<a href="#"><h4>Nous vous rembourssons 2X la différence</h4></a>
        				</div>
        			</div>
        			<div class="col-lg-4">
        				<div class="services_item">
        					<img src="images/s2.png" alt="">
        					<a href="#"><h4>Toute l’année, des stocks immédiatement disponibles !</h4></a>
        				</div>
        			</div>
        			<div class="col-lg-4">
        				<div class="services_item">
        					<img src="images/s3.png" alt="">
        					<a href="#"><h4>Des horaires adaptés à vos chantiers</h4></a>
        				</div>
        			</div>
                    <div class="col-lg-4">
                        <div class="services_item">
                            <img src="images/s4.png" alt="">
                            <a href="#"><h4>Chaque mois DES ARRIVAGES !</h4></a>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="services_item">
                            <img src="images/s5.png" alt="">
                            <a href="#"><h4>De grandes marques à PRIX CASH !</h4></a>
                        </div>
                    </div>
        		
                </div>
        	</div>
        </section>
        <!--================End Services Area =================-->

        
        <!--================Team Area =================-->
        <section class="team_area p_120">
        	<div class="container">
        		<div class="main_title">
        			<h2>Meet Our Expert Members</h2>
        			
        		</div>
        		<div class="row team_inner">
        			<div class="col-lg-3 col-sm-6">
        				<div class="team_item">
        					<div class="team_img">
        						<img class="img-fluid" src="images/antoinne.jpg" alt="">
        						<div class="hover">
        							<a href="#"><i class="fa fa-facebook"></i></a>
        							<a href="#"><i class="fa fa-twitter"></i></a>
        							<a href="#"><i class="fa fa-linkedin"></i></a>
        						</div>
        					</div>
        					<div class="team_name">
        						<h4>Antoine Le Falher</h4>
        						
        					</div>
        				</div>
        			</div>
        			<div class="col-lg-3 col-sm-6">
        				<div class="team_item">
        					<div class="team_img">
        						<img class="img-fluid" src="images/aurelie.jpg" alt="">
        						<div class="hover">
        							<a href="#"><i class="fa fa-facebook"></i></a>
        							<a href="#"><i class="fa fa-twitter"></i></a>
        							<a href="#"><i class="fa fa-linkedin"></i></a>
        						</div>
        					</div>
        					<div class="team_name">
        						<h4>Aurélie Ehanno</h4>
        						
        					</div>
        				</div>
        			</div>
        			<div class="col-lg-3 col-sm-6">
        				<div class="team_item">
        					<div class="team_img">
        						<img class="img-fluid" src="images/bastien.jpg" alt="">
        						<div class="hover">
        							<a href="#"><i class="fa fa-facebook"></i></a>
        							<a href="#"><i class="fa fa-twitter"></i></a>
        							<a href="#"><i class="fa fa-linkedin"></i></a>
        						</div>
        					</div>
        					<div class="team_name">
        						<h4>Bastien Luck</h4>
        						
        					</div>
        				</div>
        			</div>
        			<div class="col-lg-3 col-sm-6">
        				<div class="team_item">
        					<div class="team_img">
        						<img class="img-fluid" src="images/houssam.jpg" alt="">
        						<div class="hover">
        							<a href="#"><i class="fa fa-facebook"></i></a>
        							<a href="#"><i class="fa fa-twitter"></i></a>
        							<a href="#"><i class="fa fa-linkedin"></i></a>
        						</div>
        					</div>
        					<div class="team_name">
        						<h4>Houssam Kaarar</h4>
        						
        					</div>
        				</div>
        			</div>
        		  
                    <div class="col-lg-3 col-sm-6">
                        <div class="team_item">
                            <div class="team_img">
                                <img class="img-fluid" src="images/robin.jpg" alt="">
                                <div class="hover">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="team_name">
                                <h4>Robin Aspe</h4>
                                
                            </div>
                        </div>
                    </div>

                </div>
        	</div>
        </section>
        
        <?php include('footer.php'); ?>

    </body>
</html>