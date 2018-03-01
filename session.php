<?php

session_start();

if(isset($_SESSION['ma_cle']))
    var_dump($_SESSION);
else {
    echo "la session n'est pas initilisée";
    $_SESSION['ma_cle'] = 'hello !';
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
}


