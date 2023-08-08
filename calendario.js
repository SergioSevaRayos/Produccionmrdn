function actualizarHistorico(fecha, metrosCubicos) {
    var tabla = document.querySelector("table");
    var fila = tabla.insertRow(-1); // Insertar una nueva fila al final de la tabla

    var celdaFecha = fila.insertCell(0); // Insertar una nueva celda para la fecha en la primera columna
    var celdaMetros = fila.insertCell(1); // Insertar una nueva celda para los metros cúbicos en la segunda columna

    celdaFecha.textContent = fecha;
    celdaMetros.textContent = metrosCubicos;
}

// Escuchar el evento submit del formulario para actualizar el histórico
var form = document.querySelector("form");
form.addEventListener("submit", function(event) {
    event.preventDefault(); // Evitar que el formulario se envíe

    var metrosCubicos = document.getElementById("metros_cubicos").value;
    var fecha = new Date().toLocaleDateString(); // Obtener la fecha actual en formato de cadena

    actualizarHistorico(fecha, metrosCubicos);

    // Limpiar el campo de entrada de metros cúbicos después de guardar la producción
    document.getElementById("metros_cubicos").value = "";
});