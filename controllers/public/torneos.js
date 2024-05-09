const SERVER = 'http://localhost/ProyectoCatedraDSS/api/';
const API_TORNEO = SERVER + 'dashboard/torneos.php?action=';
const ENDPOINT_HABILIDAD = SERVER + 'dashboard/torneos.php?action=readNivelHabilidad';
const ENDPOINT_ESTADO = SERVER + 'dashboard/torneos.php?action=readEstadoTorneo';
const ENDPOINT_FORMATO = SERVER + 'dashboard/torneos.php?action=readFormatoPartido';
const ENDPOINT_TIPO = SERVER + 'dashboard/torneos.php?action=readTipoTorneo';

document.addEventListener('DOMContentLoaded', function () {
    listarNivelHabilidad();
    listarEstadoTorneo();
    listarFormatoPartido();
    listarTipoTorneo();
    listarTorneo();
    
    const form = document.getElementById('save-form');
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Previene el envío tradicional del formulario
        const torneoId = document.getElementById('id').value;
        if (torneoId) {
            actualizarTorneo(torneoId);
        } else {
            crearTorneo();
        }
    });
});

function editarTorneo(torneoId) {
    const formData = new FormData();
    formData.append('id', torneoId); // Asegúrate de enviar el ID

    fetch(API_TORNEO + 'readOne&id=' + torneoId, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 1 && data.dataset) {
            document.getElementById('id').value = data.dataset.id_torneo;
            document.getElementById('nombre_torneo').value = data.dataset.nombre_torneo;
            document.getElementById('idNivelHabilidad').value = data.dataset.id_nivelHabilidad; // Asegúrate de que los IDs coincidan
            document.getElementById('fechaInicio').value = data.dataset.fechaInicio;
            document.getElementById('idTipoTorneo').value = data.dataset.id_tipoTorneo;
            document.getElementById('idEstadoTorneo').value = data.dataset.id_estadoTorneo;
            document.getElementById('idFormatoPartido').value = data.dataset.id_formatoPartido;
            document.getElementById('direccion').value = data.dataset.direccion;
        } else {
            throw new Error('Error al cargar datos del torneo: ' + data.exception);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('No se pudo cargar la información del torneo: ' + error.message);
    });
}

function eliminarTorneo(torneoId) {
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
            formData.append('id', torneoId); // Asegúrate de enviar el ID

            fetch(API_TORNEO + 'delete', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 1) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Torneo eliminado correctamente',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    throw new Error('Error al eliminar torneo: ' + data.exception);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('No se pudo eliminar el torneo: ' + error.message);
            });
        }
    });
}

function listarNivelHabilidad() {
    fetch(ENDPOINT_HABILIDAD)
    .then(response => response.json())
    .then(data => {
        if (data.status === 1 && data.dataset) {
            let habilidades = '<option value="">Selecciona una habilidad</option>';
            data.dataset.forEach(habilidad => {
                habilidades += `<option value="${habilidad.id_nivelHabilidad}">${habilidad.nivelHabilidad}</option>`;
            });
            document.getElementById('idNivelHabilidad').innerHTML = habilidades;
        } else {
            throw new Error('Error al cargar las habilidades: ' + data.exception);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('No se pudo cargar las habilidades: ' + error.message);
    });
}

function listarEstadoTorneo() {
    fetch(ENDPOINT_ESTADO)
    .then(response => response.json())
    .then(data => {
        if (data.status === 1 && data.dataset) {
            let estados = '<option value="">Selecciona un estado</option>';
            data.dataset.forEach(estado => {
                estados += `<option value="${estado.id_estadoTorneo}">${estado.estadoTorneo}</option>`;
            });
            document.getElementById('idEstadoTorneo').innerHTML = estados;
        } else {
            throw new Error('Error al cargar los estados: ' + data.exception);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('No se pudo cargar los estados: ' + error.message);
    });
}

function listarFormatoPartido() {
    fetch(ENDPOINT_FORMATO)
    .then(response => response.json())
    .then(data => {
        if (data.status === 1 && data.dataset) {
            let formatos = '<option value="">Selecciona un formato</option>';
            data.dataset.forEach(formato => {
                formatos += `<option value="${formato.id_formatoPartido}">${formato.descripcion}</option>`;
            });
            document.getElementById('idFormatoPartido').innerHTML = formatos;
        } else {
            throw new Error('Error al cargar los formatos: ' + data.exception);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('No se pudo cargar los formatos: ' + error.message);
    });
}

function listarTipoTorneo() {
    fetch(ENDPOINT_TIPO)
    .then(response => response.json())
    .then(data => {
        if (data.status === 1 && data.dataset) {
            let tipos = '<option value="">Selecciona un tipo</option>';
            data.dataset.forEach(tipo => {
                tipos += `<option value="${tipo.id_tipoTorneo}">${tipo.tipotorneo}</option>`;
            });
            document.getElementById('idTipoTorneo').innerHTML = tipos;
        } else {
            throw new Error('Error al cargar los tipos: ' + data.exception);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('No se pudo cargar los tipos: ' + error.message);
    });
}

function listarTorneo() {
    fetch(API_TORNEO + 'readAll', {
        method: 'GET',
        headers: { 'Content-Type': 'application/json;charset=UTF-8' }
    })
    .then(response => response.json())
    .then(data => {
        let contenido = '';
        data.dataset.forEach(torneo => {
            contenido += `
                <tr>
                    <td>${torneo.id_torneo}</td>
                    <td>${torneo.nombre_torneo}</td>
                    <td>${torneo.direccion}</td>
                    <td>${torneo.maxjugadores}</td>
                    <td>${torneo.fechaInicio}</td>
                    <td>${torneo.NivelHabilidad}</td>
                    <td>${torneo.FormatoPartido}</td>
                    <td>${torneo.EstadoTorneo}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" id="edit-${torneo.id_torneo}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" id="delete-${torneo.id_torneo}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        document.getElementById('tabla-torneos').innerHTML = contenido;
        data.dataset.forEach(torneo => {
            document.getElementById(`edit-${torneo.id_torneo}`).addEventListener('click', function() {
                editarTorneo(torneo.id_torneo);
            });
            document.getElementById(`delete-${torneo.id_torneo}`).addEventListener('click', function() {
                eliminarTorneo(torneo.id_torneo);
            });
        });
    });
}

function crearTorneo() {
    const formData = new FormData(document.getElementById('save-form'));

    fetch(API_TORNEO + 'create', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === 1) {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Torneo creado correctamente',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
            });
            setTimeout(() => window.location.reload(), 1500);
        } else {
            throw new Error('Error al crear torneo: ' + result.exception);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('No se pudo crear el torneo: ' + error.message);
    });
}

// Función para actualizar un jugador
function actualizarTorneo(torneoId) {
    const formData = new FormData(document.getElementById('save-form'));
    formData.append('id', torneoId); // Asegúrate de enviar el ID

    fetch(API_TORNEO + 'update', {
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
                listarJugadores(); // Actualizar la lista de jugadores
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