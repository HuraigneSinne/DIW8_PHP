<?php

$users = [
    ['login' => 'john', 'password' => 'motdepasse'],
    ['login' => 'toto', 'password' => 'motdepass1'],
    ['login' => 'test', 'password' => 'motdepass2']
];

/*
Autre déclaration possible :

$users = array(
    array('login' => 'john', 'password' => 'motdepasse'),
    array('login' => 'toto', 'password' => 'motdepass1'),
    array('login' => 'test', 'password' => 'motdepass2')
);

*/

if (isset($_POST['login']) && isset($_POST['motdepasse'])) {
    $connected = false;
    foreach($users as $user) {
        if ($user['login'] == $_POST['login'] && $user['password'] == $_POST['motdepasse']) {
            header("Location: user.php?login=" . $user['login']);
            die();
        }
    }
}

if ($connected) {
    echo "Bienvenue";
} else {
    header("Location: index.php");
    die();
}