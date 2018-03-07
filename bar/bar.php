<?php
    $title = "Fiche";
    require_once('header.php');

    $id_bar = getInt('id');
    $page_error = [];
    $bar = [];

    // récupération des infos du bar
    if ($id_bar != 0) {
        $db = connexion();
        $query = $db->prepare("SELECT name, adresse, rating, style, image FROM bar WHERE id = :id");
        $query->bindValue(":id", $id_bar, PDO::PARAM_INT);
        $query->execute();
        if (!$bar = $query->fetch()) {
            die('Bar inconnu');
        }

        $query = $db->prepare("SELECT produit.id, produit.nom, barproduit.prix FROM barproduit JOIN produit ON (id_produit = id) WHERE id_bar = :id");
        $query->bindValue(":id", $id_bar, PDO::PARAM_INT);
        $query->execute();
        $produits = $query->fetchAll();

    } else {
        die("Bar non précisé");
    }

    //if (count($page_error))

?>
    <main role="main" class="container">
        <h1>Fiche du bar N°<?php echo $id_bar; ?></h1>
        <h2>Nom : <?php echo $bar['name']; ?></h2>
        <ul>
            <li>Adresse : <?php echo $bar['adresse']; ?></li>
            <li>Note : <?php echo $bar['rating']; ?></li>
            <li>Style : <?php echo $bar['style']; ?></li>
        </ul>
        <div>
            <table>
                <tr>
                    <th>Id produit</th>
                    <th>Produit</th>
                    <th>Prix</th>
                </tr>
                <?php foreach($produits as $produit) : ?>
                <tr>
                    <td><?php echo $produit['id']; ?></td>
                    <td><?php echo $produit['nom']; ?></td>
                    <td><?php echo $produit['prix']; ?>€</td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>

<?php
    require_once('footer.php');
?>