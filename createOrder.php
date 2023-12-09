<?php
include_once 'conf.php';
$succesful = true;

if (!isset($_POST)) {
    die();
}

// get data form form
$client = $_POST["client"];
$products = $_POST["products"];

// get primary key for order
$queryRef = "SELECT COUNT(ref) FROM llx_commande";
$resRef = $db->query($queryRef);
$ref = $resRef->fetch_array(MYSQLI_NUM);
$commandeKey = $ref[0];

// to create order, we have to insert into 2 tables
// first table only needs client
$queryOrder =  "INSERT INTO llx_commande (fk_soc,ref)
    values($client,$commandeKey)";

if ($db->query($queryOrder) !== TRUE) {
    echo "Error: " . $queryOrder . "<br>" . $db->error;
    die();
}

// second table only needs products 
foreach ($products as $product) {
    // echo $product . "<br>";
    $queryProduct = "INSERT INTO llx_commandedet (fk_commande,fk_product)
        values($commandeKey,$product)";
    if ($db->query($queryProduct) !== true) {
        echo "Error: " . $queryProduct . "<br>" . $db->error;
        die();
    }
}

echo "New record created successfully<br>";

$db->close();
?>