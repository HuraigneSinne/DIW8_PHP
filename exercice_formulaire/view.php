<?php
    require_once('header.php');
?>

<?php
    // Le numéro de la page que nous souhaitons visualiser
    $page = getInt('page', 1);

    $offset = ($page - 1) * 5;   // Si on est à la page 1, (1-1)*10 = OFFSET 0, si on est à la page 2, (2-1)*10 = OFFSET 10, etc.

    // Filtre de recherche sur les colonnes nom/prénom/email/téléphone
    $search = getValue('search');
    

    $db = connexion();

    $query = $db->query("SELECT COUNT(*) AS nb FROM utilisateur");
    $nb_elements = $query->fetch()['nb'];
    $max_page = ceil($nb_elements / 5);

    $query_string = "
        SELECT id,
               firstname as Prénom, 
               lastname as Nom,
               email as Email,
               gender as genre,
               DATE_FORMAT(birthdate, '%d/%m/%Y') as \"Date de naissance\",
               phone as Téléphone,
               mail_subscribe as \"Contact par email\", phone_subscribe as \"Contact par téléphone\"
        FROM utilisateur
        LIMIT 5 OFFSET $offset
    ";

    $query = $db->query($query_string);

    $results = $query->fetchAll();

    $tableau = table_html($results, true, 'index.php');

    echo $tableau;

    if ($page > 1 ) // Seulement si on est sur la page 2 ou plus, afficher un bouton "Précédent"
    {
        echo '<a href="?page=' . ($page - 1) . '">Précédent </a>';
    }
    if ($page < $max_page) // Seulement si on est pas sur la dernière page, afficher un bouton "Suivant"
    {
        echo '<a href="?page=' . ($page + 1) . '">Suivant</a>';
    }
?>

<?php
    require_once('footer.php');
?>