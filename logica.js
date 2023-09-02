//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//_____________________________________________Inicio Obtención de la fecha
// Obtener el elemento del año
const yearElement = document.getElementById('year');

// Obtener el año actual
const year = new Date().getFullYear();

// Insertar el año actual en el elemento del año
yearElement.textContent = year;
//________________________________________________Fin Obtención de la fecha
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//_____________________________________________________Inicio Cerrar sesión
function cerrarSesion() {
    // Hacer una solicitud AJAX para cerrar la sesión en el servidor
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Redireccionar a la página de inicio (index.html) después de cerrar la sesión
            window.location.href = "index.html";
        }
    };
    xhttp.open("GET", "cerrar_sesion.php", true);
    xhttp.send();
}
//________________________________________________________Fin Cerrar sesión
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//__________________________________________Inicio Almacenar usuario cookie
window.addEventListener('load', function () {
    const emailUsuarioElement = document.getElementById('email-usuario');
    const userEmailCookie = getCookie("user_email");

    if (userEmailCookie) {
        // Muestra el email del usuario en el elemento HTML
        emailUsuarioElement.textContent = userEmailCookie;

        // Muestra el elemento usuario-conectado
        const usuarioConectadoElement = document.getElementById('usuario-conectado');
        usuarioConectadoElement.style.display = 'block';
    }
});

// Función para obtener el valor de una cookie por su nombre
function getCookie(name) {
    const value = "; " + document.cookie;
    const parts = value.split("; " + name + "=");

    if (parts.length === 2) {
        return parts.pop().split(";").shift();
    }
}
//_____________________________________________Fin Almacenar usuario cookie
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//__________________________________Inicio Almacenar producción refrigerado
document.getElementById('formulario-produccion').addEventListener('submit', function (event) {
    event.preventDefault(); // Evita el envío normal del formulario

    const fecha = document.getElementById('fecha').value;
    const metrosCubicos = parseFloat(document.getElementById('metros_cubicos').value);

    guardarProduccionEnBaseDeDatos(fecha, metrosCubicos);
});

// Función para guardar producción en la base de datos
function guardarProduccionEnBaseDeDatos(fecha, metrosCubicos) {
    // Crear una instancia de XMLHttpRequest para la solicitud AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // La respuesta del servidor ha sido exitosa
            window.location.href = "inicio.html";
        }
    };

    // Configurar la solicitud
    xhttp.open("POST", "guardar_produccion.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Crear el cuerpo de la solicitud con los datos a enviar
    const requestBody = "fecha=" + fecha + "&metros_cubicos=" + metrosCubicos;

    // Enviar la solicitud
    xhttp.send(requestBody);
}
//_____________________________________Fin Almacenar producción refrigerado
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//______________________________Inicio Obtener producción refrigerado tabla
document.addEventListener("DOMContentLoaded", function () {
    const produccionTable = document.getElementById('produccionTable');
    const produccionBody = document.getElementById('produccionBody');

    const userEmailCookie = getCookie("user_email");

    if (userEmailCookie) {
        fetch(`mostrar_produccion.php?email=${userEmailCookie}`)
            .then(response => response.json())
            .then(data => {
                let content = "";

                if (data.length > 0) {
                    data.forEach(item => {
                        content += `<tr><td>${item.fecha}</td><td>${item.metros_cubicos}</td></tr>`;
                    });
                } else {
                    content = "<tr><td colspan='2'>No hay registros de producción para este usuario.</td></tr>";
                }

                produccionBody.innerHTML = content;
                produccionTable.style.display = 'block';
            })
            .catch(error => console.error("Error fetching data:", error));
    }
});
//_________________________________Fin Obtener producción refrigerado tabla
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//____________________________Inicio Obtener producción refrigerado gráfico
// ? ? ? ? ? ? ? ? ? ? ? ? 
//_______________________________Fin Obtener producción refrigerado gráfico
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//________________________________________________Inicio Calendario
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendario');
    var modelos = document.querySelectorAll('input[name="modelo"]');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true, // Permite seleccionar fechas
        locale: 'es', // Configura el idioma en español
        firstDay: 1, // Establece el primer día de la semana en lunes (1)
        select: function (info) {
            // Obtiene el modelo seleccionado
            var modeloSeleccionado = document.querySelector('input[name="modelo"]:checked');

            if (modeloSeleccionado) {
                var selectedModelClass = modeloSeleccionado.value;

                // Aplica la clase del modelo seleccionado a la casilla
                var cell = info.dayEl;
                cell.classList.add(selectedModelClass);
            } else {
                alert("Selecciona un modelo antes de aplicarlo a la casilla.");
            }
        }
    });

    calendar.render();
});
//___________________________________________________Fin Calendario
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@



