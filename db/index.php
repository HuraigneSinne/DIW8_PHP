<?php

define('HOST', 'localhost'); // Domaine ou IP du serveur ou est située la base de données
define('USER', 'root'); // Nom d'utilisateur autorisé à se connecter à la base
define('PASS', ''); // Mot de passe de connexion à la base
define('DB', 'diw8'); // Base de données sur laquelle on va faire les requêtes


// Connexion à la base locale diw8
try {
    $db = new PDO('mysql:host=' . HOST . ';dbname=' . DB, USER, PASS);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Affichage du dernier code erreur
echo "<pre>last code : " . $db->errorCode() . "\n";

var_dump(get_object_vars($db));

$query = $db->query("SELECT * FROM user");
var_dump($query);

$result = $query->fetch();
var_dump($result);

$result = $query->fetch();
var_dump($result);

$result = $query->fetch();
var_dump($result);

$query = $db->query("SELECT firstname FROM user ORDER BY firstname");
$results = $query->fetchAll();
var_dump($results);


$prepare = $db->prepare("SELECT :column1, :column2 FROM user");
var_dump($prepare);

$prepare->bindValue(':column1', 'firstname', PDO::PARAM_STR);
$prepare->bindValue(':column2', 'email', PDO::PARAM_STR);

$prepare->execute();

$result = $prepare->fetchAll();
var_dump($result);

echo "</pre>";