<?php

$dresseurs = [
    [
        'prenom'        => 'Sacha',
        'nom'           => 'Du Bourgpalette',
        'adresse'       => '3e maison à droite au bord du village',
        'email'         => 'jevaisdevenirmaitrepokemon@dresseur.com',
        'date_licence'  => '1996-02-27'
    ],
    [
        'prenom'        => 'Régis',
        'nom'           => 'Du Bourgpalette',
        'adresse'       => 'Chateau du village',
        'email'         => 'jesuislemeilleurmaitrepokemon@dresseur.com',
        'date_licence'  => '1996-02-27'
    ],
];

// Affichage du tableau des dresseurs
foreach($dresseurs as $dresseur) {
    echo "<ul>";
    echo "<li>Prénom : " . $dresseur['prenom'] . '</li>';
    echo "<li>Nom : " . $dresseur['nom'] . '</li>';
    echo "<li>Adresse : " . $dresseur['adresse'] . '</li>';
    echo "<li>Email : " . $dresseur['email'] . '</li>';
    $date_licence = new DateTime($dresseur['date_licence']);
    echo "<li>Date de licence : " . $date_licence->format('d/m/Y') . '</li>';
    echo "</ul>";
}