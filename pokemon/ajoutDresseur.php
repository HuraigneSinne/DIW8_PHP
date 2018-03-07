<?php
    // Erreurs du formualaire
    $form_errors = [];

    // Si le formulaire est soumis
    if (isset($_POST['form_dresseur'])) {
        if (!isset($_POST['prenom']))
            $form_errors['prenom'] = 'Le prénom est obligatoire';
        elseif(strlen($_POST['prenom']) < 3) 
            $form_errors['prenom'] = 'Le prénom doit faire au moins 3 caractères';
        
        if (!isset($_POST['nom']))
            $form_errors['nom'] = 'Le nom est obligatoire';
        
        if (!isset($_POST['email']))
            $form_errors['email'] = 'L\'email est obligatoire';
        elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            $form_errors['email'] = 'L\'email est invalide';
        
        if (!isset($_POST['date_licence']))
            $form_errors['date_licence'] = 'La date de licence est obligatoire';
        else {
            $date_licence = new DateTime($_POST['date_licence']);
            $date = new DateTime('now');
            $date->setTime(0, 0);
            if ($date < $date_licence)
                $form_errors['date_licence'] = 'La date de licence n\est pas valide';
        }

        if (count($form_errors) == 0) {
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
        }
    }
?>

<form method="post">
    <input type="hidden" name="form_dresseur" value="1"/>
    <label for="prenom">Prénom : </label>
    <input type="text" id="prenom" name="prenom"/>
    <label for="nom">Nom : </label>
    <input type="text" id="nom" name="nom"/>
    <label for="adresse">Adresse : </label>
    <input type="text" id="adresse" name="adresse"/>
    <label for="email">Email : </label>
    <input type="email" id="email" name="email"/>
    <label for="date_licence">Date de licence : </label>
    <input type="date" id="date_licence" name="date_licence"/>
    <label for="arene_prefere">Arène préférée : </label>
    <select id="arene_prefere" name="arene_prefere">
        <option value="Argenta">Argenta</option>
        <option value="Azuria">Azuria</option>
        <option value="Carmin-sur-Mer">Carmin-sur-Mer</option>
        <option value="Céladopole">Céladopole</option>
        <option value="Parmanie">Parmanie</option>
        <option value="Safrania">Safrania</option>
        <option value="Cramois'Île">Cramois'Île</option>
        <option value="Jadielle">Jadielle</option>
    </select>
    <button>Enregistrer</button>
</form>
