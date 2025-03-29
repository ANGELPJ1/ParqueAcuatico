<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="Resources/logo.png" type="image/x-icon">
    <link rel="shortcut icon" href="Resources/logo.ico" type="image/x-icon">
    <title>Parque Acuático</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Agregar Bootstrap y dependencias -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Puedes agregar estilos adicionales aquí */
        .card-body {
            background-color: #fff;
        }

        .carousel-item img {
            height: 750px;
            /* Mantiene el mismo alto para todas las imágenes */
            width: 100%;
            /* Mantiene la proporción */
            object-fit: contain;
            /* Evita recortes */
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
            /* Ajusta el ancho de las flechas */
        }

        .carousel-control-prev {
            left: 8%;
            /* Mueve la flecha izquierda más al centro */
        }

        .carousel-control-next {
            right: 8%;
            /* Mueve la flecha derecha más al centro */
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 3rem;
            /* Ajusta el tamaño de las flechas */
            height: 3rem;
            filter: invert(100%);
        }


        .card-img-top {
            width: 100%;
            /* Asegura que ocupe todo el ancho de la tarjeta */
            height: 200px;
            /* Ajusta la altura deseada */
            object-fit: cover;
            /* Recorta la imagen sin distorsionarla */
            border-radius: 8px;
            /* Opcional: bordes redondeados para un mejor diseño */
        }

        h5 {
            display: flex;
            justify-content: center;
            /* Centrado horizontal */
            align-items: center;
            /* Centrado vertical */
            height: 50px;
            /* Ajusta según sea necesario */
            color: black;
        }

        p {
            display: flex;
            justify-content: center;
            /* Centrado horizontal */
            align-items: center;
            /* Centrado vertical */
            height: 50px;
            /* Ajusta según sea necesario */
            color: black;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            /* Centra verticalmente el texto y la imagen */
        }

        .brand-img {
            width: 40px;
            /* Tamaño de la imagen */
            height: 40px;
            /* Mantiene la imagen cuadrada */
            border-radius: 50%;
            /* Hace que la imagen sea circular */
            margin-left: 20px;
            margin-right: 20px;
            /* Espacio entre el texto y la imagen */
        }

        .card-img-top {
            width: 100%;
            /* Hace que la imagen ocupe todo el ancho del contenedor */
            height: 250px;
            /* Fija el alto para todas las imágenes */
            object-fit: cover;
            /* Asegura que la imagen cubra el área sin distorsionarse */
        }
    </style>
</head>

<body>
    <!-- Menú superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">
            <img src="Resources/logo.jpg" alt="Logo" class="brand-img" width="30px">
            Parque Acuático "Ocean Paradise"
        </a>

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
            <form id="formCompras" action="procesar_compra.php" method="POST">
                <div class="form-group">
                    <label for="codigo">Código Único:</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" readonly>
                </div>
                <!-- Selección de tipo de entradas (permitir seleccionar ambos) -->
                <div class="form-group">
                    <label for="tipoEntrada">Selecciona el tipo de entrada:</label><br>
                    <input type="checkbox" id="adulto" name="tipoEntrada[]" value="adulto" onclick="toggleFields()"> Entrada
                    Adulto ($180)<br>
                    <input type="checkbox" id="nino" name="tipoEntrada[]" value="nino" onclick="toggleFields()"> Entrada
                    Niño ($120)<br>
                </div>

                <!-- Campos que se activarán al seleccionar un tipo de entrada -->
                <div id="servicios" style="display:none;">
                    <!-- Campos para Entradas Adulto -->
                    <div id="adultoFields" style="display:none;">
                        <div class="form-group">
                            <label for="entradasAdulto">Entradas Adulto ($180 c/u):</label>
                            <input type="number" class="form-control" id="entradasAdulto" name="entradasAdulto" value="0"
                                min="0" onchange="calcularSubtotal()">
                            <input type="text" class="form-control" id="subtotalAdulto" readonly>
                        </div>
                    </div>

                    <!-- Campos para Entradas Niño -->
                    <div id="ninoFields" style="display:none;">
                        <div class="form-group">
                            <label for="entradasNino">Entradas Niño ($120 c/u):</label>
                            <input type="number" class="form-control" id="entradasNino" name="entradasNino" value="0"
                                min="0" onchange="calcularSubtotal()">
                            <input type="text" class="form-control" id="subtotalNino" readonly>
                        </div>
                    </div>

                    <!-- Productos disponibles -->
                    <div class="form-group">
                        <label for="sillas">Sillas ($30 c/u):</label>
                        <input type="number" class="form-control" id="sillas" name="sillas" value="0" min="0"
                            onchange="calcularSubtotal()">
                        <input type="text" class="form-control" id="subtotalSillas" readonly>
                    </div>
                    <div class="form-group">
                        <label for="mesas">Mesas ($50 c/u):</label>
                        <input type="number" class="form-control" id="mesas" name="mesas" value="0" min="0"
                            onchange="calcularSubtotal()">
                        <input type="text" class="form-control" id="subtotalMesas" readonly>
                    </div>
                    <div class="form-group">
                        <label for="sombrillas">Sombrillas ($50 c/u):</label>
                        <input type="number" class="form-control" id="sombrillas" name="sombrillas" value="0" min="0"
                            onchange="calcularSubtotal()">
                        <input type="text" class="form-control" id="subtotalSombrillas" readonly>
                    </div>
                    <div class="form-group">
                        <label for="casaCampanaEspacio">Espacio para casa de campaña por noche ($350):</label>
                        <input type="number" class="form-control" id="casaCampanaEspacio" name="casaCampanaEspacio"
                            value="0" min="0" onchange="calcularSubtotal()">
                        <input type="text" class="form-control" id="subtotalCasaCampanaEspacio" readonly>
                    </div>
                    <div class="form-group">
                        <label for="casaCampana4">Renta de casa de campaña para 4 personas ($150):</label>
                        <input type="number" class="form-control" id="casaCampana4" name="casaCampana4" value="0" min="0"
                            onchange="calcularSubtotal()">
                        <input type="text" class="form-control" id="subtotalCasaCampana4" readonly>
                    </div>
                    <div class="form-group">
                        <label for="casaCampana8">Renta de casa de campaña para 8 personas ($180):</label>
                        <input type="number" class="form-control" id="casaCampana8" name="casaCampana8" value="0" min="0"
                            onchange="calcularSubtotal()">
                        <input type="text" class="form-control" id="subtotalCasaCampana8" readonly>
                    </div>
                    <div class="form-group">
                        <label for="casaCampana12">Renta de casa de campaña para 12 personas ($220):</label>
                        <input type="number" class="form-control" id="casaCampana12" name="casaCampana12" value="0" min="0"
                            onchange="calcularSubtotal()">
                        <input type="text" class="form-control" id="subtotalCasaCampana12" readonly>
                    </div>
                    <div class="form-group">
                        <label for="cabaña4">Cabaña para 4 personas ($2500):</label>
                        <input type="number" class="form-control" id="cabaña4" name="cabaña4" value="0" min="0"
                            onchange="calcularSubtotal()">
                        <input type="text" class="form-control" id="subtotalCabaña4" readonly>
                    </div>
                    <div class="form-group">
                        <label for="cabaña6">Cabaña para 6 personas ($3000):</label>
                        <input type="number" class="form-control" id="cabaña6" name="cabaña6" value="0" min="0"
                            onchange="calcularSubtotal()">
                        <input type="text" class="form-control" id="subtotalCabaña6" readonly>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Comprar</button>
            </form>

        <?php elseif ($page == 'login'): ?>
            <!-- Sección para el login del administrador -->
            <h2>Administrador - Iniciar Sesión</h2>
            <form id="Logueo" action="procesar_login.php" method="POST">
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
            <h1 class="text-center">Bienvenidos al Parque Acuático "Ocean Paradise"</h1>

            <!-- Carrusel de imágenes -->
            <div id="carouselParque" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="4000">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselParque" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carouselParque" data-bs-slide-to="1"></li>
                    <li data-bs-target="#carouselParque" data-bs-slide-to="2"></li>
                    <li data-bs-target="#carouselParque" data-bs-slide-to="3"></li>
                    <li data-bs-target="#carouselParque" data-bs-slide-to="4"></li>
                    <li data-bs-target="#carouselParque" data-bs-slide-to="5"></li>
                    <li data-bs-target="#carouselParque" data-bs-slide-to="6"></li>
                    <li data-bs-target="#carouselParque" data-bs-slide-to="7"></li>
                    <li data-bs-target="#carouselParque" data-bs-slide-to="8"></li>
                    <li data-bs-target="#carouselParque" data-bs-slide-to="9"></li>
                    <li data-bs-target="#carouselParque" data-bs-slide-to="10"></li>
                    <li data-bs-target="#carouselParque" data-bs-slide-to="11"></li>
                    <li data-bs-target="#carouselParque" data-bs-slide-to="12"></li>
                    <li data-bs-target="#carouselParque" data-bs-slide-to="13"></li>
                </ol>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="Resources/AlbercaInfantil.jpg" class="mx-auto d-block" alt="Alberca infantil">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Alberca infantil</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="Resources/AlbercaFamiliar.jpg" class="mx-auto d-block" alt="Alberca familiar">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Alberca familiar</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="Resources/AlbercaOlasToboganes.jpg" class="mx-auto d-block"
                            alt="Alberca de olas y toboganes">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Alberca de olas y toboganes</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="Resources/LagoNatural.jpg" class="mx-auto d-block" alt="Lago natural">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Lago natural</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="Resources/CabañaPequeña.jpg" class="mx-auto d-block" alt="Cabañas para 4 personas">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Cabañas para 4 personas</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="Resources/CabañaGrande.jpg" class="mx-auto d-block" alt="Cabañas para 6 personas">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Cabañas para 6 personas</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="Resources/Camping.jpg" class="mx-auto d-block" alt="Áreas de camping">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Áreas de camping</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="Resources/Estacionamiento.jpg" class="mx-auto d-block" alt="Estacionamiento">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Estacionamiento</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="Resources/ServicioMedico.jpg" class="mx-auto d-block" alt="Servicio médico">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Servicio médico</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="Resources/Regaderas.jpg" class="mx-auto d-block" alt="Regaderas">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Regaderas</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="Resources/Seguridad.jpg" class="mx-auto d-block" alt="Seguridad las 24 Hrs">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Seguridad las 24 Hrs</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="Resources/Asadores.jpg" class="mx-auto d-block" alt="Asadores">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Asadores</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="Resources/AreaVerde.jpg" class="mx-auto d-block" alt="Áreas verdes">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Áreas verdes</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="Resources/RentaCasas.jpg" class="mx-auto d-block" alt="Renta de casas de campaña">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Renta de casas de campaña</h5>
                        </div>
                    </div>
                </div>

                <a class="carousel-control-prev" href="#carouselParque" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#carouselParque" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </a>
            </div>


            <!-- Tarjetas con costos -->
            <br><br><br><br><br><br>
            <h2 class="text-center">El parque acuático cuenta con:</h2>
            <br><br>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="Resources/Div-uno.jpg" class="card-img-top imf-fluid" alt="Casa de campaña">
                        <div class="card-body">
                            <p>Espacio para casa de campaña por noche: $350</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Renta de casa de campaña para 4 personas -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="Resources/Div-dos.jpg" class="card-img-top" alt="Casa para 4 personas">
                        <div class="card-body">
                            <p>Renta de casa de campaña para 4 personas: $150</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Renta de casa de campaña para 8 personas -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="Resources/Div-tres.jpg" class="card-img-top" alt="Casa para 8 personas">
                        <div class="card-body">
                            <p>Renta de casa de campaña para 8 personas: $180</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Renta de casa de campaña para 12 personas -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="Resources/Div-cuatro.jpg" class="card-img-top" alt="Casa para 12 personas">
                        <div class="card-body">
                            <p>Renta de casa de campaña para 12 personas: $220</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Cabaña para 4 personas -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="Resources/Div-cinco.jpg" class="card-img-top" alt="Cabaña para 4 personas">
                        <div class="card-body">
                            <p>Cabaña para 4 personas: $2500</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Cabaña para 6 personas -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="Resources/Div-seis.jpg" class="card-img-top" alt="Cabaña para 6 personas">
                        <div class="card-body">
                            <p>Cabaña para 6 personas: $3000</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Silla -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="Resources/Div-siete.jpg" class="card-img-top" alt="Silla">
                        <div class="card-body">
                            <p>Silla: $30</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Mesa -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="Resources/Div-ocho.jpg" class="card-img-top" alt="Mesa">
                        <div class="card-body">
                            <p>Mesa: $50</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Sombrilla -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="Resources/Div-nueve.jpg" class="card-img-top" alt="Sombrilla">
                        <div class="card-body">
                            <p>Sombrilla: $50</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Entrada Adulto -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <img src="Resources/Div-diez.jpg" class="card-img-top" alt="Entrada Adulto">
                        <div class="card-body">
                            <p>Entrada al parque - Adulto: $180</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta para Entrada Niño -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <img src="Resources/Div-once.jpg" class="card-img-top" alt="Entrada Niño">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Gestion de alertas al comprar un servicio -->
    <script>
        document.getElementById("formCompras").addEventListener("submit", function (event) {
            event.preventDefault(); // Evita que la página se recargue

            let formData = new FormData(this);

            fetch("procesar_compra.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.text()) // <-- Muestra el texto crudo
                .then(text => {
                    console.log("Respuesta del servidor:", text); // <-- Verifica que sea JSON válido
                    return JSON.parse(text);
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: "¡Compra Exitosa!",
                            text: data.message,
                            icon: "success",
                            confirmButtonText: "Ver Ticket"
                        }).then(() => {
                            if (data.pdf_url) {
                                window.open(data.pdf_url, "_blank"); // 🔹 Abre el ticket en una nueva pestaña
                            } else {
                                window.location.href = "index.php";
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: data.message,
                            icon: "error",
                            confirmButtonText: "Intentar de nuevo"
                        });
                    }
                })
                .catch(error => {
                    console.error("Error en la solicitud:", error);
                    Swal.fire({
                        title: "Error",
                        text: "Hubo un problema con la compra. Inténtalo de nuevo.",
                        icon: "error",
                        confirmButtonText: "Intentar de nuevo"
                    });
                });
        });
    </script>

    <!-- Gestion para inicio de sesion  -->
    <script>
        document.querySelector("#Logueo").addEventListener("submit", function (event) {
            event.preventDefault(); // Evitar el envío tradicional

            let formData = new FormData(this);

            fetch("Views/procesar_login.php", { // Ruta correcta para el archivo PHP
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: "¡Bienvenido!",
                            text: data.message,
                            icon: "success",
                            confirmButtonText: "Aceptar"
                        }).then(() => {
                            window.location.href = "/Parqueacuatico/Views/admin_dashboard.php";

                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: data.message,
                            icon: "error",
                            confirmButtonText: "Intentar de nuevo"
                        });
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    </script>

    <!-- Logica para calculo de subtotal -->
    <script>
        // Función para generar código único aleatorio
        function generarCodigo() {
            var caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var codigo = '';
            for (var i = 0; i < 6; i++) {
                codigo += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
            }
            document.getElementById('codigo').value = codigo;
        }

        // Función para activar campos de cantidad de productos
        function toggleFields() {
            var adulto = document.getElementById('adulto').checked;
            var nino = document.getElementById('nino').checked;

            // Mostrar/ocultar campos según las opciones seleccionadas
            if (adulto || nino) {
                document.getElementById('servicios').style.display = 'block';
            } else {
                document.getElementById('servicios').style.display = 'none';
            }

            // Activar campos para Entradas Adulto
            if (adulto) {
                document.getElementById('adultoFields').style.display = 'block';
            } else {
                document.getElementById('adultoFields').style.display = 'none';
            }

            // Activar campos para Entradas Niño
            if (nino) {
                document.getElementById('ninoFields').style.display = 'block';
            } else {
                document.getElementById('ninoFields').style.display = 'none';
            }
        }

        // Función para calcular el subtotal
        function calcularSubtotal() {
            var precioAdulto = 180;
            var precioNino = 120;
            var precioSilla = 30;
            var precioMesa = 50;
            var precioSombrilla = 50;
            var precioCasaCampanaEspacio = 350;
            var precioCasaCampana4 = 150;
            var precioCasaCampana8 = 180;
            var precioCasaCampana12 = 220;
            var precioCabaña4 = 2500;
            var precioCabaña6 = 3000;

            // Calcular subtotales
            var subtotalAdulto = document.getElementById('entradasAdulto').value * precioAdulto;
            var subtotalNino = document.getElementById('entradasNino').value * precioNino;
            var subtotalSillas = document.getElementById('sillas').value * precioSilla;
            var subtotalMesas = document.getElementById('mesas').value * precioMesa;
            var subtotalSombrillas = document.getElementById('sombrillas').value * precioSombrilla;
            var subtotalCasaCampanaEspacio = document.getElementById('casaCampanaEspacio').value * precioCasaCampanaEspacio;
            var subtotalCasaCampana4 = document.getElementById('casaCampana4').value * precioCasaCampana4;
            var subtotalCasaCampana8 = document.getElementById('casaCampana8').value * precioCasaCampana8;
            var subtotalCasaCampana12 = document.getElementById('casaCampana12').value * precioCasaCampana12;
            var subtotalCabaña4 = document.getElementById('cabaña4').value * precioCabaña4;
            var subtotalCabaña6 = document.getElementById('cabaña6').value * precioCabaña6;

            // Asignar subtotales a los campos de texto
            document.getElementById('subtotalAdulto').value = subtotalAdulto ? '$' + subtotalAdulto : '$0';
            document.getElementById('subtotalNino').value = subtotalNino ? '$' + subtotalNino : '$0';
            document.getElementById('subtotalSillas').value = subtotalSillas ? '$' + subtotalSillas : '$0';
            document.getElementById('subtotalMesas').value = subtotalMesas ? '$' + subtotalMesas : '$0';
            document.getElementById('subtotalSombrillas').value = subtotalSombrillas ? '$' + subtotalSombrillas : '$0';
            document.getElementById('subtotalCasaCampanaEspacio').value = subtotalCasaCampanaEspacio ? '$' + subtotalCasaCampanaEspacio : '$0';
            document.getElementById('subtotalCasaCampana4').value = subtotalCasaCampana4 ? '$' + subtotalCasaCampana4 : '$0';
            document.getElementById('subtotalCasaCampana8').value = subtotalCasaCampana8 ? '$' + subtotalCasaCampana8 : '$0';
            document.getElementById('subtotalCasaCampana12').value = subtotalCasaCampana12 ? '$' + subtotalCasaCampana12 : '$0';
            document.getElementById('subtotalCabaña4').value = subtotalCabaña4 ? '$' + subtotalCabaña4 : '$0';
            document.getElementById('subtotalCabaña6').value = subtotalCabaña6 ? '$' + subtotalCabaña6 : '$0';
        }

        // Generar el código único al cargar la página
        window.onload = generarCodigo;
    </script>
</body>

</html>