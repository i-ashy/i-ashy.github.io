<?php
session_start();

    if(isset($_POST["agregar"])){
        $productoNombre = $_POST["nombreProducto"];
        $productoPrecio =$_POST["precioProducto"];
      
        $_SESSION["carrito"][$productoNombre]["nombre"] = $productoNombre;
        $_SESSION["carrito"][$productoPrecio]["precio"] = $productoPrecio;

       echo "<script>alert('Producto agregado al carrito')</script>";
      
     }
header("Location: " . $_SERVER['HTTP_REFERER']."");

    ?>