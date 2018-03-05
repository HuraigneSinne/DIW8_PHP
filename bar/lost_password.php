<?php
    require_once('lib/database.php');
    require_once('lib/fonctions.php');

    $errors = [];
    $form_errors = [];

    // Si on a un token fourni (étape 2)


    // Si le formulaire de changement du mot de passe est fourni (étape 3)


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
            $db = connexion();
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
    <?php if (!isset($url)) : ?>
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

    <?php else : ?>
    <span>Vous allez recevoir un email avec un lien pour pouvoir modifier votre mot de passe</span>
    <?php endif; ?>

</div>

<?php
    require_once('footer.php');
?>