<?php 
  include('server.php');
  if (htmlspecialchars($_SESSION['user_permission'])!="2")
{
    header('location: index.php');
}
  ?>
<!DOCTYPE html>
<html>
<body>
<div id="oModal" class="oModal">
  <div>
   
    <section>
        <?php include ('headerDash.php'); ?>
        <?php include('errors_reg.php'); ?>

        <form method="post" action="productManage.php" class="form-inline contact_box" enctype="multipart/form-data" >
            <div class="separate">
                <label class="main-label" for="bday">Nom produit *</label>
                <input type="text" id="colortext" class="form-control input_box space" name="productName" >
            </div>
            <div class="separate">
                <label class="main-label" for="bday">Prix *</label>
                <input type="text" id="colortext" class="form-control input_box space" name="productPrice">
            </div>
            <div class="separate" >
                <label class="main-label" for="bday">Description *</label>
                <textarea rows="4" cols="50" name="productDescription" placeholder="Description ici :"></textarea>
            </div>
			<div class="separate" >
                <label class="main-label" for="bday">Image *</label>
				<input type="file" name="productImage"/>
            </div>
            <div class="separate">
                <button type="submit" class="btn btn-default" name="create_product">Ajouter</button>
                <p>* Champs obligatoires</p>
            </div>
        </form>
        <footer class="cf">
            <a href="productManage.php" class="btn">Fermer</a>
        </footer>
    </section>
  </div>
</div>
</body>
</html>