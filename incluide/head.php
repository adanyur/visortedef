<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <title>Visor TEDEF AMB</title>
</head>
<body>
    <!---NAVEGADOR--->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">VISOR TEDEF AMB</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="../page/GenerarTedef.php">Generar TEDEF</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../page/FueraTrama.php">Fuera Trama</a>
                </li>
                <li class="nav-item">    
                    <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                Listado
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="../page/ListadosLotes.php">Lotes</a>
                                <a class="dropdown-item" href="../page/ListadosFtrama.php">Fuera de Trama</a>
                            </div>
                    </div>
                </li>
            </ul>
    <div class="btn-group">          
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user-alt"></i><?php echo $_SESSION['usuario'];?>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
        <form class="form-inline my-2 my-lg-0" id="cerrar-sesion">
        <button class="dropdown-item" type="submit">CERRAR SESSION</button>
        </form>
        </div>
    </div>
</nav>