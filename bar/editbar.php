<?php
    require_once('lib/database.php');
    require_once('lib/fonctions.php');

    // Initialisation des variables d'erreurs
    $errors = [];
    $form_errors = [];

    // Si le formulaire de validation du bar soumis
    if (postValue('editbar') == 1) {
        // Validation des champs
        if (!$name = postValue('name'))
            $form_errors['name'] = "Le champ nom est obligatoire";

        if (!$adresse = postValue('adresse'))
            $form_errors['adresse'] = "Le champ adresse est obligatoire";
        
        // Si une image a été fournie par l'utilisateur
        $img_path = '';
        if (isset($_FILES['image'])) {
            // nom temporaire de l'image
            $tmp_name = $_FILES['image']['tmp_name'];

            // Récupération de l'extension du fichier en fonction de son type (http://php.net/manual/en/function.pathinfo.php)
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $img_name = $name . '.' . $extension;
            $img_path = '/img/bar/' . $img_name;

            // Déplacement du fichier dans le dossier des images de bar
            if (file_exists($tmp_name)) {
                rename($tmp_name, $img_path);
            }
        }

        if (count($form_errors) == 0) {
            $db = connexion();
            $query = $db->prepare("insert into bar (name, adresse, image) values (:name, :adresse, :image)");
            $query->bindValue(':name', $name, PDO::PARAM_STR);
            $query->bindValue(':adresse', $adresse, PDO::PARAM_STR);
            $query->bindValue(':image', $img_path, PDO::PARAM_STR);
            $query->execute();

            redirect('index.php');
        }
    }

    // Affichage de l'entête
    $title = "Edition fiche";
    require_once('header.php');
?>

<form method="post" class="form" enctype="multipart/form-data">
    <input type="hidden" name="editbar" value="1"/>
    <div class="form-label-group">
        <input type="text" id="name" name="name" class="form-control <?php echo isset($form_errors['name']) ? 'is-invalid' : '' ?>" placeholder="Nom du bar"/>
        <label for="name">Nom du bar</label>
        <?php echo isset($form_errors['name']) ? '<div class="invalid-feedback">' . $form_errors['name'] . '</div>' : '' ?>
    </div>
    <div class="form-label-group">
        <input type="text" id="adresse" name="adresse" class="form-control <?php echo isset($form_errors['adresse']) ? 'is-invalid' : '' ?>"placeholder="Adresse"/>
        <label for="adresse">Adresse</label>
        <?php echo isset($form_errors['adresse']) ? '<div class="invalid-feedback">' . $form_errors['adresse'] . '</div>' : '' ?>
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" id="image" name="image" class="form-control-file" placeholder="Image" accept="image/*"/>
        <?php echo isset($form_errors['image']) ? '<div class="invalid-feedback">' . $form_errors['image'] . '</div>' : '' ?>
    </div>

    <button type="submit" class="btn btn-lg btn-primary btn-block">Valider</button>
</form>

<?php
    require_once('footer.php');
?>