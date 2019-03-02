<?php 
$nom_page_actuelle = preg_replace( '#^(.+)\.php$#isU' , '$1' , basename(__FILE__) ) ;
include('server_objet_a_vendre.php') ;
?>
<!DOCTYPE html>
<html>
<body>

	<?php include('header.php'); ?>	

	<!-- Navigation -->

	<?php include('navbar.php'); ?>

	<div class="container-fluid breadcrumbBox text-center"></div>

	<div class="container text-center">

		<div class="col-md-5 col-sm-12">
			<div class="bigcart"></div>
			<h1>Your shopping cart</h1>

		</div>
		<?php 
		if ( htmlspecialchars($_SESSION['nombre_total_objet_dans_panier']) > 0 )
		{
			?>
			<div class="col-md-7 col-sm-12 text-left">
				<ul>
					<li class="row list-inline columnCaptions">
						<span style='padding-right: 55px'>Quantité</span>
						<span>Produit</span>
						<span>Prix</span>
					</li>
					<form method="post" action="panier_execution.php">
						<?php
							$prix_total = 0 ;
							foreach ( $_SESSION['id_objet_dans_mon_panier'] as $objet_dans_panier )
							{
								$num_pos_id_correspondant_dans_tableau_info_objet_total = 0 ;
								foreach( $_SESSION['info_objet_total'] as $cherche_position )
								{
									if ( htmlspecialchars($cherche_position['id_prod']) == htmlspecialchars($objet_dans_panier) )
									{
										break;
									}
									else
									{
										$num_pos_id_correspondant_dans_tableau_info_objet_total++ ;
									}
								}
								if ( htmlspecialchars($_SESSION['objet' . htmlspecialchars($objet_dans_panier)]) != 0 )
								{
						?>
									<li class="row">
										<span class="quantity">
											<input type="submit" name="submit<?php echo htmlspecialchars($objet_dans_panier) ; ?>-" value="-" class="submit_commande" 
											<?php if ( htmlspecialchars($_SESSION['objet' . htmlspecialchars($objet_dans_panier)]) <= 1 ) echo 'hidden'; ?>
											/>
										</span>
										<span class="quantity">
											<input type="submit" name="submit<?php echo htmlspecialchars($objet_dans_panier) ; ?>+" value="+" class="submit_commande"/>
										</span>
										<span class="quantity">
											<?php echo htmlspecialchars($_SESSION['objet' . htmlspecialchars($objet_dans_panier)]) ; ?>
										</span>
										<span class="itemName"><?php echo htmlspecialchars($_SESSION['info_objet_total'][$num_pos_id_correspondant_dans_tableau_info_objet_total]['name']) . ' - ' . nl2br(htmlspecialchars($_SESSION['info_objet_total'][$num_pos_id_correspondant_dans_tableau_info_objet_total]['description']) ) ; ?></span>
										<span class="popbtn"><input type="submit" name="delete_panier<?php echo htmlspecialchars($objet_dans_panier) ; ?>" value="X" class="submit-Delete"></span>
										<span class="price"><?php echo htmlspecialchars($_SESSION['objet' . htmlspecialchars($objet_dans_panier)]) * htmlspecialchars($_SESSION['info_objet_total'][$num_pos_id_correspondant_dans_tableau_info_objet_total]['price']) ; ?>€</span>
									</li>
						<?php
								}
								$prix_total += htmlspecialchars($_SESSION['objet' . htmlspecialchars($objet_dans_panier)]) * htmlspecialchars($_SESSION['info_objet_total'][$num_pos_id_correspondant_dans_tableau_info_objet_total]['price']) ;
							}
						?>
					</form>
					<li class="row totals">
						<span class="itemName">Total: </span>
						<span class="price"><?php echo $prix_total ; ?>€</span>
						<span class="order"> <a href="payment.php" class="text-center">ORDER</a></span>
					</li>
				</ul>
			</div>
			<?php 
		}
		else
		{
			echo 'aucun article dans le panier' ;
		}
		?>
	</div>

	<!-- JavaScript includes -->

	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script> 
	<script src="js/bootstrap1.js"></script>
	<script src="js/customjs1.js"></script>

	<?php include('footer.php'); ?>

</body>

</html>