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
<form action="./createOrder.php" method="POST">
    <select name="client">
        <?php
        while ($row = $resCLi->fetch_assoc()) {
            echo ('<option value=' . $row["rowid"] . ">" . $row['nom'] . "</option>");
        }
        ?>
    </select>
    <br>
    Lista de productos:
    <br>
    <?php
    while ($row = $resProd->fetch_assoc()) {
        // $count = isset($count) ? $count++ : 0;
        echo ('<label><input type="checkbox" name="products[]" value=' . $row["rowid"] . ">" . $row['label'] . "</input><br><label>");
    }

    ?>

    </ul>
    <input type="submit" value="Send">
</form>
<?php
include_once 'footer.php';
