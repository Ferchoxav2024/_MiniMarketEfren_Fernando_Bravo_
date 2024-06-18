document.getElementById('formulario').addEventListener('submit', function(event) {
    let errores = false;

    const nombre = document.getElementById('nombre').value;
    if (nombre === '') {
        document.getElementById('errorNombre').innerText = 'El nombre es requerido.';
        errores = true;
    } else {
        document.getElementById('errorNombre').innerText = '';
    }

    const precio = document.getElementById('precio').value;
    if (precio === '' || isNaN(precio) || precio <= 0) {
        document.getElementById('errorPrecio').innerText = 'El precio debe ser un número positivo.';
        errores = true;
    } else {
        document.getElementById('errorPrecio').innerText = '';
    }

    const cantidad = document.getElementById('cantidad').value;
    if (cantidad === '' || isNaN(cantidad) || cantidad < 0) {
        document.getElementById('errorCantidad').innerText = 'La cantidad debe ser un número no negativo.';
        errores = true;
    } else {
        document.getElementById('errorCantidad').innerText = '';
    }

    if (errores) {
        event.preventDefault();
    }
});
