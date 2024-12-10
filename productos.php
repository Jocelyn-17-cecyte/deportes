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
        #carrito-container {
            position: fixed;
            top: 20%;
            right: 20px;
            width: 300px;
            max-height: 60vh;
            overflow-y: auto;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        #carrito-container h5 {
            font-size: 18px;
            margin-bottom: 10px;
            text-align: center;
        }

        #carrito-container .list-group {
            margin-bottom: 15px;
        }

        #carrito-container .btn-finalizar {
            display: block;
            width: 100%;
        }

        .social-icons a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
        }

        .social-icons a:hover {
            color: #ccc;
        }
    </style>
</head>
<body>
    <?php
        // Incluir la conexión
        include 'conexion.php';
        $sql = "SELECT id, nombre, precio, url_img FROM productos";
        $result = $conn->query($sql);
    ?>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-brand mb-0 h1">Deportenis</span>
    </nav>

    <!-- Banner -->
    <div class="banner"></div>

    <!-- Body -->
    <main class="container mt-5">
        <h2 class="text-center mb-4">Productos Disponibles</h2>

        <!-- Fila de productos -->
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '  <div class="card">';
                    echo '    <img src="' . BASE_URL . '/' . $row['url_img'] . '" class="card-img-top" alt="Imagen de ' . $row['nombre'] . '">';
                    echo '    <div class="card-body">';
                    echo '      <h5 class="card-title">' . $row['nombre'] . '</h5>';
                    echo '      <p class="card-text">$' . number_format($row['precio'], 2) . '</p>';
                    echo '      <button class="btn btn-primary agregar-carrito-btn" data-id="' . $row['id'] . '" data-nombre="' . $row['nombre'] . '" data-precio="' . $row['precio'] . '"><i class="fas fa-cart-plus"></i> Agregar al carrito</button>';
                    echo '    </div>';
                    echo '  </div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No hay productos disponibles.</p>';
            }
            ?>
        </div>
    </main>

    <!-- Carrito -->
    <div id="carrito-container">
        <h5>Carrito</h5>
        <ul id="carrito-list" class="list-group">
            <!-- Los productos se agregarán aquí dinámicamente -->
        </ul>
        <p><strong>Total: $<span id="total">0.00</span></strong></p>
        <form id="compra-form" action="comprar.php" method="POST">
            <input type="hidden" id="productos" name="productos" value="[]">
            <button type="submit" class="btn btn-primary btn-finalizar">Finalizar compra</button>
        </form>
    </div>

    <!-- Footer -->
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
    <script>
        const carrito = [];

        function actualizarCarrito() {
            const carritoElement = document.getElementById('carrito-list');
            const totalElement = document.getElementById('total');
            carritoElement.innerHTML = ''; // Limpiar carrito

            let total = 0;
            const productos = [];

            carrito.forEach(producto => {
                const item = document.createElement('li');
                item.classList.add('list-group-item');
                item.innerHTML = `${producto.nombre} - $${producto.precio.toFixed(2)} x ${producto.cantidad}`;
                carritoElement.appendChild(item);
                total += producto.precio * producto.cantidad;
                productos.push(producto);
            });

            totalElement.textContent = total.toFixed(2);
            document.getElementById('productos').value = JSON.stringify(productos);
        }

        document.querySelectorAll('.agregar-carrito-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const nombre = this.getAttribute('data-nombre');
                const precio = parseFloat(this.getAttribute('data-precio'));

                const productoIndex = carrito.findIndex(p => p.id === id);
                if (productoIndex === -1) {
                    carrito.push({ id, nombre, precio, cantidad: 1 });
                } else {
                    carrito[productoIndex].cantidad += 1;
                }

                actualizarCarrito();
            });
        });
    </script>
</body>
</html>
