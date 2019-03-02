<?php
	foreach( $_POST as $key => $not_used )
	{
		$val_post = preg_replace('#^(submit|delete_panier)([0-9]+[+-]?)$#isU', '$2', htmlspecialchars($key));
		$id_post = preg_replace('#^([0-9]+)[+-]?$#isU', '$1', $val_post);
	}
	include('server_objet_a_vendre.php') ;
	header('Location: panier.php');
?>