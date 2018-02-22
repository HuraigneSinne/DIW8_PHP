<?php


echo '
<form method="POST" action="contact.php">
    <label for="id_civilite">Civilite :</label>
    <select id="id_civilite" name="civilite">
        <option value="Madame">Madame</option>
        <option value="Monsieur">Monsieur</option>
    </select>
    <label for="id_pseudo">Pseudo :</label>
    <input type="text" id="id_pseudo" name="pseudo" />
    <label for="id_contenu">Contenu :</label>
    <textarea id="id_contenu" name="contenu"></textarea>
    <label for="id_email">Email :</label>
    <input type="text" id="id_email" name="email" />
    <br>
    <input type="submit"/>
</form>
';


$prenom = "Jonathan";

echo "<h1>\n";
echo "Bonjour je m'appelle $prenom\n";
echo "<br>\n";   // un peu de HTML pour faire un saut de ligne sur le navigateur
echo 'Bonjour le m\'appelle $prenom' . "\n";
echo "<br>\n";
echo "Oups, j'ai affiché \"$prenom\" au lieu de $prenom\n";

echo "<br>\n";
echo 'Bonjour je m\'appelle ' . $prenom . "\n";
echo "</h1>\n";

$a;
$b;
$c = '';

$c = 'C';

echo $a ?? $b ?? $c ?? '';
echo "<br>\n";

$b = 'B';
echo $a ?? $b ?? $c;
echo "<br>\n";

$b = null;
echo $a ?? $b ?? $c;
echo "<br>\n";


$space1 = 10;
$space2 = 10;

switch ($space1 <=> $space2) {
    case -1:
        echo "space1 est plus petit que space2\n <br>";
        break;

    case 0:
        echo "space1 est égal à space2\n <br>";
        break;

    case 1:
        echo "space1 est plus grand que space2\n <br>";
        break;
}



// jouer avec timestamp
echo "Début de la requête à : " . date('d/m/Y H:i:s', $_SERVER['REQUEST_TIME']) . "\n<br>";

sleep(1);

echo "Fin de la requête à : " . date('d/m/Y H:i:s') . "\n<br>";



echo "<h2>Parcours d'un tableau</h2>\n";
$personnes = array(
    '0' => array(
        'nom' => 'Dupont',
        'prenom' => 'Pierre',
        'email' => 'pierre.d@gmail.com',
        'telephones' => array(
            'fixe' => '03 00 00 00 00',
            'portable' => '06 00 00 00 00'
        )
    ),
    '1' => array(
        'nom' => 'Dupont',
        'prenom' => 'Jean',
        'email' => 'jean.d@gmail.com',
        'telephones' => array(
            'fixe' => '03 00 00 00 00',
            'portable' => '06 00 00 00 00'
        )
    ),
    '2' => array(
        'nom' => 'Dupont',
        'prenom' => 'Marie',
        'email' => 'marie.d@gmail.com',
    ),
  );

$a = 5;

echo "Les téléphones fixe des personnes sont :\n";
echo "<ul>\n";
foreach($personnes as $a) {
    echo "  <li>" . $a['prenom'] . " : ";
    if (isset($a['telephones']))
        echo $a['telephones']['fixe'];
    echo "</li>\n";
}
echo "</ul>";

echo "<pre>";
var_dump($a);


print_r($personnes);
echo "</pre>";

foreach($personnes as $personne) {
    echo "<ul>\n";
    foreach($personne as $cle_info => $info) {
        if (!is_array($info))
            echo "<li>$cle_info : $info</li>\n";
        else {
            foreach($info as $cle => $element)
                echo "<li>$cle : $element</li>\n";
        }
    }
    echo "</ul>\n";
}
