<?php
	$val_post = preg_replace('#^adresse([0-9]+|NEW)$#isU', '$1', htmlspecialchars($_POST['choix_adresse']) );
	$id_post = preg_replace('#^NEW$#isU', '-1', $val_post);
	if ( preg_match( '#^[0-9]+$#isU' , $id_post ) == true or ( $id_post == -1 and htmlspecialchars($_POST['street']) != "" and htmlspecialchars($_POST['country']) != "" and htmlspecialchars($_POST['city']) != "" and preg_match( '#^[0-9]+$#isU' , htmlspecialchars($_POST['postcode']) ) == true ) )
	{
		include( 'server_objet_a_vendre.php' ) ;
		header('Location: confirmation_paiement.php') ;
	}
	else
	{
		header('Location: payment.php') ;
	}
?>