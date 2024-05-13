const SERVER = 'http://localhost/ProyectoCatedraDSS/api/';
const API_JUGADORES = SERVER + 'dashboard/jugador.php?action=';
const API_TORNEO = SERVER + 'dashboard/torneos.php?action=';
const API_SERIE = SERVER + 'dashboard/serie.php?action=';
const API_TORNEOJUGADOR = SERVER + 'dashboard/jugador-torneo.php?action=';

document.addEventListener('DOMContentLoaded', function() {
    listarTorneo();
    listarEstado();
    listarSerie();

    const form = document.getElementById('save-form');
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Previene el envío tradicional del formulario
        const serieId = document.getElementById('id').value;
        if (serieId) {
            actualizarSerie(serieId);
        } else {
            crearSerie();
        }
    });
});

function editarSerie(serieId) {
    const formData = new FormData();
    formData.append('id', serieId); // Asegúrate de enviar el ID

    fetch(API_SERIE + 'readOne&id=' + serieId, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 1 && data.dataset) {
            document.getElementById('id').value = data.dataset.id_serie;
            document.getElementById('idTorneo').value = data.dataset.id_torneo;
            document.getElementById('fechaHora').value = data.dataset.fechaHora;
            document.getElementById('idJugador1').value = data.dataset.id_jugador1; // Asegúrate de que los IDs coincidan
            document.getElementById('idJugador2').value = data.dataset.id_jugador2;
            document.getElementById('ganadorSerie').value = data.dataset.ganadorSerie;
            document.getElementById('estadoSerie').value = data.dataset.id_estadoSerie;
        } else {
            throw new Error('Error al cargar datos de la serie: ' + data.exception);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('No se pudo cargar la información de la serie: ' + error.message);
    });
}

function eliminarSerie(serieId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('id', serieId); // Asegúrate de enviar el ID

            fetch(API_SERIE + 'delete', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 1) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Jugador eliminado correctamente',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    listarSerie(); // Actualizar la lista de jugadores
                } else {
                    throw new Error('Error al eliminar el jugador: ' + data.exception);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'No se pudo eliminar el jugador: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }
    });

}

function listarSerie() {
    fetch(API_SERIE + 'readAll', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json;charset=UTF-8'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al solicitar datos');
        }
        return response.json();
    })
    .then(data => {
        let contenido = '';
        if (data.status === 1 && data.dataset) {
            data.dataset.forEach(serie => {
                contenido += `
                    <tr>
                        <td>${serie.id_serie}</td>
                        <td>${serie.nombre_torneo}</td>
                        <td>${serie.fechaHora}</td>
                        <td>${serie.jugador1}</td>
                        <td>${serie.jugador2}</td>
                        <td>${serie.ganador}</td>
                        <td>${serie.estado_serie}</td>
                        <td>${serie.etapaTorneo}</td>
                        <td>
                            <button class="btn btn-warning btn-sm"  id="edit-${serie.id_serie}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" id="delete-${serie.id_serie}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        } else {
            console.error('Error en los datos recibidos:', data.message);
            contenido = '<tr><td colspan="8">No se encontraron datos</td></tr>';
        }
        document.getElementById('tabla-serie').innerHTML = contenido;
        data.dataset.forEach(serie => {
            document.getElementById(`edit-${serie.id_serie}`).addEventListener('click', function() {
                editarSerie(serie.id_serie);
            });
            document.getElementById(`delete-${serie.id_serie}`).addEventListener('click', function() {
                eliminarSerie(serie.id_serie);
            });
        });
    })
    .catch(error => {
        console.error('Error al cargar las series:', error);
        document.getElementById('tabla-serie').innerHTML = '<tr><td colspan="8">Error al cargar los datos</td></tr>';
    });
}

function crearSerie() {
    const formData = new FormData(document.getElementById('save-form'));
    fetch(API_SERIE + 'create', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 1) {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Serie creada correctamente',
                icon: 'success'
            });
            document.getElementById('formCrearSerie').reset();
        } else {
            throw new Error(data.exception ? data.exception : 'Error al crear la serie');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: error.message,
            icon: 'error'
        });
    });

}

// Función para actualizar un jugador
function actualizarSerie(serieId) {
    const formData = new FormData(document.getElementById('save-form'));
    formData.append('id', serieId); // Asegúrate de enviar el ID

    fetch(API_JUGADORES + 'update', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(result => {
            if (result.status === 1) {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Jugador actualizado correctamente!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                document.getElementById('save-form').reset(); // Limpiar el formulario
                listarSerie(); // Actualizar la lista de jugadores
            } else {
                throw new Error(result.exception); // Manejar errores específicos de la API
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Error',
                text: 'Error al actualizar el jugador: ' + error.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
}

function listarJugadores(idTorneo) {
    fetch(API_JUGADORES + 'readAll', {
        method: 'GET',
        headers: { 'Content-Type': 'application/json;charset=UTF-8' }
    })
    .then(response => response.json())
    .then(data => {
        let opciones = '<option value="">Seleccione un jugador</option>';
        data.dataset.forEach(jugador => {
            opciones += `<option value="${jugador.id_jugador}">${jugador.nombre_jugador}</option>`;
        });
        document.getElementById('idJugador1').innerHTML = opciones;
        document.getElementById('idJugador2').innerHTML = opciones;
        document.getElementById('ganadorSerie').innerHTML = opciones;
    })
    .catch(error => {
        console.error('Error al cargar los jugadores:', error);
    });
}

function listarTorneo() {
    fetch(API_TORNEO + 'readAll', {
        method: 'GET',
        headers: { 'Content-Type': 'application/json;charset=UTF-8' }
    })
    .then(response => response.json())
    .then(data => {
        let opciones = '<option value="">Seleccione un torneo</option>';
        data.dataset.forEach(torneo => {
            opciones += `<option value="${torneo.id_torneo}">${torneo.nombre_torneo}</option>`;
        });

        const torneo = document.getElementById('idTorneo')
       
        torneo.innerHTML = opciones;
        // Agregar un event listener para el evento 'change'
        torneo.addEventListener('change', function() {
            // Obtener el valor seleccionado
            const selectedValue = this.value;
            // Llamar a la función listarJugadores con el valor seleccionado
            listarJugadores(selectedValue);
        });
    })
    .catch(error => {
        console.error('Error al cargar los torneos:', error);
    });
}

function listarEstado() {
    fetch(API_SERIE + 'readAllEstadoSerie', {
        method: 'GET',
        headers: { 'Content-Type': 'application/json;charset=UTF-8' }
    })
    .then(response => response.json())
    .then(data => {
        let opciones = '<option value="">Seleccione un torneo</option>';
        data.dataset.forEach(serie => {
            opciones += `<option value="${serie.id_estadoSerie}">${serie.estadoserie}</option>`;
        });
        document.getElementById('estadoSerie').innerHTML = opciones;
    })
    .catch(error => {
        console.error('Error al cargar los torneos:', error);
    });
}

