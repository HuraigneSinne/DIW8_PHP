<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulaire</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,700" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <?php 
        // Démarrage de session
        session_start();
        // Inclusion du fichier database.php
        require_once('../lib/database.php');
        require_once('../lib/fonctions.php');

        $email = '';
        $password = '';
        $form_errors = [];
        $user;

        if (postValue('form-signin') == 1) {
            // Validation du formulaire
            if (!$email = postValue('inputEmail'))
                $form_errors['inputEmail'] = "Le champ email est obligatoire";
            else {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                    $form_errors['inputEmail'] = "Le champ email n'est pas valide";
            }

            if (!$password = postValue('inputPassword'))
                $form_errors['inputPassword'] = "Le champ mot de passe est obligatoire";
            
            // Récupération des informations de l'utilisateur
            if (count($form_errors) == 0) {
                $db = connexion();
                $query = $db->prepare("SELECT id, firstname, lastname, id_role, password FROM user WHERE email = :email");
                $query->bindValue(':email', $email, PDO::PARAM_STR);
                $query->execute();    // Ne pas oublier....
                if (!$user = $query->fetch())
                    $form_errors['inputEmail'] = "Identifiants incorrects";
            }
            
            // Vérification du mot de passe fourni
            if (count($form_errors) == 0) {
                if (!password_verify($password, $user['password']))
                    $form_errors['inputEmail'] = "Identifiants incorrects";
            }

            // Connexion de l'utilisateur
            if (count($form_errors) == 0) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION['id_role'] = $user['id_role'];

                redirect('view.php');
            }
        }
    ?>

    <div class="text-center">
        <form method="post" class="form-signin">
            <input type="hidden" name="form-signin" value="1"/>
            <h1 class="h3 mb-3 font-weight-normal">Connectez-vous (s'il vous plaît)</h1>
            <div class="form-label-group">
                <input type="email" id="inputEmail" name="inputEmail" class="form-control <?php echo isset($form_errors['inputEmail']) ? 'is-invalid' : ''; ?>" placeholder="Votre email" required autofocus value="<?php echo $email ?>">
                <label for="inputEmail">Email address</label>
                <?php echo isset($form_errors['inputEmail']) ? '<p class="invalid-feedback">' . $form_errors['inputEmail'] . '</p>' : ''; ?>
            </div>

            <div class="form-label-group">
                <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Votre mot de passe" required>
                <label for="inputPassword">Password</label>
            </div>

            <button type="submit" class="btn btn-lg btn-primary btn-block">Valider</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>