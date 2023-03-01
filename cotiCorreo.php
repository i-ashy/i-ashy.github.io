<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="icon" href="img/fantasma.png">
        <title>Envío de cotización</title>
    </head>
    <body style="background-image: url('img/back.jpg'); background-repeat: no-repeat; background-size:100%;">
        <div class="container">
            <header>
                
            </header>
            <div class="row">
                <div class="col-md-8 offset-md-2 py-5 d-flex flex-column justify-content-center align-items-center">
                    <div class="card py-3 bg-dark" style="width: 28rem;">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <form action="PDF.php" method="POST">
                                <h1 class="mb-4 text-center py-2 text-light">Funko Store</h1>
                                <h6 class="mb-2 text-center py-2 text-light">Recibirás un correo con tu cotización</h6>
                                <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre completo" 
                                style="width:22rem;" required>
                                <input type="text" name="correo" id="correo" pattern="[A-Za-z0-9._-]+@[A-Za-z0-9\.-]+\.[a-zA-Z]{2,4}" 
                                class="form-control mb-2" placeholder="Correo eléctronico" style="width:22rem;" required>
                                <button type="submit" name="enviar" class="btn btn-info text-dark mb-3" 
                                style="border-radius:20px; width:22rem;">Enviar cotización</button>
                                <hr class="mb-4 bg-light">
                            </form>
                            <!-- Colocar la página de los productos para volver --> 
                            <button type="button" name="volver" class="btn btn-secondary text-white mb-4" 
                                style="border-radius:20px; width:22rem;" onclick="location.href='index.html'">Volver</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>