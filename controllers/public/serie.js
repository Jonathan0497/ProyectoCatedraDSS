const SERVER = 'http://localhost/ProyectoCatedraDSS/api/';
const API_JUGADORES = SERVER + 'dashboard/jugador.php?action=';
const API_TORNEO = SERVER + 'dashboard/torneos.php?action=';
const API_SERIE = SERVER + 'dashboard/serie.php?action=';
const API_PARTIDOS = SERVER + 'dashboard/partidos.php?action=';

document.addEventListener('DOMContentLoaded', function() {
    listarJugadores();
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

    
    document.getElementById('saveChanges').addEventListener('click', actualizarPartido);
    document.getElementById('closeModal').addEventListener('click', closeModal);
    document.getElementById('closeModal2').addEventListener('click', closeModal2);
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
                        <td>
                            <button class="btn btn-warning btn-sm"  id="edit-${serie.id_serie}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" id="delete-${serie.id_serie}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <button class="btn btn-info btn-sm" id="partido-${serie.id_serie}">
                                <i class="fa-regular fa-user"></i>
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
            document.getElementById(`partido-${serie.id_serie}`).addEventListener('click', function() {
                listarPartido(serie.id_serie);
                openModal();
            });
        });
    })
    .catch(error => {
        console.error('Error al cargar las series:', error);
        document.getElementById('tabla-serie').innerHTML = '<tr><td colspan="8">Error al cargar los datos</td></tr>';
    });
}

function listarPartido(idSerie) {
    // Crear un objeto FormData para enviar el ID de la serie
    let formData = new FormData();
    formData.append('id', idSerie);

    // Realizar la petición POST al endpoint correcto
    fetch('http://localhost/ProyectoCatedraDSS/api/dashboard/partidos.php?action=readPartidoSerie', {
        method: 'POST',
        body: formData
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
            data.dataset.forEach(partido => {
                contenido += `
                    <tr>
                        <td>${partido.id_partidos}</td>
                        <td>${partido.nombre_jugador1}</td>
                        <td>${partido.nombre_jugador2}</td>
                        <td>${partido.nombre_torneo}</td>
                        <td>
                            <button class="btn btn-warning btn-sm"  id="edit-${partido.id_partidos}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" id="delete-${partido.id_partidos}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        } else {
            console.error('Error en los datos recibidos:', data.message);
            contenido = '<tr><td colspan="5">No se encontraron datos</td></tr>';
        }
        document.getElementById('tabla-partidos').innerHTML = contenido;
        data.dataset.forEach(partido => {
            document.getElementById(`edit-${partido.id_partidos}`).addEventListener('click', function () {
                cargarGanadores(idSerie);
                openModal2(partido.id_partidos);
            });
        });
    })
    .catch(error => {
        console.error('Error al cargar los partidos:', error);
        document.getElementById('tabla-partidos').innerHTML = '<tr><td colspan="5">Error al cargar los datos</td></tr>';
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
            document.getElementById('save-form').reset();
            listarSerie();
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

    fetch(API_SERIE + 'update', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(result => {
            if (result.status === 1) {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Serie actualizada correctamente!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                document.getElementById('save-form').reset(); // Limpiar el formulario
                listarSerie();
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

function listarJugadores() {
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
    })
    .catch(error => {
        console.error('Error al cargar los jugadores:', error);
    });
}

function actualizarPartido() {
    const form = document.getElementById('options-form');
    const formData = new FormData(form);
    formData.append('idPartido', document.getElementById('idPartido').value);  // Asegúrate de que 'idPartido' tiene el valor correcto.

    // Imprimir el contenido de FormData para depuración
    console.log("Datos enviados al servidor:");
    for (var pair of formData.entries()) {
        console.log(pair[0]+ ': ' + pair[1]);
    }

    fetch('http://localhost/ProyectoCatedraDSS/api/dashboard/partidos.php?action=update', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 1) {
            Swal.fire({
                title: '¡Éxito!',
                text: data.message,
                icon: 'success'
            });
            closeModal2();  // Cierra el modal después de la actualización exitosa
            listarSerie();  // Actualiza la lista de jugadores
        } else {
            throw new Error(data.exception ? data.exception : 'Error al actualizar el partido');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'Error al actualizar el partido: ' + error.message,
            icon: 'error'
        });
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
        document.getElementById('idTorneo').innerHTML = opciones;
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

function cargarGanadores(idSerie) {
    let formData = new FormData();
    formData.append('id', idSerie);

    fetch('http://localhost/ProyectoCatedraDSS/api/dashboard/partidos.php?action=readJugadoresSerie', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al solicitar datos');
        }
        return response.json();
    })
    .then(data => {
        let selectElement = document.getElementById('idGanador');
        selectElement.innerHTML = '';  // Limpiar opciones existentes

        if (data.status === 1 && data.dataset) {
            data.dataset.forEach(jugador => {
                // Añadir opciones para jugador 1 y jugador 2
                selectElement.options.add(new Option(jugador.nombre_jugador1, jugador.id_jugador1));
                selectElement.options.add(new Option(jugador.nombre_jugador2, jugador.id_jugador2));
            });
        } else {
            console.error('Error en los datos recibidos:', data.message);
            selectElement.options.add(new Option('No se encontraron datos', ''));
        }
    })
    .catch(error => {
        console.error('Error al cargar los jugadores:', error);
        document.getElementById('idGanador').innerHTML = '<option>Error al cargar los datos</option>';
    });
}
function openModal() {
    const modal = document.getElementById('optionsModal');
    if (modal) {
        modal.style.display = 'block';
        modal.classList.add('show');
    } else {
        console.error('Modal element not found');
    }
}

function openModal2(partidoId) {
    const modal = document.getElementById('EditarPartido');
    if (modal) {
        modal.style.display = 'block';
        modal.classList.add('show');
        document.getElementById('idPartido').value = partidoId; // Asegúrate de que este input exista en tu formulario
    } else {
        console.error('Modal element not found');
    }
}

function closeModal() {
    const modal = document.getElementById('optionsModal');
    modal.style.display = 'none'; 
    modal.classList.remove('show');
}

function closeModal2() {
    const modal = document.getElementById('EditarPartido');
    modal.style.display = 'none'; 
    modal.classList.remove('show');
}


