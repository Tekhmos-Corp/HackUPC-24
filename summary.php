<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Summary</title>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <style>
    .platos-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    .platos-table th, .platos-table td {
      border: 1px solid #dee2e6;
      padding: 8px;
    }
    .platos-table th {
      background-color: #007bff;
      color: white;
    }
  </style>
</head>
<body>
<div class="container">
  <h1 class="text-center">Summary</h1>
  <?php
  $servername = "localhost";
  $username = "tekhmos";
  $password = "Tekhmos12";
  $dbname = "BadDays";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Cant connect to DBMS: " . $conn->connect_error);
  }

  $room_code = $_GET['room_code'];

  $sql = "SELECT pl.numero_plato, SUM(p.cantidad_pedido) AS cantidad_total
          FROM platos pl
          INNER JOIN pedidos p ON pl.plato_id = p.plato_id
          WHERE pl.room_code = '$room_code'
          GROUP BY pl.numero_plato";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "<table class='platos-table'>";
    echo "<tr><th>Item Number</th><th>Total Quantity</th></tr>";
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>".$row["numero_plato"]."</td>";
      echo "<td>".$row["cantidad_total"]."</td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "<p>No orders found yet.</p>";
  }

  
  $conn->close();
  ?>
</div>
</body>
</html>
