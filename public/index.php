<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producto</title>
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="./css/tailwind.css">
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-center text-blue-600">Registrar Producto</h1>
    <form id="formulario" action="" method="POST" class="w-full">
        <div class="mb-5">
            <label for="nombre" class="block text-gray-700 font-semibold mb-2">Nombre del Producto:</label>
            <input type="text" id="nombre" name="nombre" class="block w-full border border-gray-300 rounded-lg py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            <p id="errorNombre" class="text-red-500 text-sm mt-2"></p>
        </div>
        <div class="mb-5">
            <label for="precio" class="block text-gray-700 font-semibold mb-2">Precio por Unidad:</label>
            <input type="number" id="precio" name="precio" step="0.01" class="block w-full border border-gray-300 rounded-lg py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            <p id="errorPrecio" class="text-red-500 text-sm mt-2"></p>
        </div>
        <div class="mb-5">
            <label for="cantidad" class="block text-gray-700 font-semibold mb-2">Cantidad en Inventario:</label>
            <input type="number" id="cantidad" name="cantidad" class="block w-full border border-gray-300 rounded-lg py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            <p id="errorCantidad" class="text-red-500 text-sm mt-2"></p>
        </div>
        <div class="flex items-center justify-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Registrar</button>
        </div>
    </form>
</div>

<?php
session_start();

// Función para guardar los datos del formulario en un array asociativo
function guardarProducto($nombre, $precio, $cantidad) {
    return [
        "Nombre" => $nombre,
        "Precio" => $precio,
        "Cantidad" => $cantidad,
        "Valor Total" => $precio * $cantidad,
        "Estado" => $cantidad == 0 ? "Agotado" : "En stock"
    ];
}

// Inicializar el array de productos si no existe
if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = [];
}

// Validar y guardar los datos del formulario
$errores = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nombre"])) {
        $errores["nombre"] = "El nombre es requerido.";
    }
    if (empty($_POST["precio"]) || !is_numeric($_POST["precio"]) || $_POST["precio"] <= 0) {
        $errores["precio"] = "El precio debe ser un número positivo.";
    }
    if (empty($_POST["cantidad"]) || !is_numeric($_POST["cantidad"]) || $_POST["cantidad"] < 0) {
        $errores["cantidad"] = "La cantidad debe ser un número no negativo.";
    }

    if (empty($errores)) {
        // Agregar el nuevo producto al array de productos
        $_SESSION['productos'][] = guardarProducto($_POST["nombre"], $_POST["precio"], $_POST["cantidad"]);
    } else {
        echo "<script>
            document.getElementById('errorNombre').innerText = '".(isset($errores['nombre']) ? $errores['nombre'] : "")."';
            document.getElementById('errorPrecio').innerText = '".(isset($errores['precio']) ? $errores['precio'] : "")."';
            document.getElementById('errorCantidad').innerText = '".(isset($errores['cantidad']) ? $errores['cantidad'] : "")."';
        </script>";
    }
}

// Función para mostrar una tabla de productos
function mostrarTablaProductos($productos) {
    echo "<table class='w-full bg-white border border-gray-200 mt-6'>";
    echo "<thead>";
    echo "<tr class='bg-gray-200 text-gray-700 text-sm'>";
    echo "<th class='py-2 px-2'>Nombre</th>";
    echo "<th class='py-2 px-2'>Precio por Unidad</th>";
    echo "<th class='py-2 px-2'>Cantidad en Inventario</th>";
    echo "<th class='py-2 px-2'>Valor Total</th>";
    echo "<th class='py-2 px-2'>Estado</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($productos as $producto) {
        echo "<tr>";
        echo "<td class='py-2 px-2 border-t text-sm'>{$producto['Nombre']}</td>";
        echo "<td class='py-2 px-2 border-t text-sm'>{$producto['Precio']}</td>";
        echo "<td class='py-2 px-2 border-t text-sm'>{$producto['Cantidad']}</td>";
        echo "<td class='py-2 px-2 border-t text-sm'>{$producto['Valor Total']}</td>";
        echo "<td class='py-2 px-2 border-t text-sm'>{$producto['Estado']}</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}

if (!empty($_SESSION['productos'])) {
    mostrarTablaProductos($_SESSION['productos']);
}
?>
<script src="./js/validation.js"></script>
</body>
</html>
