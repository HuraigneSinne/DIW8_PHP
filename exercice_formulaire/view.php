<?php
    require_once('header.php');
?>

<?php
    $page; // Le numéro de la page que nous souhaitons visualiser
    if (isset($_GET['page']) && !empty($_GET['page']) && ctype_digit($_GET['page'])) // On vérifie si la page est bien un nombre
    {
        $page = $_GET['page'];
    }
    else // Si le paramètre n'est pas spécifié ou n'est pas un nombre valide
    {
        $page = 1;
    }

    $offset = ($page - 1) * 5;   // Si on est à la page 1, (1-1)*10 = OFFSET 0, si on est à la page 2, (2-1)*10 = OFFSET 10, etc.


    $db = connexion();

    $query = $db->query("SELECT COUNT(*) AS nb FROM utilisateur");
    $nb_elements = $query->fetch()['nb'];
    $max_page = ceil($nb_elements / 5);
    
    echo $max_page;

    $query = $db->query("SELECT id, firstname as Prénom, lastname as Nom, email as Email, gender as genre, DATE_FORMAT(birthdate, '%d/%m/%Y') as \"Date de naissance\", phone as Téléphone 
    FROM utilisateur LIMIT 5 OFFSET $offset");

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