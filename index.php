<?php
include_once './conf.php';
include_once './head.php';
if ($db->connect_error) {
    die("connection err: " . $db->connect_error);
}

$queryCli = "SELECT rowid, nom FROM llx_societe";
$queryProd = "SELECT rowid, label FROM llx_product";

$resCLi = $db->query($queryCli);
$resProd = $db->query($queryProd);

?>
<form action="">
    <select id="clients">
        <?php
        while ($row = $resCLi->fetch_assoc()) {
            echo ('<option id=' . $row["rowid"] . ">" . $row['nom'] . "</option>");
        }
        ?>
    </select>
    Lista de productos:
    <?php
    while ($row = $resProd->fetch_assoc()) {
        echo ('<li><input type="checkbox" id=' . $row["rowid"] . ">" . $row['label'] . "</input></li>");
    }
    ?>
    <ul>

    </ul>
</form>

</body>