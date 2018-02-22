<?php

var_dump($_POST);

if (strlen($_POST['pseudo']) == 0)
    echo "Le pseudo ne doit pas être vide";

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    echo "l'email est invalide";
