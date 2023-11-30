<?php
// Datos de conexión a la base de datos de Dolibarr
$host = 'localhost';
$usuario = 'dolibarrmysql';
$contrasena = 'changeme';
$base_de_datos = 'dolibarr';

// Configuración de la conexión a la API de Dolibarr
$dolibarr_api_url = 'http://localhost/dolibarr/htdocs/api/index.php';
$dolibarr_api_key = 'tu_clave_api';

// Conexión a la base de datos
$conexion = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener la lista de clientes desde la base de datos de Dolibarr
$consulta_clientes = "SELECT rowid, nom FROM llx_societe";
$resultado_clientes = $conexion->query($consulta_clientes);

// Mostrar la lista de clientes en un formulario
echo "<form method='post' action='procesar_pedido.php'>";
echo "<label for='cliente'>Selecciona un cliente:</label>";
echo "<select name='cliente'>";
while ($row = $resultado_clientes->fetch_assoc()) {
    echo "<option value='".$row['rowid']."'>".$row['nom']."</option>";
}
echo "</select>";

// Consulta para obtener la lista de productos desde la base de datos de Dolibarr
$consulta_productos = "SELECT ref, label FROM llx_product";
$resultado_productos = $conexion->query($consulta_productos);

// Mostrar la lista de productos en un formulario
echo "<br><br><label>Selecciona productos:</label><br>";
while ($row = $resultado_productos->fetch_assoc()) {
    echo "<input type='checkbox' name='productos[]' value='".$row['ref']."'>".$row['label']."<br>";
}

// Procesar el formulario cuando se presiona el botón de "Pagar"
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

    // Crear el pedido utilizando la API de Dolibarr
    $ch = curl_init($dolibarr_api_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos_pedido));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'DOLAPIKEY: ' . $dolibarr_api_key
    ));

    $resultado = curl_exec($ch);
    curl_close($ch);

    // Verificar el resultado
    if ($resultado === false) {
        echo "Error al conectar con la API de Dolibarr.";
    } else {
        $respuesta = json_decode($resultado, true);
        
        if (isset($respuesta['error'])) {
            echo "Error al crear el pedido en Dolibarr: " . $respuesta['error']['message'];
        } else {
            echo "Pedido creado con éxito. ID del pedido: " . $respuesta['result']['id'];
        }
    }

    echo "Pedido creado con éxito.";
}

?>