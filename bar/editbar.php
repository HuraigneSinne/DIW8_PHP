<?php
    $title = "Edition fiche";
    require_once('header.php');

    if (postValue('editbar') == 1) {
        // Validation du formulaire
        if (!$name = postValue('name'))
            $form_errors['name'] = "Le champ nom est obligatoire";

        if (!$adresse = postValue('adresse'))
            $form_errors['adresse'] = "Le champ adresse est obligatoire";

        if (count($form_errors) == 0) {
            $db = connexion();
            $query = $db->prepare("insert into bar (name, adresse) values (:name, :adresse)");
            $query->bindValue(':name', $name, PDO::PARAM_STR);
            $query->bindValue(':adresse', $adresse, PDO::PARAM_STR);
            $query->execute();

            redirect('index.php');
        }
    }
?>

<form method="post" class="form">
    <input type="hidden" name="editbar" value="1"/>
    <div class="form-label-group">
        <input type="text" id="name" name="name" placeholder="Nom du bar"/>
        <label for="name">Nom du bar</label>
    </div>
    <div class="form-label-group">
        <input type="text" id="adresse" name="adresse" placeholder="Adresse"/>
        <label for="adresse">Adresse</label>
    </div>

    <button type="submit" class="btn btn-lg btn-primary btn-block">Valider</button>
</form>

<?php
    require_once('footer.php');
?>