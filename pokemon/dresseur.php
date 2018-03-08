<?php

if (empty($_GET['id']))
    die("Aucun dresseur trouvé");

$id_dresseur = (int) $_GET['id'];

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

$query = $db->prepare('SELECT * FROM dresseur WHERE id = :id');
$query->bindValue(':id', $id_dresseur, PDO::PARAM_INT);
$query->execute();

if (!$dresseur = $query->fetch())
    die("Aucun dresseur trouvé");


echo "<ul>";
echo "<li><b>Prénom :</b> " . $dresseur['prenom'] . '</li>';
echo "<li><b>Nom : </b>" . $dresseur['nom'] . '</li>';
echo "<li><b>Adresse : </b>" . $dresseur['adresse'] . '</li>';
echo "<li><b>Email : </b>" . $dresseur['email'] . '</li>';
$date_licence = new DateTime($dresseur['date_licence']);
echo "<li><b>Date de licence : </b>" . $date_licence->format('d/m/Y') . '</li>';
echo "<li><b>Arène préférée : </b>" . $dresseur['arene_prefere'] . '</li>';
echo "</ul>";
