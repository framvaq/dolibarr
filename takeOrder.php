
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
    foreach($productos_seleccionados as $tmp) {
        echo $tmp . "<br>";
    }

    //INSERT ORDER

    // $sql_order = "SELECT ref FROM llx_commande ORDER BY rowid DESC LIMIT 1";
    // $result_sql_order = $conn->query($sql_order);
    // echo $result_sql_order ,"adasd<br>";

    $sql_insert_order =  "INSERT INTO llx_commande (fk_soc,ref)
    values($cliente_seleccionado,'xxx')";
    if ($conn->query($sql_insert_order) === TRUE) {
        echo "New record created successfully";
      } else {
        echo "Error: " . $sql_insert_order . "<br>" . $conn->error;
      }

    //INSERT LIST PRODUCT


      $conn->close();
?>