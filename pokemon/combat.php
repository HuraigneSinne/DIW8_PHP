<?php
$attack1 = 49 ;
$attack2  = 52;
$def1 = 49;
$def2 = 43;
$pv1  = 45;
$pv2  = 39;

// echo $degat1."\n";
// echo $degat2;
  function tour ( ){
    global  $pv1;
    global  $pv2;
    global  $def1;
    global  $def2;
    global  $attack1;
    global  $attack2;
    $degat1 =round(((1 + $attack1 / 100) * 8)*($def2  / 100));
    $degat2 =round(((1 + $attack2 / 100) * 8)*($def1  / 100));
    if ($pv2<=0) {
      return  "le joueur 1 gagne";
    }else {
      $pv2  = $pv2  -  $degat1;
    }
    if ($pv2<=0) {
      return  "le joueur 2 gagne";
    }else {
      $pv1 =  $pv1  - $degat2;
    }
  }
  echo $pv1;
  echo $pv2;

while ($pv1>=0 && $pv2>=0) {


  echo tour();
  echo $pv1."\n";
  echo $pv2."\n";
};
// round arondir
 ?>
