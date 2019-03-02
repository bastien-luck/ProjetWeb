
<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<body>
    <?php include('header.php'); ?>
    <?php include('navbar_inscription.php'); ?>
    <!-- Collect information for inscription -->
    <section class="all_contact_info">
        <div class="container">
            <div class="row contact_row">
                <div class="col-sm-6 contact_info send_message" id="partie_gauche">
                    <h2>Inscription</h2>
                    <form method="post" action="inscription.php" class="form-inline contact_box">
                        <?php include('errors_reg.php'); ?>
                        <label class="main-label" for="bday">Civilit&eacute; * </label><br />
                            <input type="hidden" id="civilityhidden" name="customer_title" value="1" />
                            <input type="radio" id="title_1" class="active" name="customer_title" value="1" checked />
                            <label class="civil" for="title_1">Madame</label>
                            <input type="radio" id="title_2" name="customer_title" value="2" />
                            <label class="civil" for="title_2">Monsieur</label><br />
                        <label class="main-label" for="bday">Prénom *</label>
                            <input type="text" id="colortext" class="form-control input_box" name="userFirstname"  >
                        <label class="main-label" for="bday">Nom *</label>
                            <input type="text" id="colortext" class="form-control input_box" name="username">
                        <label class="main-label" for="bday">Email *</label>
                            <input type="text" id="colortext" class="form-control input_box" name="email">
                        <label class="main-label" for="bday">Date de naissance *</label>
                            <input type="date" id="colortext" class="form-control input_box" id="bday" name="bday">
                        <label class="main-label" for="bday">Mot de passe *</label>
                            <input type="password" id="colortext" class="form-control input_box" name="password_1">
                        <label class="main-label" for="bday">Confirmation Mot de passe *</label>
                            <input type="password" id="colortext" class="form-control input_box" type="password" name="password_2">
                            <input type="hidden" id="colortext" class="form-control input_box" name="token" value="5481ca07bb1074dd7720405476f44c20">
                        <button type="submit" class="btn btn-default" name="reg_user">S'inscrire</button>
                        <p>* Champs obligatoires</p>
                    </form>
                </div>
                <!-- Collect information for connection -->
                <div class="col-sm-6 contact_info send_message">
                    <h2>Connexion</h2>
                    <form method="post" action="inscription.php" class="form-inline contact_box">
                        <?php include('errors_log.php'); ?>
                    <label class="main-label" for="bday">Email</label>
                        <input type="text" name="mail" id="colortext" class="form-control input_box" value="">
                            <label class="main-label" for="bday">Mot de passe</label>
                        <input type="password" name="password" id="colortext" class="form-control input_box">
                        <button type="submit" class="btn btn-default" name="login_user">Connexion</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php include('footer.php'); ?>

</body>
</html>
