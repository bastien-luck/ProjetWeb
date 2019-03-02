<?php 
  session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <?php include('navbar.php'); ?>


    <!-- All contact Info -->
    <section class="all_contact_info">
        <div class="container">
            <div class="row contact_row">
                <div class="col-sm-6 contact_info">
                    <h2>Contact Info</h2>
                    <p>Il y a beaucoup de personnes qui passent sur le site de Top Builder pour toutes questions, recommandation ou pour un retour de commande. Remplissez le formulaire de contact et nous vous repondrons au maximum sous 2 jours ouvrés.</p>
                    <p>Horaire d'ouverture : <br>Lundi-Mardi : 9h-19h <br> Samedi : 10h-18h <br> Dimanche : 10h-12h30</p>
                    <div class="location">
                        <div class="location_laft">
                            <a class="f_location" href="magasin.php">location</a>
                            <a href="contact.php">email</a>
                        </div>
                        <div class="address">
                            <a href="magasin.php">Zone Artisanale de l'ENSIBS <br>56450 Vannes, FRANCE </a>
                            <a href="contact.php">top@builder.com</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 contact_info send_message">
                    <h2>Contactez-nous</h2>
                    <form id="contactForm" class="form-inline contact_box" action="contact.php" method="POST" >
                        <div class="col-md-12">
                             <label class="main-label" for="bday">Email *</label>
                            <?php if (isset($_SESSION['username'])) : ?>
                                <input type="email" id="colortext" value=" <?php echo htmlspecialchars($_SESSION['email']); ?>" maxlength="100" class="form-control input_box" name="email" id="email" required="" aria-required="true">
                            <?php else : ?>
                                <input type="email" id="colortext" maxlength="100" class="form-control input_box" name="email" id="email" required="" aria-required="true">
                            <?php endif ?>
                        </div>
                        <div class="col-md-12">
                            <label class="main-label" for="bday" >Sujet *</label>
                            <input type="text" id="colortext" value="" maxlength="100" class="form-control input_box" name="subject" id="subject" required="" aria-required="true">
                        </div>
                        <div class="col-md-12">
                            <label class="main-label" for="bday">Message</label>
                            <textarea rows="10" id="colortext" class="form-control input_box" name="message" id="message" aria-required="true"></textarea>
                        </div>
                    <div class="col-md-12">
                        <p>* Champs obligatoires</p>    
                        <button type="submit" class="btn btn-primary btn-lg mb-xlg btn-default" name="contact">Envoyer</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End All contact Info -->


    <?php include('footer.php'); ?>
</body>
</html>