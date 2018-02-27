<?php
    require_once('header.php');
?>

    <?php
        function validation() {
            global $form_errors;

            // Contrôle des champs
            if (strlen($_POST['name']) == 0)
                $form_errors['name'] = 'Le nom n\'est pas valide';
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $form_errors['email'] = 'L\'email n\'est pas valide';
            if (strlen($_POST['message']) < 10)
                $form_errors['message'] = 'Le message n\'est pas valide';
        }

        $form_errors = [];
        // Si le formulaire a été soumis
        if (isset($_POST['form_contact']) && $_POST['form_contact'] === '1') {
            validation();

            if (count($form_errors) == 0) {
                // Connexion à la base
                $connexion = connexion();

                // Préparation de la requête
                $requete = $connexion->prepare('INSERT INTO contact(name, email, message) VALUES (:name, :email, :message)');
                $requete->bindValue(':name', htmlspecialchars($_POST['name']), PDO::PARAM_STR);
                $requete->bindValue(':email', htmlspecialchars($_POST['email']), PDO::PARAM_STR);
                $requete->bindValue(':message', htmlspecialchars($_POST['message']), PDO::PARAM_STR);

                // Exécution de la requête
                $requete->execute();

                // Vérification
                error_log($requete->rowCount() . " ligne insérée");
            }
        }
        
    ?>
    <section class="bg-blue">
        <div class="container">
            <?php if (!isset($_POST['form_contact']) || count($form_errors) > 0) : ?>
            <h2>Get in touch</h2>
            <p>1600 Pennsylvania Ave NW, Washington, DC 20500, United States of America. Tel: (202) 456-1111</p>
            <div class="row">
                <div class="col-lg-8 offset-2">
                    <form method="post">
                        <input name="form_contact" type="hidden" value="1"/>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <input id="name" name="name" type="text" class="form-control <?php echo isset($form_errors['name']) ? 'is-invalid' : ''; ?>" placeholder="Your name*" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
                                    <?php echo isset($form_errors['name']) ? '<p class="invalid-feedback">' . $form_errors['name'] . '</p>' : ''; ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <input id="email" name="email" type="email" class="form-control <?php echo isset($form_errors['email']) ? 'is-invalid' : ''; ?>" placeholder="Your email*" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                                    <?php echo isset($form_errors['email']) ? '<p class="invalid-feedback">' . $form_errors['email'] . '</p>' : ''; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-5">
                            <textarea id="message" name="message" class="form-control <?php echo isset($form_errors['message']) ? 'is-invalid' : ''; ?>" rows="6" placeholder="Your message*"><?php echo isset($_POST['message']) ? $_POST['message'] : ''; ?></textarea>
                            <?php echo isset($form_errors['message']) ? '<p class="invalid-feedback">' . $form_errors['message'] . '</p>' : ''; ?>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-default btn-webforce">Send message</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php else: ?>
            <h2>Message sent, thank you <?php echo $_POST['name']; ?></h2>
            <textarea id="message" name="message" class="form-control" rows="6" placeholder="Your message*" readonly><?php echo isset($_POST['message']) ? $_POST['message'] : ''; ?></textarea>
            <?php endif; ?>
        </div>
    </section>
    
    <?php
        require_once('footer.php');
    ?>
