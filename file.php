
<?php
    echo "<pre>";
    foreach($_FILES as $fileinput => $file) {
        echo "ouverture du fichier $fileinput\n";
        if (!$fh = fopen($file["tmp_name"], 'r'))
            die("impossible d'ouvrir le fichier " . $file["tmp_name"]);
        
        while ($line = fread($fh, 50)) {
            echo htmlspecialchars("$line");
        }

        fclose($fh);
    }
    echo "</pre>";
?>


<!-- L'attribut enctype doit absolument être "multipart/form-data", et la méthode doit être POST -->
<form method="POST" enctype="multipart/form-data">
    <!-- La balise input type="file" permet de sélectionner un fichier sur son ordinateur. Ne pas oublier l'attribut "name"-->
    <input type="file" name="my_pic" />
    <input type="submit" value="Envoyer"/>
</form>