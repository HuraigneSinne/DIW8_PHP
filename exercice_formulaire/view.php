<?php
    require_once('header.php');
?>

<?php
    $db = connexion();

    $query = $db->query("SELECT id, firstname as Prénom, lastname as Nom, email as Email, gender as genre, DATE_FORMAT(birthdate, '%d/%m/%Y') as \"Date de naissance\", phone as Téléphone FROM utilisateur");

    $results = $query->fetchAll();

    $tableau = table_html($results, true, 'index.php');

    echo $tableau;
?>

<?php
    require_once('footer.php');
?>