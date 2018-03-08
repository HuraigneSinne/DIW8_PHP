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

// On capture un pokemon
if (!empty($_POST['pokemon'])) {
    $query = $db->prepare("INSERT INTO dresseur_pokemon (id_dresseur, id_pokemon, date_capture) VALUES (:id_dresseur, :id_pokemon, :date_capture)");
    $query->bindValue(':id_dresseur', $id_dresseur, PDO::PARAM_INT);
    $query->bindValue(':id_pokemon', $_POST['pokemon'], PDO::PARAM_INT);
    $query->bindValue(':date_capture', (new DateTime('now'))->format('Y-m-d'), PDO::PARAM_STR);
    $query->execute();
}

// On relâche un pokemon
if (!empty($_POST['delete'])) {    
    $query = $db->prepare("DELETE FROM dresseur_pokemon WHERE id_dresseur = :id_dresseur AND id_pokemon = :id_pokemon");
    $query->bindValue(':id_dresseur', $id_dresseur, PDO::PARAM_INT);
    $query->bindParam(':id_pokemon', $id_pokemon, PDO::PARAM_INT);
    foreach($_POST['delete'] as $id_pokemon)
        $query->execute();
}

// Recherche des pokemons de ce dresseur
$query = $db->prepare("SELECT * FROM pokemons JOIN dresseur_pokemon ON (id = id_pokemon) WHERE id_dresseur = :id");
$query->bindValue(':id', $id_dresseur, PDO::PARAM_INT);
$query->execute();
$pokemons = $query->fetchAll();

// Recherche des pokemons sauvages
$query = $db->query("SELECT * FROM pokemons WHERE id NOT IN (SELECT id_pokemon FROM dresseur_pokemon)");
$pokemons_sauvages = $query->fetchAll();

echo "<ul>";
echo "<li><b>Prénom :</b> " . $dresseur['prenom'] . '</li>';
echo "<li><b>Nom : </b>" . $dresseur['nom'] . '</li>';
echo "<li><b>Adresse : </b>" . $dresseur['adresse'] . '</li>';
echo "<li><b>Email : </b>" . $dresseur['email'] . '</li>';
$date_licence = new DateTime($dresseur['date_licence']);
echo "<li><b>Date de licence : </b>" . $date_licence->format('d/m/Y') . '</li>';
echo "<li><b>Arène préférée : </b>" . $dresseur['arene_prefere'] . '</li>';
echo "</ul>";

echo '<hr>';

echo '<form method="post">';
echo "<table>";
echo "<tr>";
if (count($pokemons) == 0)
    echo "Aucun pokemon trouvé";
else {
    echo '<th></th>';
    echo '<th>Nom</th>';
    echo '<th>Type</th>';
    echo '<th>PV</th>';
    echo '<th>Attaque</th>';
    echo '<th>Defense</th>';
    echo '<th>Date de capture</th>';
}
echo '</tr>';
foreach($pokemons as $pokemon) {
    echo '<tr>';
    echo '<td><input type="checkbox" name="delete[]" value="' . $pokemon['id'] . '"/></td>';
    echo '<td>' . $pokemon['nom'] . '</td>';
    echo '<td>' . $pokemon['type'] . '</td>';
    echo '<td>' . $pokemon['pv'] . '</td>';
    echo '<td>' . $pokemon['attaque'] . '</td>';
    echo '<td>' . $pokemon['defense'] . '</td>';
    $date_capture = new DateTime($pokemon['date_capture']);
    echo '<td>' . $date_capture->format('d/m/Y') . '</td>';
    //echo '<td><a href="dresseur.php?id=' . $dresseur['id'] . '">Plus d\'info</td>';
    echo '</tr>';
}
echo "</table>";
if (count($pokemons) != 0)
    echo '<button>Relacher</button>';
echo '</form>';

echo '<hr>';

if (count($pokemons_sauvages) > 0) {
    echo '<h2>A la chasse !!</h2>';
    echo '<form method="post">';
    echo '<label for="pokemon">Choisissez votre cible : </label>';
    echo '<select id="pokemon" name="pokemon">';
    echo '<option value=""></option>';
    foreach($pokemons_sauvages as $pokemon) {
        echo '<option value="' . $pokemon['id'] . '">' . $pokemon['id'] . ' - ' . $pokemon['nom'] . '</option>';
    }
    echo '</select>';
    echo '<button>Lancer une pokeball</button>';
}