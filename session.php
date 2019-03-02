<?php
	session_start();
	
	// gestion panier
	if ( isset( $_SESSION['nombre_total_objet_dans_panier'] ) == false )
	{
		$_SESSION['nombre_total_objet_dans_panier'] = 0 ;
	}
	if ( isset( $_SESSION['id_objet_dans_mon_panier'] ) == false )
	{
		$_SESSION['id_objet_dans_mon_panier'] = array() ;
	}
	
	
	if ( isset( $id_post ) )
	{
		// vérifie si l'id de l'objet donné est bien un de ceux de la bdd et protège donc contre un out of bound
		$id_produit_submit_existe_dans_bdd = false ;
		foreach( $_SESSION['info_objet_total'] as $cherche_id_prod )
		{
			if ( $id_post == htmlspecialchars($cherche_id_prod['id_prod']) )
			{
				$id_produit_submit_existe_dans_bdd = true ;
			}
		}
		if ( $cherche_id_prod == true )
		{
			if ( in_array( $id_post , $_SESSION['id_objet_dans_mon_panier'] ) == false )
			{
				$_SESSION['id_objet_dans_mon_panier'][] = $id_post ;
				$_SESSION['objet'.$id_post] = 1 ;
				$_SESSION['nombre_total_objet_dans_panier']++ ;
			}
			else
			{
				if ( preg_match( '#^[0-9]+\+$#' , $val_post ) )
				{
					$_SESSION['objet'.$id_post] = $_SESSION['objet'.$id_post] + 1;
					$_SESSION['nombre_total_objet_dans_panier']++ ;
				}
				elseif ( preg_match( '#^[0-9]+-$#' , $val_post ) )
				{
					$_SESSION['objet'.$id_post] = $_SESSION['objet'.$id_post] - 1;
					$_SESSION['nombre_total_objet_dans_panier']-- ;
				}
				elseif ( preg_match( '#^[0-9]+$#' , $val_post ) )
				{
					$_SESSION['nombre_total_objet_dans_panier'] -= $_SESSION['objet'.$id_post] ;
					$_SESSION['objet'.$id_post] = 0 ;
				}
			}
		}
	}
?>