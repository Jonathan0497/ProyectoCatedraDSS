$(document).ready(function() {
    $('#logoutButton').click(function(e) {
        e.preventDefault(); // Previene la navegación estándar del enlace

        $.ajax({
            url: 'http://localhost/ProyectoCatedraDSS/api/dashboard/usuarios.php?action=logOut',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 1) {
                    // Sesión cerrada correctamente, mostrar Sweet Alert y luego redirigir
                    Swal.fire({
                        title: '¡Sesión Cerrada!',
                        text: 'Has cerrado sesión correctamente.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = 'login.html';
                        }
                    });
                } else {
                    // Manejar el error al cerrar sesión con Sweet Alert
                    Swal.fire({
                        title: 'Error',
                        text: response.exception,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function() {
                // Error en la solicitud AJAX
                Swal.fire({
                    title: 'Error',
                    text: 'Error en la solicitud AJAX.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
