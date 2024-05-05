<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Join&Eat Room 
  <?php
  
  if(isset($_POST['room_code'])) {
    echo $_POST['room_code']; 
  } 
  ?>
  </title>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="cover.css">
  <link href='https://fonts.googleapis.com/css?family=Space Grotesk' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet'>
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
    .form-inline {
      margin-top: 20px;
    }
    .form-inline label {
      margin-right: 10px;
    }
    .form-inline input[type="number"],
    .form-inline input[type="text"],
    .form-inline button {
      margin-right: 10px;
    }
    .form-inline input[type="number"],
    .form-inline input[type="text"] {
      width: 150px;
    }
    .form-inline button {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
    }
    
  </style>
</head>
<body>

<div class="header">
  <h1>Room
  <?php
      
      if(isset($_POST['room_code'])) {
        echo $_POST['room_code']; 
      } else {
        echo "Error RN4.";
      }
      ?>
    </span>
    <span style=" font-family: 'Space Grotesk'; color: black; font-size: 40%;">
        <?php
        
        if(isset($_POST['username'])) {
            echo "Username: " . $_POST['username']; 
        } else {
            echo "Err UN4.";
        }
        ?>
    </span>
  </h1>
</div>

<div class="container">
  <table id="platos-table" class='platos-table'>
    <!-- Esta tabla se actualizará dinámicamente con los datos de la base de datos -->
  </table>
</div>

<div class="fpedidos" id="footer">
  <form class="form-inline" action="./procesar_pedido.php" method="POST">
    <input type="hidden" name="room_code" value="<?php echo isset($_POST['room_code']) ? $_POST['room_code'] : ''; ?>">
    <input type="hidden" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
    <label for="num">Item Number</label>
    <input type="text" id="Nº" placeholder="A01" name="numero_plato" required maxlength="10">
    <label for="fn">Information</label>
    <input type="text" id="fn" placeholder="" name="nombre_plato" maxlength="50">
    <label for="qn">Quantity</label>
    <input type="number" id="qn" placeholder="000" name="cantidad" required max="250" min="1">
    <button type="submit" name="submit">Add</button>
  </form>
  <form class="form-inline" action="summary.php" method="GET">
    <input type="hidden" name="room_code" value="<?php echo isset($_POST['room_code']) ? $_POST['room_code'] : ''; ?>">
    <button type="submit" >Summary</button>
  </form>
</div>

<script>
  // Función para cargar la tabla de pedidos mediante AJAX
  function loadPedidos() {
    // Realizar una solicitud AJAX al servidor
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // Actualizar el contenido de la tabla con la respuesta del servidor
        document.getElementById("platos-table").innerHTML = this.responseText;
      }
    };
    xhr.open("GET", "list.php?room_code=<?php echo isset($_POST['room_code']) ? $_POST['room_code'] : ''; ?>", true);
    xhr.send();
  }

  // Actualizar la tabla de pedidos cada 5 segundos
  setInterval(function(){
    loadPedidos();
  }, 2000);

  // Cargar la tabla de pedidos al cargar la página
  window.onload = function() {
    loadPedidos();
  };
</script>

</body>
</html>
