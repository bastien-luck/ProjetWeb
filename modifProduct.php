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
<?php 
//include ('server.php');

$id=htmlspecialchars($_REQUEST['id']);
$result = getProductId($id);
$row = mysqli_fetch_array($result);?>

<div id="oModal" class="oModal">
  <div>
	<form method="post" action="productManage.php" class="form-inline contact_box" enctype="multipart/form-data" >
		<div class="separate">
			<label class="main-label" for="bday">Nom *</label>
			<input type="text" id="colortext" class="form-control input_box space" name="productName" value=<?php echo htmlspecialchars($row['Name']); ?>>
		</div>
		<div class="separate">
			<label class="main-label" for="bday">Prix *</label>
			<input type="text" id="colortext" class="form-control input_box space" name="productPrice" value=<?php echo htmlspecialchars($row['Price']); ?>>
		</div>
		<div class="separate">
			<label class="main-label" for="bday">Description *</label>
			<textarea rows="4" cols="50" name="productDescription"> <?php echo htmlspecialchars($row['Description']); ?></textarea>
		</div>
		<div class="separate" >
			<label class="main-label" for="bday">Image *</label>
			<input type="file" name="productImage"/>
        </div>
		<input type="hidden" id="id" name="id" value=<?php echo $id; ?> />
	  	<div class="separate">
			<button type="submit" class="btn btn-default" name="edit_product">Editer</button>
			<p>* Champs obligatoires</p>
		</div>
	</form>
	<footer class="cf">
        <a href="productManage.php" class="btn">Fermer</a>
    </footer>
  </div>
</div>
</body>
</html>