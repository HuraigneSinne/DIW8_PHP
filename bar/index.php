<?php
    require_once('lib/database.php');
    require_once('lib/fonctions.php');

    $content = '';

    // Récupération des bars
    $db = connexion();
    $query = $db->query("SELECT * FROM bar");
    $bars = $query->fetchAll();

    if (count($bars) == 0) {
        $content = 'Désolé, nous n\'avons rien à vous porposer, revenez plus tard';
    } else {
        $content = '<table class="table">';
        $content .= '<tr>
            <th></th>
            <th>Nom</th>
            <th>Adresse</th>
            <th>Style</th>
            <th>Note</th>
            <th>Image</th>
        </tr>
        ';
        foreach ($bars as $bar) {
            $content .= '<tr>';
            $content .= '<td><i class="fas fa-search"></i></td>';
            foreach($bar as $col => $barinfo) {
                if ($col == 'image')
                    $content .= '<td><img src="' . ($barinfo != '' ? dirname($_SERVER['REQUEST_URI']) . $barinfo : '') . '"/></td>';
                else
                    $content .= '<td>' . $barinfo . '</td>';
            }
            $content .= '</tr>';
        }
    }

    // Affichage de l'entête
    $title = "Projet bar";
    require_once('header.php');

    // Affichage de la liste des bars
    echo $content;

    require_once('footer.php');
?>