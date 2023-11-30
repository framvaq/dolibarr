<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MPC</title>
  </head>
  <body>
    <!-- <form action=""><select name="" id=""></select></form> -->
    <?php
        echo "works";
        $conn_Customers = new mysql("dolibarr","dolibarrmysql","changeme","") or die("Error: Conection Customers");

        echo "works conection customer";

        $conn_Customers ->close();
        $conn = new mysql("dolibarr","dolibarrmysql","changeme","llx_product") or die("Error: Conection Product");

        $data = $conn->query("SELECT rowid,label,price from llx_product");

        if($data->num_rows>0)
        {
            echo "<table>";
            echo "<tr>";
            echo "<td>Id</td>";
            echo "<td>Product</td>";
            echo "<td>Price</td>";
            echo "</tr>";
            while($rows = $data->fetch_assos())
            {
                echo "<tr>";
                echo "<td>".$rows["rowid"]."<td>";
                echo "<td>".$rows["label"]."<td>";
                echo "<td>".$rows["price"]."<td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else
        {
            echo "table empty";
        }

        $conn->close();
    ?>
  </body>
</html>
