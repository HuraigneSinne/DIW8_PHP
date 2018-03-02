<?php
    $title = "Projet bar";
    require_once('header.php');

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
        </tr>
        ';
        foreach ($bars as $bar) {
            $content .= '<tr>';
            $content .= '<td><i class="fas fa-search"></i></td>';
            foreach($bar as $barinfo)
                $content .= '<td>' . $barinfo . '</td>';
            $content .= '</tr>';
        }
    }

    echo $content;

    require_once('footer.php');
?>