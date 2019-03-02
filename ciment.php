<?php 
	$nom_page_actuelle = preg_replace( '#^(.+)\.php$#isU' , '$1' , basename(__FILE__) ) ;
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
   

     <!-- Our Featured Works Area -->
    <section class="featured_works row" data-stellar-background-ratio="0.3">
        <div class="tittle wow fadeInUp">
            <p>   <br>   </p>
            <h2>our cement</h2>
        </div>
        <div class="featured_gallery">
			<form method="post" action="execution_affiche_objet_a_vendre.php">
			<!-- le hidden est placé ici car l'obligation d'utilisation du foreach dans execution pose problème s'il est après le submit -->
			<input type="hidden" name="nom_page" value=<?php echo $nom_page_actuelle ; ?> > <!-- permet de retourner sur la bonne page après ajout -->
				<?php
					for ($nombre_de_lignes = 1 ; $nombre_de_lignes <= htmlspecialchars($_SESSION['nb_objet']) ; $nombre_de_lignes++)
					{
				?>
						<div class="col-md-3 col-sm-4 col-xs-6 gallery_iner p0">
							<img src= <?php echo 'images/' . $nom_page_actuelle . $nombre_de_lignes . '.jpg' ; ?> alt="">
							<div class="gallery_hover">
								<h4>1 Bag - <?php echo htmlspecialchars($_SESSION['info_objet'][$nombre_de_lignes-1]['name']) . ' - ' . htmlspecialchars($_SESSION['info_objet'][$nombre_de_lignes-1]['description']) ; ?></h4>
								<?php 
									if ( isset( $_SESSION['username'] ) == true )
									{
								?>
										<h4><input type="submit" name=<?php echo 'submit' . htmlspecialchars($_SESSION['info_objet'][$nombre_de_lignes-1]['id_prod']) . '+' ; ?> value="commander" class="submit_commande"/></h4>
								<?php
									}
								?>
							</div>
							<div class="prix"><h5><?php echo htmlspecialchars($_SESSION['info_objet'][$nombre_de_lignes-1]['price']) ; ?> €</h5></div>
						</div>
				<?php
					}
				?>
			</form>

        </div>
    </section>
    <!-- End Our Featured Works Area -->

    <?php include('footer.php'); ?>
</body>
</html>
