<?php 
  include('server.php') ;

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
        
    <!-- Navigation -->

  <?php include('navbar.php'); ?>

    <section class="all_contact_info">
        <div class="container">
            <div class="row contact_row">
                <div class="col-sm-6 contact_info send_message" id="partie_gauche">
                    <h2>"Parpaing par parpaing... vers l'avenir !"</h2>
                    <form class="form-inline contact_box">
                        <p>L'entreprise TOPBUILDER reste à votre entière disposition pour de plus amples informations concernant notre stock de matériaux de construction. </p>
                              <?php  if (isset($_SESSION['username'])) : 
                                        /*if ($_SESSION['type'] == 0) : ?>
                                          <p>Welcome <strong> Simple User</strong></p>
                                        <?php endif ?>*/
                            endif ?>
                    </form>
                </div>
    </section>            

 <?php include('footer.php'); ?>
    
</body>
</html>
