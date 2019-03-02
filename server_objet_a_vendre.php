<?php
	include('server.php') ;
	// connexion à la bdd
	try
	{ // le dernier paramètre permet d'avoir de meilleur message d'erreur
		$bdd = new PDO('mysql:host=localhost;dbname=projet_web;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage()); // permet d'afficher un message d'erreur qui n'affiche pas le login+password dans le message visible par le visiteur
	}
	if ( isset( $nom_page_actuelle ) == true ) // même si recharger à chaque fois les variables n'est pas optimisé, le rajout d'un objet du dashboard nécessite cette action
	{
		$bdd_nb_objet_vendable_total = $bdd->query('SELECT COUNT(*) AS nb_objet_total FROM products') ;
		$nb_objet_vendable_total = $bdd_nb_objet_vendable_total->fetch() ;
		$_SESSION['nb_objet_total'] = htmlspecialchars($nb_objet_vendable_total['nb_objet_total']) ;
		
		$bdd_info_objet_vendable_total = $bdd->query('SELECT id_prod , name , description , price FROM products') ;
		$_SESSION['info_objet_total'] = $bdd_info_objet_vendable_total->fetchAll() ;
		
		// protection contre un fichier extérieur utilisant $nom_page_actuelle autrement qu'avec preg_replace( '#^(.+)\.php$#isU' , '$1' , basename(__FILE__) ) ;
		$nom_page_actuelle = preg_replace( '#[^a-zA-Z0-9_/\.]#isU' , '' , $nom_page_actuelle ) ;
		if ( htmlspecialchars($nom_page_actuelle) != 'panier' )
		{
			$bdd_nb_objet_vendable = $bdd->prepare('SELECT COUNT(*) AS nb_objet FROM products INNER JOIN product_category ON id_prod = product_category.product JOIN categories ON product_category.category = categories.id_cat WHERE categories.name = :nom_categorie') ;
			$bdd_nb_objet_vendable->execute(array( 'nom_categorie' => htmlspecialchars($nom_page_actuelle) )) ;
			$nb_objet_vendable = $bdd_nb_objet_vendable->fetch() ;
			$_SESSION['nb_objet'] = htmlspecialchars($nb_objet_vendable['nb_objet']) ;
			
			$bdd_info_objet_vendable = $bdd->prepare('SELECT products.id_prod , products.name , products.description , products.price , products.picture , categories.name AS nom_categorie FROM products INNER JOIN product_category ON id_prod = product_category.product JOIN categories ON product_category.category = categories.id_cat WHERE categories.name = :nom_categorie') ;
			$bdd_info_objet_vendable->execute(array( 'nom_categorie' => htmlspecialchars($nom_page_actuelle) )) ;
			$_SESSION['info_objet'] = $bdd_info_objet_vendable->fetchAll() ;
		}
		else
		{
			$_SESSION['nb_objet'] = 0 ;
			$_SESSION['info_objet'] = null ;
		}
	}
	
	if ( isset( $_SESSION['username'] ) )
	{
		$bdd_nb_adresses_client = $bdd->query('SELECT COUNT(*) AS nb_adresses FROM client_addr') ;
		$nb_adresses_client = $bdd_nb_adresses_client->fetch() ;
		$nb_adr_client = htmlspecialchars($nb_adresses_client['nb_adresses']) ;
		
		if ( $nb_adr_client != 0 )
		{
			$bdd_adresses_client = $bdd->prepare('SELECT * FROM client_addr INNER JOIN addresses ON Address = id_addr WHERE Client = :id_client') ;
			$bdd_adresses_client->execute(array(
				'id_client' => htmlspecialchars($_SESSION['id_user'])
				));
			$adr_client = $bdd_adresses_client->fetchAll() ;
			$bdd_adresses_client->closeCursor() ;
		}
		
		$bdd_nb_commandes_client = $bdd->prepare('SELECT COUNT(*) AS nb_commandes FROM command WHERE Client = :id_client') ;
		$bdd_nb_commandes_client->execute(array( 'id_client' => htmlspecialchars($_SESSION['id_user']) )) ;
		$nb_commandes_client = $bdd_nb_commandes_client->fetch() ;
		$nb_commandes = htmlspecialchars($nb_commandes_client['nb_commandes']) ;
		
		if ( $nb_commandes != 0 )
		{
			$bdd_adresses_commandes = $bdd->prepare('SELECT * FROM addresses INNER JOIN command ON id_addr = command.Delivery_addr JOIN client_addr ON command.Delivery_addr = client_addr.Address WHERE command.Client = :id_client') ;
			$bdd_adresses_commandes->execute(array( 'id_client' => htmlspecialchars($_SESSION['id_user']) )) ;
			$adresses_commandes = $bdd_adresses_commandes->fetchAll() ;
		}
		
		if ( htmlspecialchars($_SESSION['user_permission']) == 2 )
		{
			$bdd_adresses_commandes_admin = $bdd->query('SELECT * FROM addresses INNER JOIN command ON id_addr = command.Delivery_addr JOIN client_addr ON command.Delivery_addr = client_addr.Address JOIN users ON users.id_usr = client_addr.Client') ;
			$adresses_commandes_admin = $bdd_adresses_commandes_admin->fetchAll() ;
		}
	}
	
	if ( isset( $_POST['validation_commande'] ) == true )
	{
		if ( $id_post > 0 ) // cas adresse qui existe déjà
		{
			$req = $bdd_id_adresse_convertion = $bdd->prepare('SELECT Address FROM client_addr WHERE Client = :id_client') ;
			$req->execute(array(
				'id_client' => htmlspecialchars($_SESSION['id_user'])
				));
			for ( $i = 0 ; $i < $id_post ; $i++ )
			{
				$id_adresse_conversion = $req->fetch() ;
			}
			$req->closeCursor() ;
			$req = $bdd->prepare('SELECT AddCommand( :id_adresse_livraison , :id_adresse_achat , :id_client )') ;
			$req->execute(array(
				'id_adresse_livraison' => htmlspecialchars($id_adresse_conversion['Address']) ,
				'id_adresse_achat' => htmlspecialchars($id_adresse_conversion['Address']) ,
				'id_client' => htmlspecialchars($_SESSION['id_user'])
				));
			$req->closeCursor() ;
		}
		elseif ( $id_post == -1 ) // cas nouvelle adresse
		{
			// création nouvelle adresse
			$new_rue = htmlspecialchars(preg_replace( '#[^a-zA-Z0-9_/\.]#isU' , '' , $_POST['street'] )) ;
			$new_additional = htmlspecialchars(preg_replace( '#[^a-zA-Z0-9_/\.]#isU' , '' , $_POST['additional'] )) ;
			$new_postcode = htmlspecialchars(preg_replace( '#[^a-zA-Z0-9_/\.]#isU' , '' , $_POST['postcode'] )) ;
			$new_city = htmlspecialchars(preg_replace( '#[^a-zA-Z0-9_/\.]#isU' , '' , $_POST['city'] )) ;
			$new_country = htmlspecialchars(preg_replace( '#[^a-zA-Z0-9_/\.]#isU' , '' , $_POST['country'] )) ;
			$req = $bdd->prepare('INSERT INTO addresses( Street , Additional , Postcode , City , Country ) VALUES( :rue , :supplement , :code_postale , :ville , :pays )');
			$req->execute(array(
				'rue' => $new_rue,
				'supplement' => $new_additional,
				'code_postale' => $new_postcode,
				'ville' => $new_city,
				'pays' => $new_country
				));
			$req->closeCursor() ;
			// conexion adresse-client
			$bdd_nb_adresses = $bdd->query('SELECT COUNT(*) AS nb_adresses FROM addresses') ;
			$nb_adresses = $bdd_nb_adresses->fetch() ; // le +1 n'est pas nécessaire car l'adresse est ajouté juste avant
			$new_adr_client = htmlspecialchars(preg_replace( '#[^a-zA-Z0-9_/\.]#isU' , '' , $_POST['addr_name'] )) ;
			$req = $bdd->prepare('INSERT INTO client_addr( Client , Address , Name ) VALUES( :id_client , :id_adresse , :nom_adresse )');
			$req->execute(array(
				'id_client' => htmlspecialchars($_SESSION['id_user']),
				'id_adresse' => htmlspecialchars($nb_adresses['nb_adresses']),
				'nom_adresse' => $new_adr_client
				));
			$req->closeCursor() ;
			//création commande
			$req = $bdd->prepare('SELECT AddCommand( :id_adresse_livraison , :id_adresse_achat , :id_client )') ;
			$req->execute(array(
				'id_adresse_livraison' => htmlspecialchars($nb_adresses['nb_adresses']) ,
				'id_adresse_achat' => htmlspecialchars($nb_adresses['nb_adresses']) ,
				'id_client' => htmlspecialchars($_SESSION['id_user'])
				));
			$req->closeCursor() ;
		}
		unset( $_SESSION['id_objet_dans_mon_panier'] ) ;
		$_SESSION['nombre_total_objet_dans_panier'] = 0 ;
	}
	
	
?>