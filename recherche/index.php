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
    ?>
    <form>
        <input type="search" name="recherche"/>
        <?php
            echo select('choix_carte', $carte);
            echo select('choix_carte', $carte, true);
        ?>
        <button>Rechercher</button>
    </form>

</body>
</html>