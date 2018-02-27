<?php
    require_once('header.php');
?>


<?php
    $db = connexion();

    if (isset($_GET['id'])) {
        // Préparation de la requête
        $query = $db->prepare("SELECT name AS Nom, email AS Email, message AS Message FROM contact WHERE id = :id");
        $query->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

        // Exécution de la requête
        $query->execute();

        // Récupération du résultat
        if (!$result = $query->fetchAll())
            echo "Rien à afficher";
        else {
            echo table_html($result);
        }
    }

    if (isset($_GET['name'])) {
        // Préparation de la requête
        $query = $db->prepare("SELECT name AS Nom, message AS Message FROM contact WHERE name = :name");
        $query->bindValue(':name', $_GET['name'], PDO::PARAM_STR);

        // Exécution de la requête
        $query->execute();

        // Récupération du résultat
        if (!$results = $query->fetchAll())
            echo "Rien à afficher";
        else {
            echo table_html($results);
        }

    }

?>


<?php
    require_once('footer.php');
?>