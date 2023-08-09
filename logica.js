//_____________________________________________Inicio Obtención de la fecha
// Obtener el elemento del año
const yearElement = document.getElementById('year');

// Obtener el año actual
const year = new Date().getFullYear();

// Insertar el año actual en el elemento del año
yearElement.textContent = year;
//________________________________________________Fin Obtención de la fecha