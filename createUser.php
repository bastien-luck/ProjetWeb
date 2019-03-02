<?php 
  include('server.php');
  if (htmlspecialchars($_SESSION['user_permission'])!="2")
{
    header('location: index.php');
}
  //include ('server.php');
  ?>
<!DOCTYPE html>
<html>
<body>
<div id="oModal" class="oModal">
  <div>
   
    <section>
        <?php include ('headerDash.php'); ?>
        <?php include('errors_reg.php'); ?>

        <form method="post" action="userManage.php" class="form-inline contact_box">
            <div class="separate">
            <label class="main-label" for="bday">Civilit&eacute; * </label>
                <input type="hidden" id="civilityhidden" name="customer_title" value="1" />
                <input type="radio" id="title_1" class="active" name="customer_title" value="1" checked />
                <label class="civil" for="title_1">Madame</label>
                <input type="radio" id="title_2" name="customer_title" value="2" />
                <label class="civil space" for="title_2">Monsieur</label>
            </div>
            <div class="separate">
                <label class="main-label" for="bday">Prénom *</label>
                <input type="text" id="colortext" class="form-control input_box space" name="userFirstname" >
            </div>
            <div class="separate">
                <label class="main-label" for="bday">Nom *</label>
                <input type="text" id="colortext" class="form-control input_box space" name="username">
            </div>
            <div class="separate" >
                <label class="main-label" for="bday">Email *</label>
                <input type="text" id="colortext" class="form-control input_box sapce" name="email">
            </div>
            <div class="separate">
                <label class="main-label" for="bday">Date de naissance *</label>
                <input type="date" id="colortext" class="form-control input_box sapce" id="bday" name="bday">
            </div>
            <div class="separate">
                <label class="main-label" for="bday">Téléphone</label>
                <input type="text" id="colortext" class="form-control input_box sapce" name="number">
            </div>
            <div class="separate">
                <label class="main-label" for="bday">Permission admin *</label>
                <input type="text" id="colortext" class="form-control input_box sapce" name="userPermission">
            </div>
            <div class="separate">
                <label class="main-label" for="bday">Mot de passe *</label>
                <input type="password" id="colortext" class="form-control input_box sapce" name="password_1">
            </div>
            <div class="separate">
                <label class="main-label" for="bday">Confirmation Mot de passe *</label>
                <input type="password" id="colortext" class="form-control input_box sapce" type="password" name="password_2">
            </div>
            <div class="separate">
                <button type="submit" class="btn btn-default" name="create_user">Ajouter</button>
                <p>* Champs obligatoires</p>
            </div>
        </form>
        <footer class="cf">
            <a href="userManage.php" class="btn">Fermer</a>
        </footer>
  </div>
</div>
</body>
</html>