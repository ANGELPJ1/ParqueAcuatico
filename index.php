<?php
// index.php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Parque Acuático</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Puedes agregar estilos adicionales aquí */
        .card-body {
            background-color: #fff;
        }
    </style>
</head>

<body>
    <!-- Menú superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">Parque Acuático</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuPrincipal"
            aria-controls="menuPrincipal" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php echo ($page == 'comprar') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php?page=comprar">Comprar</a>
                </li>
                <li class="nav-item <?php echo ($page == 'login') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php?page=login">Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if ($page == 'comprar'): ?>
            <!-- Sección para realizar una compra -->
            <h2>Adquirir entradas y servicios</h2>
            <form action="procesar_compra.php" method="POST">
                <div class="form-group">
                    <label for="codigo">Código Único:</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" required>
                </div>
                <!-- Ejemplo de campos para algunos productos -->
                <div class="form-group">
                    <label for="entradasAdulto">Entradas Adulto ($180 c/u):</label>
                    <input type="number" class="form-control" id="entradasAdulto" name="entradasAdulto" value="0" min="0">
                </div>
                <div class="form-group">
                    <label for="entradasNino">Entradas Niño ($120 c/u):</label>
                    <input type="number" class="form-control" id="entradasNino" name="entradasNino" value="0" min="0">
                </div>
                <div class="form-group">
                    <label for="sillas">Sillas ($30 c/u):</label>
                    <input type="number" class="form-control" id="sillas" name="sillas" value="0" min="0">
                </div>
                <div class="form-group">
                    <label for="mesas">Mesas ($50 c/u):</label>
                    <input type="number" class="form-control" id="mesas" name="mesas" value="0" min="0">
                </div>
                <div class="form-group">
                    <label for="sombrillas">Sombrillas ($50 c/u):</label>
                    <input type="number" class="form-control" id="sombrillas" name="sombrillas" value="0" min="0">
                </div>
                <button type="submit" class="btn btn-success">Comprar</button>
            </form>

        <?php elseif ($page == 'login'): ?>
            <!-- Sección para el login del administrador -->
            <h2>Administrador - Iniciar Sesión</h2>
            <form action="procesar_login.php" method="POST">
                <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            </form>

        <?php else: ?>
            <!-- Página principal -->
            <h1 class="text-center">Bienvenidos al Parque Acuático</h1>
            <p class="text-center">El parque acuático cuenta con:</p>

            <!-- Carrusel de imágenes -->
            <div id="carouselParque" class="carousel slide mb-4" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselParque" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselParque" data-slide-to="1"></li>
                    <li data-target="#carouselParque" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/alberca_infantil.jpg" class="d-block w-100" alt="Alberca infantil">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Alberca infantil</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/alberca_familiar.jpg" class="d-block w-100" alt="Alberca familiar">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Alberca familiar</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/alberca_olasy_toboganes.jpg" class="d-block w-100" alt="Alberca de olas y toboganes">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Alberca de olas y toboganes</h5>
                        </div>
                    </div>
                    <!-- Puedes agregar más carousel-item con imágenes de Lago natural, Cabañas, Camping, etc. -->
                </div>
                <a class="carousel-control-prev" href="#carouselParque" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#carouselParque" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Siguiente</span>
                </a>
            </div>

            <!-- Tarjetas con costos -->
            <h2 class="text-center">Costos</h2>
            <div class="row">
                <!-- Ejemplo de tarjeta: Espacio para casa de campaña por noche -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="img/casa_campania.jpg" class="card-img-top" alt="Casa de campaña">
                        <div class="card-body">
                            <p>Espacio para casa de campaña por noche: $350</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Renta de casa de campaña para 4 personas -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="img/casa_4.jpg" class="card-img-top" alt="Casa para 4 personas">
                        <div class="card-body">
                            <p>Renta de casa de campaña para 4 personas: $150</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Renta de casa de campaña para 8 personas -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="img/casa_8.jpg" class="card-img-top" alt="Casa para 8 personas">
                        <div class="card-body">
                            <p>Renta de casa de campaña para 8 personas: $180</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Renta de casa de campaña para 12 personas -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="img/casa_12.jpg" class="card-img-top" alt="Casa para 12 personas">
                        <div class="card-body">
                            <p>Renta de casa de campaña para 12 personas: $220</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Cabaña para 4 personas -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="img/cabana_4.jpg" class="card-img-top" alt="Cabaña para 4 personas">
                        <div class="card-body">
                            <p>Cabaña para 4 personas: $2500</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Cabaña para 6 personas -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="img/cabana_6.jpg" class="card-img-top" alt="Cabaña para 6 personas">
                        <div class="card-body">
                            <p>Cabaña para 6 personas: $3000</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Silla -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="img/silla.jpg" class="card-img-top" alt="Silla">
                        <div class="card-body">
                            <p>Silla: $30</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Mesa -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="img/mesa.jpg" class="card-img-top" alt="Mesa">
                        <div class="card-body">
                            <p>Mesa: $50</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Sombrilla -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="img/sombrilla.jpg" class="card-img-top" alt="Sombrilla">
                        <div class="card-body">
                            <p>Sombrilla: $50</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Entrada Adulto -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <img src="img/entrada_adulto.jpg" class="card-img-top" alt="Entrada Adulto">
                        <div class="card-body">
                            <p>Entrada al parque - Adulto: $180</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Entrada Niño -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <img src="img/entrada_nino.jpg" class="card-img-top" alt="Entrada Niño">
                        <div class="card-body">
                            <p>Entrada al parque - Niño: $120</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS, Popper.js y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>