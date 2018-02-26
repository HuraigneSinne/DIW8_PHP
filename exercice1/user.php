<?php

$info_user = [
    'john' => [
        'nom' => 'john',
        'prenom' => 'john',
        'email' => 'john.john@john.com',
        'birthdate' => '1990-01-01'
    ],
    'toto' => [
        'nom' => 'toto',
        'prenom' => 'toto',
        'email' => 'toto.toto@john.com',
        'birthdate' => '1991-01-01'
    ],
    'test' => [
        'nom' => 'test',
        'prenom' => 'test',
        'email' => 'test.test@john.com',
        'birthdate' => '1990-01-01'
    ]
];

?>

<html>
<head>
</head>
<body>
    <table>
    <?php
        foreach($info_user as $user) {
            echo "<tr>\n";
            echo "<td>" . $user['nom'] . "<td>\n";
            echo "<td>" . $user['prenom'] . "<td>\n";
            echo "<td>" . $user['email'] . "<td>\n";
            echo "<td>" . $user['birthdate'] . "<td>\n";
            echo "</tr>\n";
        }
    ?>
    </table>
</body>
</html>