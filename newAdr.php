<!DOCTYPE html>
<html>
<body>
<div id="oModal" class="oModal">
  <div>
    <section>
        <?php include ('header.php'); ?>
        <?php include('server.php') ?>
        <?php include('errors_reg.php'); ?>

        <form method="post" action="account_user.php" class="form-inline contact_box">
            <?php //var_dump($_SESSION); ?>
                <div vlass="separate">
                    <label for="addr_name"><i class="fa fa-user"></i> Nom de l'adresse </label>
                    <input type="text" id="addr_name" name="addr_name">
                </div>
                <div class="separate">
                    <label for="street"><i class="fa fa-address-card-o"></i> Rue</label>
                    <input type="text" id="street" name="street">
                </div>
                <div class="separate">
                    <label for="additional"><i class="fa fa-address-card-o"></i> Informations Supplémentaires</label>
                    <input type="text" id="additional" name="additional" >
                </div>
                <div class="separate">
                    <label for="country">Pays</label>
                    <input type="text" id="country" name="country">
                </div>
                <div class="separate">
                    <label for="city"><i class="fa fa-institution"></i> Ville </label>
                    <input type="text" id="city" name="city">
                </div>
                <div class="separate">
                    <label for="postcode">Code Postal</label>
                    <input type="text" id="postcode" name="postcode">
                </div>
                <div class="separate">
            <div class="separate">
                <input type="hidden" id="user_id" name ="user_id" value =<?php echo htmlspecialchars($_SESSION['id_user']);?>>
                <button type="submit" class="btn btn-default" name="create_adr">Ajouter</button>
                <p>* Champs obligatoires</p>
            </div>
        </form>
        <footer class="cf">
            <a href="payment.php" class="btn">Fermer</a>
        </footer>
  </div>
</div>
</body>
</html>