<?php 
  include('server_objet_a_vendre.php') ;
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <?php include('navbar.php'); ?>
    <section class="all_contact_info">
    	<div class="container">
    		<div class="row contact_row">
	    		<div class="col-sm-6 contact_info">
	    			<h2>Informations personnelles</h2>
	    			<?php 
						echo '<br />Nom : ' . htmlspecialchars($_SESSION['username']) ;
						echo '<br />Prenom : ' . htmlspecialchars($_SESSION['user_firstname']) ;
						echo '<br />Email : ' . htmlspecialchars($_SESSION['email']) ;
						$tel = htmlspecialchars($_SESSION['phone_number']) ;
						if(	empty($tel) == false ){echo '<br />Téléphone : ' . $tel; }?>
				</div>
				<div class="col-sm-6 contact_info">
					<h2>Vos adresses</h2>
					<a href="createAdr.php#oModal"> + Ajouter adresse </a>
					<br>
						<?php
							if ( isset( $adr_client ) == true )
							{
								echo "<table class='table'> ";
						            echo "<tr>";
						            echo "</tr>";
									foreach( $adr_client as $adr )
									{
										echo "<tr>";
											echo '<td>' . htmlspecialchars($adr['Street']) . ' ' . htmlspecialchars($adr['Additional']) . ', ' . htmlspecialchars($adr['City']) . ' ' . htmlspecialchars($adr['Postcode']) . ', ' . htmlspecialchars($adr['Country']) . '</td>';
										echo "</tr>";
									}
								echo "</table>";
							}
							else
							{
								echo "<br />Aucune adresse connue";
							}
						?>
					<!--</div>-->
	    		</div>
	    	</div>
            <div class="row contact_row">
                <div class="col-sm-8 contact_info">
                    <h2>Vos commandes</h2>
                    <div class="location">
						<?php 
							if ( isset( $adresses_commandes ) == true ){
								echo "<table class='table'> ";
						            echo "<tr>";
						            	echo "<th>Numéro Commande</th>";
						                echo "<th>Adresse</th>";
						            echo "</tr>";
									foreach(  $adresses_commandes as $adr )
									{
										echo "<tr>";
											echo '<td>' . htmlspecialchars($adr['id_command']) . '</td>';
											echo '<td>' . htmlspecialchars($adr['Street']) . ' ' . htmlspecialchars($adr['Additional']) . ', ' . htmlspecialchars($adr['City']) . ' ' . htmlspecialchars($adr['Postcode']) . ', ' . htmlspecialchars($adr['Country']) . '</td>';
										echo "</tr>";
									}
								echo "</table>";
							}
							else
							{
								echo "Aucune commande";
							}
					?>
                    </div>
                </div>
			</div>
		</div>
	</section>
<?php include('footer.php'); ?>
</body>
</html>


