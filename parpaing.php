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
            <h2>Les Parpaings</h2>
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
							<img src= <?php echo 'images/' . htmlspecialchars($_SESSION['info_objet'][$nombre_de_lignes-1]['picture']) ; ?> alt="" width="240" height="180">
							<div class="gallery_hover">
								<?php $id = htmlspecialchars($_SESSION['info_objet'][$nombre_de_lignes-1]['name']) ; 
									  $desP = htmlspecialchars($_SESSION['info_objet'][$nombre_de_lignes-1]['description']) ;
									  $prix = htmlspecialchars($_SESSION['info_objet'][$nombre_de_lignes-1]['price']) ; 
								?>
								<br>
								<h4 id="nameBlock">1 Palette - <?php echo htmlspecialchars($_SESSION['info_objet'][$nombre_de_lignes-1]['name']) ; ?></h4>
								<h4 ><?php echo "<a href='affDescription.php?id=$id&desP=$desP&price=$prix#oModal'> Ici Description </a> " ;?></h4>
								<?php 
									if ( isset( $_SESSION['username'] ) == true )
									{
								?>
										<h4><input type="submit" name=<?php echo 'submit' . htmlspecialchars($_SESSION['info_objet'][$nombre_de_lignes-1]['id_prod']) . '+' ; ?> value="commander" class="submit_commande"/></h4>
								<?php
									}
								?>
								<div class="col-md-6 col-sm-4 col-xs-6 prix"><h3><?php echo $prix; ?> €</h3></div>
							</div>
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
