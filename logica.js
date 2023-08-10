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