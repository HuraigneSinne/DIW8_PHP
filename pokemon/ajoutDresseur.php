<?php
    // Erreurs du formualaire
    $form_errors = [];

    // Si le formulaire est soumis
    if (isset($_POST['form_dresseur'])) {
        if (empty($_POST['prenom']))
            $form_errors['prenom'] = 'Le prénom est obligatoire';
        elseif(strlen($_POST['prenom']) < 3) 
            $form_errors['prenom'] = 'Le prénom doit faire au moins 3 caractères';
        
        if (empty($_POST['nom']))
            $form_errors['nom'] = 'Le nom est obligatoire';
        
        if (empty($_POST['email']))
            $form_errors['email'] = 'L\'email est obligatoire';
        elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            $form_errors['email'] = 'L\'email est invalide';
        
        if (empty($_POST['date_licence']))
            $form_errors['date_licence'] = 'La date de licence est obligatoire';
        else {
            $date_licence = new DateTime($_POST['date_licence']);
            $date = new DateTime('now');
            $date->setTime(0, 0);
            if ($date < $date_licence)
                $form_errors['date_licence'] = 'La date de licence n\est pas valide';
        }

        if (count($form_errors) == 0) {
            // Connexion à la base
            try {
                $db_options = array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", // On force l'encodage en utf8
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // On récupère tous les résultats en tableau associatif
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING // On affiche des warnings pour les erreurs, à commenter en prod (valeur par défaut PDO::ERRMODE_SILENT)
                );
                $db = new PDO('mysql:host=localhost;dbname=pokemon', 'root', '', $db_options);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }

            $query = $db->prepare("INSERT INTO dresseur (prenom, nom, adresse, email, date_licence, arene_prefere) VALUES (:prenom, :nom, :adresse, :email, :date_licence, :arene_prefere)");
            $query->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
            $query->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
            $query->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
            $query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
            $query->bindValue(':date_licence', $_POST['date_licence'], PDO::PARAM_STR);
            $query->bindValue(':arene_prefere', $_POST['arene_prefere'], PDO::PARAM_STR);
            
            if (!$query->execute())
                echo '<p style="color: red;">Il y a eu une erreur lors de l\'ajout du dresseur</p>';
            else
                echo '<p style="color: green;">Le dresseur a été ajouté avec succès !</p>';
        }
    }
?>

<form method="post">
    <input type="hidden" name="form_dresseur" value="1"/>
    <div>
        <label for="prenom">Prénom : </label>
        <input type="text" style="<?php echo isset($form_errors['prenom']) ? 'border-color: red;' : ''; ?>" id="prenom" name="prenom"/>
        <?php echo isset($form_errors['prenom']) ? '<span style="color: red;">' . $form_errors['prenom'] . '</span>' : ''; ?>
    </div>
    <div>
    <label for="nom">Nom : </label>
    <input type="text" style="<?php echo isset($form_errors['nom']) ? 'border-color: red;' : ''; ?>" id="nom" name="nom"/>
    <?php echo isset($form_errors['nom']) ? '<span style="color: red;">' . $form_errors['nom'] . '</span>' : ''; ?>
    </div>
    <div>
    <label for="adresse">Adresse : </label>
    <input type="text" style="<?php echo isset($form_errors['adresse']) ? 'border-color: red;' : ''; ?>" id="adresse" name="adresse"/>
    <?php echo isset($form_errors['adresse']) ? '<span style="color: red;">' . $form_errors['adresse'] . '</span>' : ''; ?>
    </div>
    <div>
    <label for="email">Email : </label>
    <input type="email" style="<?php echo isset($form_errors['email']) ? 'border-color: red;' : ''; ?>" id="email" name="email"/>
    <?php echo isset($form_errors['email']) ? '<span style="color: red;">' . $form_errors['email'] . '</span>' : ''; ?>
    </div>
    <div>
    <label for="date_licence">Date de licence : </label>
    <input type="date" style="<?php echo isset($form_errors['date_licence']) ? 'border-color: red;' : ''; ?>" id="date_licence" name="date_licence"/>
    <?php echo isset($form_errors['date_licence']) ? '<span style="color: red;">' . $form_errors['date_licence'] . '</span>' : ''; ?>
    </div>
    <div>
    <label for="arene_prefere">Arène préférée : </label>
    <select id="arene_prefere" style="<?php echo isset($form_errors['arene_prefere']) ? 'border-color: red;' : ''; ?>" name="arene_prefere">
        <option value="Argenta">Argenta</option>
        <option value="Azuria">Azuria</option>
        <option value="Carmin-sur-Mer">Carmin-sur-Mer</option>
        <option value="Céladopole">Céladopole</option>
        <option value="Parmanie">Parmanie</option>
        <option value="Safrania">Safrania</option>
        <option value="Cramois'Île">Cramois'Île</option>
        <option value="Jadielle">Jadielle</option>
    </select>
    <?php echo isset($form_errors['arene_prefere']) ? '<span style="color: red;">' . $form_errors['arene_prefere'] . '</span>' : ''; ?>
    </div>
    <div>
    <button>Enregistrer</button>
</form>
