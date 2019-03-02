<?php 
  session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <?php include('navbar.php'); ?>
    <section class="all_contact_info">
        <div class="container">
            <div class="row contact_row">
                <div class="col-sm-4 contact_info">
                    <h2>Trouvez-nous</h2>
                    <div class="location">
                        <div class="location_laft">
                            <h7 class="f_location" >LOCATION <br><br>
                            <br>EMAIL</h7>
                        </div>
                        <div class="address">
                            <h7>Zone Artisanale de l'ENSIBS <br> 56000 Vannes, FRANCE <br>
                            <br>top@builder.com</h7>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 contact_info send_message">
                    <div class="col-md-12">
                        <!-- Map -->
                        <div class="contact_map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5377.205125154574!2d-2.752781973409204!3d47.64460707339284!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48101c2db2a21777%3A0x69881855c2d10d04!2sENSIBS!5e0!3m2!1sfr!2sfr!4v1539248736262" width="800" height="600" frameborder="0" style="border:2" allowfullscreen></iframe>
                        </div>
                        <!-- End Map -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End All contact Info -->

<?php include('footer.php'); ?>
</body>
</html>
