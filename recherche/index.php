<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Recherche</title>
</head>
<body>
    <?php
       require_once('recherche.php');

        if (isset($_GET['recherche'])) {
            echo recherche($_GET['recherche']);
        }

        $carte = [
            'cafe' => 0.5,
            'biere' => 2.5,
            'sirop' => 1.5,
            'whisky' => 4
        ];

        if (!empty($_GET['choix_carte']))
            echo "Le prix est de " . $_GET['choix_carte'];

    ?>
    <form>
        <input type="search" name="recherche"/>
        <?php
            echo select('choix_carte', $carte, true);
        ?>
        <button>Rechercher</button>
    </form>

</body>
</html>