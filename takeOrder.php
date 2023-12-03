
<?php

$host = 'localhost';
$usuario = 'dolibarrmysql';
$contrasena = 'changeme';
$base_de_datos = 'dolibarr';
$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $cliente_seleccionado = $_POST['cliente'];
  $productos_seleccionados = isset($_POST['productos']) ? $_POST['productos'] : array();

  // Datos para el pedido
  $datos_pedido = array(
    'socid' => $cliente_seleccionado,
    'lines' => array()
  );

  // Agregar productos al pedido
  foreach ($productos_seleccionados as $producto) {
    $datos_pedido['lines'][] = array(
      'desc' => 'Producto',
      'subprice' => 10, // Precio del producto
      'total_ht' => 10, // Total sin impuestos
      'total_ttc' => 12.1, // Total con impuestos
      'qty' => 1 // Cantidad
    );
  }
}
//Cliente
echo "Cliente: ",  $cliente_seleccionado, "<br>";
//PRODUCT 
foreach ($productos_seleccionados as $tmp) {
  echo $tmp . "<br>";
}

//INSERT ORDER

// $sql_order = "SELECT ref FROM llx_commande ORDER BY rowid DESC LIMIT 1";
// $result_sql_order = $conn->query($sql_order);
// echo $result_sql_order ,"adasd<br>";

// get primary key for order
$queryRef = "SELECT COUNT(ref) FROM llx_commande";
$resRef = $conn->query($queryRef);
$ref = $resRef->fetch_array(MYSQLI_NUM);
$commandeKey = $ref[0];

$sql_insert_order =  "INSERT INTO llx_commande (fk_soc,ref)
    values($cliente_seleccionado,$commandeKey)";
if ($conn->query($sql_insert_order) === TRUE) {
  echo "New record created successfully<br>";
} else {
  echo "Error: " . $sql_insert_order . "<br>" . $conn->error;
}

//INSERT LIST PRODUCT
$sql_id_order = "SELECT rowid FROM llx_commande order by rowid DESC limit 1";
$result_sql_id_order = $conn->query($sql_id_order);
while ($row = $result_sql_id_order->fetch_assoc()) {
  $id_customer = $row["rowid"];
  echo $id_customer, "  ";

  foreach ($productos_seleccionados as $tmp) {
    echo $tmp . "<br>";

    $sql_insert_product = "INSERT INTO llx_commandedet (fk_commande,fk_product)
            values($id_customer,$tmp)";
    $conn->query($sql_insert_product);
  }
}




$conn->close();
?>