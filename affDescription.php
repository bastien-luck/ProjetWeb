<!DOCTYPE html>
<html>
<body>
	<?php include ('headerDash.php'); ?>
<div id="oModal" class="oModal">
  <div>
     <section>
      <?php 
			include ('serverDash.php');
			$id=htmlspecialchars($_REQUEST['id']);
			$desP=htmlspecialchars($_REQUEST['desP']);
			$price=htmlspecialchars($_REQUEST['price']);
			echo "
			   <h2>Description : $id </h2><br>
	        <h3> $desP </h3><br>
	        <h5>Prix : $price </h5>"
	      
		?>
		<footer class="cf">
            <a href="parpaing.php" class="btn">Fermer</a>
        </footer>
     </section>
  </div>
</div>
</body>
</html>