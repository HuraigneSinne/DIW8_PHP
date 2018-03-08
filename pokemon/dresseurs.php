<?php

// Connexion à la base
try {
    $db_options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", // On force l'encodage en utf8
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // On récupère tous les résultats en tableau associatif
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING // On affiche des warnings pour les erreurs, à commenter en prod (valeur par défaut PDO::ERRMODE_SILENT)
    );
    $db = new PDO('mysql:host=localhost;dbname=pokemon', 'root', '', $db_options);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$query = $db->query("SELECT * FROM dresseur");
$dresseurs = $query->fetchAll();

echo "<table>";
echo "<tr>";
if (count($dresseurs) == 0)
    echo "Aucun dresseur trouvé";
else {
    echo '<th>Prénom</th>';
    echo '<th>Nom</th>';
    echo '<th>Date de licence</th>';
    echo '<th></th>';
}
echo '</tr>';
foreach($dresseurs as $dresseur) {
    echo '<tr>';
    echo '<td>' . $dresseur['prenom'] . '</td>';
    echo '<td>' . $dresseur['nom'] . '</td>';
    $date_licence = new DateTime($dresseur['date_licence']);
    echo '<td>' . $date_licence->format('d/m/Y') . '</td>';
    echo '<td><a href="dresseur.php?id=' . $dresseur['id'] . '">Plus d\'info</td>';
    echo '</tr>';
}
echo "</table>";