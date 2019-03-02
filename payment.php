<?php
	include('server_objet_a_vendre.php') ;
?>
<!DOCTYPE html>
<html>

	<body>
		<?php include('header.php'); ?>
		<?php include('navbar.php'); ?>
		<section class="all_contact_info">
        	<div class="container">
            	<div class="row contact_row">
            		<div class="contact_info">
			 	 		<h2>Paiements</h2>
							<form method="post" class="form-inline contact_box" action="payment_execution.php">
								<div class="row contact_row">
									<div class="col-xs-7 col-sm-6 col-lg-8 contact_info send_message">
										<h2>Addresse de livraison</h2>
										<div class="separate">
											<?php
												if ( $nb_adr_client != 0 )
												{
													$compteur_pour_post = 1 ; // les id en sql commencent à 1
													foreach ( $adr_client as $addresses )
													{
														if ( htmlspecialchars($addresses['Name']) != "" )
														{
											?>
															<div class="separate">
																<input type="radio" name="choix_adresse" value="adresse<?php echo $compteur_pour_post ?>" id="adresse<?php echo $compteur_pour_post ?>" /> 
																<label for="adresse<?php echo $compteur_pour_post ?>"><?php echo htmlspecialchars($addresses['Name']) ; ?></label>
															</div>
											<?php
														}
														else
														{
											?>
															<input type="radio" name="choix_adresse" value="adresse<?php echo $compteur_pour_post ?>" id="adresse<?php echo $compteur_pour_post ?>" /> <label for="adresse<?php echo $compteur_pour_post ?>"><?php echo htmlspecialchars($addresses['Street']) . ', ' . htmlspecialchars($addresses['Additional']) . ', ' . htmlspecialchars($addresses['City']) . ' ' . htmlspecialchars($addresses['Postcode']) . ', ' . htmlspecialchars($addresses['Country']) ; ?></label>
											<?php
														}
														$compteur_pour_post++ ;
													}
												}
											?>
											<a href="newAdr.php#oModal"> + Ajouter adresse </a>

										</div>
									</div>
									<div class="col-xs-5 col-sm-6 col-lg-4 all_contact_info">
										<h2>Votre Panier <span class="price"><i class="fa fa-shopping-cart"></i> <b>
											<?php echo htmlspecialchars($_SESSION['nombre_total_objet_dans_panier']) ; ?></b></span></h2>
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
														<p><?php echo htmlspecialchars($_SESSION['objet' . htmlspecialchars($objet_dans_panier)]); ?> x <?php echo htmlspecialchars($_SESSION['info_objet_total'][$num_pos_id_correspondant_dans_tableau_info_objet_total]['name']) . ' - ' . htmlspecialchars($_SESSION['info_objet_total'][$num_pos_id_correspondant_dans_tableau_info_objet_total]['description']) ; ?> <span class="price"><?php echo htmlspecialchars($_SESSION['objet' . $objet_dans_panier]) * htmlspecialchars($_SESSION['info_objet_total'][$num_pos_id_correspondant_dans_tableau_info_objet_total]['price']) ; ?>€</span></p>
											<?php
													}
													$prix_total += htmlspecialchars($_SESSION['objet' . htmlspecialchars($objet_dans_panier)]) * htmlspecialchars($_SESSION['info_objet_total'][$num_pos_id_correspondant_dans_tableau_info_objet_total]['price']) ;
												}
											?>
										<hr>
										<p>Total <span class="price" ><?php echo $prix_total ; ?>€</span></p>
									</div>
									<div class="col-xs-6 col-sm-8 col-lg-10 contact_info">
										<h2>Carte de paiement</h2>
										<div class="separate">
											<div class="icon-container">
												<input type="radio" name="carte" value="visa" id="visa" /> <label for="visa"><i class="fa fa-cc-visa" style="color:navy;"></i></label>
												<input type="radio" name="carte" value="amex" id="amex" /> <label for="amex"><i class="fa fa-cc-amex" style="color:blue;"></i></i></label>
												<input type="radio" name="carte" value="mastercard" id="mastercard" /> <label for="mastercard"><i class="fa fa-cc-mastercard" style="color:red;"></i></i></label>
												<input type="radio" name="carte" value="discover" id="discover" /> <label for="discover"><i class="fa fa-cc-discover" style="color:orange;"></i></i></label>
											</div>
										</div>
										<div class="separate">
											<label for="cname">Propriétaire de la carte</label>
											<input type="text" id="cardname" name="cardname">
										</div>
										<div class="separate">
											<label for="ccnum">Numéro de carte</label>
											<input type="text" id="cardnumber" name="cardnumber">
										</div>
										<div class="separate">
											<label for="expmonth">Mois d'expiration</label>
											<input type="text" id="expmonth" name="expmonth">
										</div>
										<div class="separate">
											
											<label for="expyear">Année d'expiration</label>
											<input type="text" id="expyear" name="expyear">
										</div>
										<div class="separate">
											<label for="cvv">CVV</label>
											<input type="text" id="cvv" name="cvv">
										</div>
									</div>	
								</div>
							<div class="col-xs-6">
								<input type="submit" class="btn btn-default" name="validation_commande" value="Valider la commande" class="btn">
							</div>
						</form>
					</div>
				</div>
			</div>
			</div>
		</section>
 		 <?php include('footer.php'); ?>

	</body>
</html>
