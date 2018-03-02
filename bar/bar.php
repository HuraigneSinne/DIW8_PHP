<?php
    $title = "Fiche";
    require_once('header.php');

    $id_bar = getInt('id');
    $page_error = [];
    $bar = [];

    // récupération des infos du bar
    if ($id_bar != 0) {
        $db = connexion();
        $query = $db->prepare("SELECT name, adresse, rating, style FROM bar WHERE id = :id");
        $query->bindValue(":id", $id_bar, PDO::PARAM_INT);
        $query->execute();
        if (!$bar = $query->fetch())
            $page_error[] = 'Bar inconnu';
    }

?>
    
    <main role="main" class="container">
        <h1>Fiche du bar N°<?php echo $id_bar; ?></h1>
        <h2>Nom : <?php echo $bar['name']; ?></h2>
        <ul>
            <li>Adresse : <?php echo $bar['adresse']; ?></li>
            <li>Note : <?php echo $bar['rating']; ?></li>
            <li>Style : <?php echo $bar['style']; ?></li>
        </ul>
        <div>
            
        </div>
    </main>

<?php
    require_once('footer.php');
?>