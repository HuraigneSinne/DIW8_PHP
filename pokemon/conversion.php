<?php

$coursPokedollar = [
    'EUR' => 1.23,
    'USD' => 1.05
];

function conversion($amount, $devise) {
    global $coursPokedollar;

    // Test si la devise existe dans le tableau des cours de devise
    if (!isset($coursPokedollar[$devise]))
        return "La devise $devise n'est pas valide";
    
    // Test si le montant est de type entier ou flottant
    if (!is_int($amount) && !is_float($amount))
        return "La montant doit être un nomber entier ou décimal";
    
    return "$amount $devise = " . $amount * $coursPokedollar[$devise] . " pokedollars";
}


echo conversion(15.5, 'EUR') . "<br>";
echo conversion(1, 'USD') . "<br>";
echo conversion(1, 'BANANA') . "<br>";

