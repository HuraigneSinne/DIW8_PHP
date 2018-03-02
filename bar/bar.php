<?php
    $title = "Fiche";
    require_once('header.php');

    $id_bar = getInt('id');
    $page_error = [];

    // récupération des infos du bar
    if ($id_bar != 0) {
        $db = connexion();
        $query = $db->prepare("SELECT name, adresse, rating, style FROM bar WHERE id = :id");
        $query->bindValue(":id", $id_bar, PDO::PARAM_INT);
        $query->execute();
        if (!$bar = $query->fetch())
            $page_error[] = 'Bar inconnu';
    }

    var_dump($page_error);
?>
    
    <main role="main" class="container">
        <h1>Fiche du bar N°<?php echo $id_bar; ?></h1>

        <div>
            
        </div>
    </main>

<?php
    require_once('footer.php');
?>