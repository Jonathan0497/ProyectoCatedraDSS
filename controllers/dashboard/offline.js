/*
*   Controlador de uso general en las páginas web del sitio privado cuando no se ha iniciado sesión.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    const header = `
        <div class="navbar-fixed">
            <nav class="teal">
                <div class="nav-wrapper center-align">
                    <a href="index.html" class="brand-logo"><i class="material-icons">dashboard</i></a>
                </div>
            </nav>
        </div>
    `;
    const footer = `
        <div class="container">
            <div class="row">
                <b>Dashboard de PingPong</b>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <span>© 2018-2022 Copyright PingPong. Todos los derechos reservados.</span>
                <span class="right">Diseñado con
                    <a href="http://materializecss.com/" target="_blank">
                        <img src="../../resources/img/materialize.png" height="20" style="vertical-align:middle" alt="Materialize">
                    </a>
                </span>
            </div>
        </div>
    `;
    document.querySelector('header').innerHTML = header;
    document.querySelector('footer').innerHTML = footer;
});