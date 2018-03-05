<?php
    require_once('lib/database.php');
    require_once('lib/fonctions.php');

    $errors = [];
    $form_errors = [];

    $db = connexion();

    // Si on a un token fourni (étape 2)
    $token = getValue('token');
    if ($token != '') {
        // Vérification du token en base
        $query = $db->prepare("SELECT id_user, token_valid_until FROM auth_user WHERE token = :token");
        $query->bindValue(':token', $token, PDO::PARAM_STR);
        $query->execute();

        // Si le token n'est pas en base affichage d'une page d'interdiction (403)
        if (!$user = $query->fetch()) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden !!', true, 403);
            die("accès refusé");
        }

        // Calcul de la validité de date du token si invalide affichage d'une page d'interdiction (403)
        $token_valid_until = new DateTime($user['token_valid_until']);
        $date = new DateTime('now');    // Date actuelle
        $date->setTime(0, 0);           // Remise à 0 de l'heure de la date actuelle
        if ($date > $token_valid_until) {
            // Suppression des lignes de auth_user concernant cet utilisateur
            $query = $db->prepare("DELETE FROM auth_user WHERE id_user = :id_user");
            $query->bindValue(':id_user', $user['id_user'], PDO::PARAM_INT);
            $query->execute();
            // Affichage de la page d'interdiction
            header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden !!', true, 403);
            die("accès refusé");
        }

        // A partir d'ici le token est valide, le formulaire de changement du mot de passe peut être affiché
    }


    // Si le formulaire de changement du mot de passe est fourni (étape 3)
    if (postValue('pasword_form') == 1) {
        // Validation du mot de passe
        $password = postValue('password');
        $passwordConfirm = postValue('passwordConfirm');

        if ($password == '') {
            $form_errors['password'] = "Veuillez saisir un mot de passe";
        }
        if ($passwordConfirm == '') {
            $form_errors['passwordConfirm'] = "Veuillez saisir un mot de passe";
        } elseif ($password != $passwordConfirm) {
            $form_errors['password'] = "Mot de passe différent !";
        }

        if (count($form_errors) == 0) {
            // Modification du mot de passe de l'utilisateur
            $query = $db->prepare("UPDATE `user` SET password = :password WHERE id = :id");
            $query->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $query->bindValue(':id', $user['id_user'], PDO::PARAM_INT);
            $query->execute();

            // Suppression des lignes de auth_user concernant cet utilisateur
            $query = $db->prepare("DELETE FROM auth_user WHERE id_user = :id_user");
            $query->bindValue(':id_user', $user['id_user'], PDO::PARAM_INT);
            $query->execute();

            // Connexion de l'utilisateur
            redirect('index.php');
        }
    }

    // Si le formulaire d'oubli du mot de passe est fourni (étape 1)
    if (postValue('forgot_form') == 1) {
        $email = postValue('email');

        if ($email == '') {
            $form_errors['email'] = "Veuillez saisir un email";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $form_errors['email'] = "Adresse email invalide !";
        }

        if (count($form_errors) == 0) {
            // Vérification de la présence de l'email dans la table user
            $query = $db->prepare("SELECT id FROM user WHERE email = :email");
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->execute();
            if (!$user = $query->fetch())
                $form_errors['email'] = "Adresse email non trouvée";
            else {
                // l'utilisateur existe, Génération du token
                $token = md5(uniqid(rand(), true));

                // Calcul de la date de validité
                $date = new DateTime('now');
                $date->add(new DateInterval('P2D'));   // Ajoute 2 jours
                $token_valid_until = $date->format('Y-m-d');

                // Inscription du token en base
                $query = $db->prepare("INSERT INTO auth_user (id_user, token, token_valid_until) VALUES (:id_user, :token, :token_valid_until)");
                $query->bindValue(':id_user', $user['id'], PDO::PARAM_INT);
                $query->bindValue(':token', $token, PDO::PARAM_STR);
                $query->bindValue(':token_valid_until', $token_valid_until, PDO::PARAM_STR);
                $query->execute();

                // Préparation du mail
                $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[SCRIPT_NAME]";
                $_GET['token'] = $token;
                $url .= "?" . http_build_query($_GET);

                $text = "
Bonjour,
Pour réinitialiser votre mot de passe utilisez cette adresse :
$url
Si vous n'êtes pas à l'origine de cette demande, merci d'ignorer ce message.
";
                $headers = "content-type: text/html; charset=\"UTF-8\"" . "\r\n";

                // Envoi du mail
                if (!mail($email, 'Modifier votre mot de passe', $text, $headers)) {
                    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
                    die ("Impossible d'envoyer l'email");
                }
            }
        }
    }

    // Affichage de l'entête
    require_once('header.php');
?>

<div class="container">
    <?php if (empty($token)) :  // Si le token est vide (étape 1)?>

    <h2>Veuillez saisir votre adresse email</h2>
    <form method="post" class="form">
        <input type="hidden" name="forgot_form" value="1"/>
        <div class="form-label-group">
            <input type="email" class="form-control <?php echo isset($form_errors['email']) ? 'is-invalid' : '' ?>" name="email" id="email" placeholder="Votre email" required autofocus/>
            <label for="email">Votre email</label>
            <?php echo isset($form_errors['email']) ? '<div class="invalid-feedback">' . $form_errors['email'] . '</div>' : '' ?>
        </div>
        <button class="btn btn-lg btn-primary btn-block">Valider</button>
    </form>

    <?php elseif (isset($url)) : // fin de l'étape 1 après création de l'url ?>

    <span>Vous allez recevoir un email avec un lien pour pouvoir modifier votre mot de passe</span>    

    <?php else : // Sinon (étape 2) ?>

    <h2>Veuillez saisir votre nouveau mot de passe</h2>
    <form method="post" class="form">
        <input type="hidden" name="pasword_form" value="1"/>
        <div class="form-label-group">
            <input type="password" class="form-control <?php echo isset($form_errors['password']) ? 'is-invalid' : '' ?>" name="password" id="password" placeholder="Votre mot de passe" required autofocus/>
            <label for="password">Votre mot de passe</label>
            <?php echo isset($form_errors['password']) ? '<div class="invalid-feedback">' . $form_errors['password'] . '</div>' : '' ?>
        </div>
        <div class="form-label-group">
            <input type="password" class="form-control <?php echo isset($form_errors['passwordConfirm']) ? 'is-invalid' : '' ?>" name="passwordConfirm" id="passwordConfirm" placeholder="Confirmez" required autofocus/>
            <label for="passwordConfirm">Confirmez</label>
            <?php echo isset($form_errors['passwordConfirm']) ? '<div class="invalid-feedback">' . $form_errors['passwordConfirm'] . '</div>' : '' ?>
        </div>
        <button class="btn btn-lg btn-primary btn-block">Valider</button>
    </form>

    <?php endif; ?>

</div>

<?php
    require_once('footer.php');
?>