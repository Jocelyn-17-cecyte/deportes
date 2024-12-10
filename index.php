<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deportenis</title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="css/all.min.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            flex-direction: column;
            height: 100vh; /* Altura completa de la ventana */
            margin: 0;
        }

        /* Contenedor principal */
        .main-container {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        /* Menú lateral */
        .sidebar {
            width: 200px;
            background-color: #f8f9fa;
            border-right: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            padding: 15px;
        }

        .sidebar button {
            width: 100%;
            margin-bottom: 10px;
            text-align: left;
        }

        /* Contenido principal */
        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        /* Footer */
        footer {
            flex-shrink: 0; /* Evita que el footer se mueva */
        }
    </style>
</head>
<body>
    <?php
        // Incluir la conexión
        include 'conexion.php';
    ?>

    <!-- Barra de navegación fija -->
    <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-brand mb-0 h1">Deportenis</span>
    </nav>

    <!-- Contenedor principal -->
    <div class="main-container">
        <!-- Menú lateral fijo -->
        <div class="sidebar">
            <button class="btn btn-outline-primary" onclick="location.href='index.php'">
                <i class="fas fa-home"></i> Inicio
            </button>
            <button class="btn btn-outline-primary" onclick="window.open('productos.php', '_blank')">
                <i class="fas fa-store"></i> Ver mi tienda
            </button>
            <button class="btn btn-outline-primary" onclick="location.href='crear.php'">
                <i class="fas fa-box"></i> Nuevo producto
            </button>
            <button class="btn btn-outline-primary" onclick="location.href='reporte.php'">
                <i class="fas fa-chart-line"></i> Mis ventas
            </button>
        </div>

        <!-- Contenido principal -->
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Imagen</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Consulta a la base de datos
                            $sql = "SELECT id, nombre, precio, url_img FROM productos";
                            $result = $conn->query($sql);

                            // Verificar si hay resultados
                            if ($result->num_rows > 0) {
                                // Iterar sobre los resultados
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<th scope='row'>{$row['id']}</th>";
                                    echo "<td>{$row['nombre']}</td>";
                                    echo "<td>$" . number_format($row['precio'], 2) . "</td>";
                                    echo "<td><img src='" . BASE_URL . "/{$row['url_img']}' alt='Imagen de {$row['nombre']}' class='img-thumbnail' width='50'></td>";
                                    echo "<td>
                                            <!-- Formulario para el botón Editar -->
                                            <form action='editar.php' method='POST' style='display:inline-block;'>
                                                <input type='hidden' name='id' value='{$row['id']}'>
                                                <button type='submit' class='btn btn-sm btn-warning'>
                                                    <i class='fas fa-edit'></i> Editar
                                                </button>
                                            </form>
                                            
                                            <!-- Formulario para el botón Eliminar -->
                                            <form action='eliminar.php' method='POST' style='display:inline-block;' onsubmit='return confirmarBorrado();'>
                                                <input type='hidden' name='id' value='{$row['id']}'>
                                                <button type='submit' class='btn btn-sm btn-danger'>
                                                    <i class='fas fa-trash'></i> Eliminar
                                                </button>
                                            </form>
                                        </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>No hay productos disponibles</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer fijo -->
    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            <p>&copy; 2024 Deportenis. Todos los derechos reservados.</p>
            <div class="social-icons">
                <a href="https://www.facebook.com" target="_blank" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                <a href="https://www.x.com" target="_blank" aria-label="X (Twitter)"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://www.youtube.com" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </footer>

    <!-- jQuery, Bootstrap JS -->
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
