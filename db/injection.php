<pre>
<?php

$id = $_GET['id'];

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

var_dump('SELECT * FROM user WHERE id = ' . $id);

$query = $db->query('SELECT * FROM user WHERE id = ' . $id);

$user = $query->fetchAll();

var_dump($user);