<?php
ob_start(); //Con esto se guarda todo el HTML generado
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>PDF</title>
    
</head>
<body>
<!-- Aqui tiene que generar la cotización con los productos del carrito con informacion que se selecciono -->
<h1>Detalles de productos</h1>
<h4>Resumen: </h4>
<table class="table table-dark" border="2">
  <thead>
    <tr>
      <th scope="col">Nombre: </th>
      <th scope="col">Precio: </th>
    </tr>
  </thead>
  <tbody class="table-group-divider">
        <?php
           if(isset($_SESSION["carrito"])){
            $idProd = 0;
            $precio = 0;
        foreach($_SESSION["carrito"] as $index => $array){
            foreach($array as $llave => $value){
                if($llave == "nombre"){
                    echo "<tr>";
                }
                $idProd++;
                echo "<td>" . $value ."</td>";
                /*echo $llave . ": ". $value."<br>";*/
                if($llave == "precio"){
                    echo "</tr>";
                }
                if($llave == 'precio') {
                    $precio += substr($value,1);
                }
            }   
            
        }
        ?>
  </tbody>
</table>

        <h4>Total: $<?= number_format ( $precio, 2); ?></h4>
        <?php }
        ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

</body>
</html>

<?php

    //Libreria para creación de PDF
    $html=ob_get_clean(); //esa es la variable en la que se guarda el html

    require_once '../Trabajo1/Libreria/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;

    //Libreria de envio de email
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'email/src/PHPMailer.php';
    require 'email/src/SMTP.php';
    require 'email/src/Exception.php';

    if(isset($_POST['enviar']))
    {
        if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9\.-]+\.[a-zA-Z]{2,4}$/', $_POST['correo']))
        {
            exit();
        }
        else
        {
            //Creación de documento
            $dompdf = new Dompdf();

            $rutaGuardado='../Trabajo1/cotizaciones/'; //ruta de guardado

            $dompdf -> loadHtml($html);
            $dompdf->setPaper('letter','portrait');
            $dompdf->render();

            $varNumerica = 0;
            $nombreDocu="Archivo$varNumerica.pdf"; //Nombre del Archivo pdf
            $varVerificacion=$rutaGuardado."/".$nombreDocu;

            while (file_exists($varVerificacion)==true)
            {
                $varNumerica++;
                $nombreDocu="Archivo$varNumerica.pdf"; //Nombre del Archivo pdf
                $varVerificacion=$rutaGuardado."/".$nombreDocu;
            }


            $output = $dompdf->output();

            file_put_contents($rutaGuardado.$nombreDocu,$output);

            //Ya con el pdf, se empieza proceso de envío
            $mail = new PHPMailer(true);

            try {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ventas.envio2023@gmail.com';
                $mail->Password = 'lqkqzogqvlitwwbi';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('ventas.envio2023@gmail.com', 'Funko Store');
                $mail->addAddress($_POST['correo']);

                $mail->addAttachment("cotizaciones/Archivo$varNumerica.pdf", "Tu cotización.pdf");

                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $nombre = $_POST['nombre'];
                $mail->Subject = 'Cotización';
                $mail->Body = 'Buen día, '.$nombre.'. <br/>En el siguiente archivo se encuentra la cotización de su carrito de compra. <br><br>Los servicios de <b>Funko Store</b> están disponibles las 24 horas del día.';
                $mail->send();

                echo "<script>
                alert('Correo enviado éxitosamente.')
                document.location.href='index.html';
                </script>";
                session_destroy();
                //echo "<div class='alert alert-success'>Correo enviado éxitosamente.</div>";

            } catch (Exception $e) {
                echo "<script> alert('Error: " . $mail->ErrorInfo . "')";
                echo "document.location.href='cotiCorreo.php'; </script>";
                //echo "<div class='alert alert-danger'>Error: " . $mail->ErrorInfo . "</div>";
            }
                                                        
        }
    }
?>