<?php 
  //session_start();
  include ('serverDash.php');
  if (htmlspecialchars($_SESSION['user_permission'])!="2")
{
	header('location: index.php');
}
  //include ('server.php');
  ?>
<!DOCTYPE html>
<html>
<body>
	<?php include ('headerDash.php'); ?>
<div id="oModal" class="oModal">
  <div>
   
     <section>
      <?php 
			
			$id=htmlspecialchars($_REQUEST['id']);


			if (htmlspecialchars($_REQUEST['action'])=='deleteProduct')    
			{
			echo "
			   <br><center><h4>Souhaitez-vous vraiment supprimer le produit n° $id ? </h4>
			   <br>
			   <h4><a href='deleteProduct?action=validerDeleteProduct&amp;id=$id'#oModal> Oui</a>&nbsp; &nbsp; &nbsp; &nbsp;
			   <a href='productManage.php'>Non</a></h4></center>";
			}
			else if (htmlspecialchars($_REQUEST['action'])=='validerDeleteProduct')
			{
				$a = deleteProduct($id);
			   	header('Location: productManage.php');
			}
		?>
     </section>
  </div>
</div>
</body>
</html>