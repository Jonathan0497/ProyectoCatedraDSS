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
            document.getElementById('nombre').value = data.dataset.nombre_torneo;
            document.getElementById('estado').value = data.dataset.id_estadoTorneo; // Asegúrate de que los IDs coincidan
            document.getElementById('fechaInicio').value = data.dataset.fecha_inicio;
            document.getElementById('fechaFin').value = data.dataset.fecha_fin;
            document.getElementById('formato').value = data.dataset.id_formatoPartido;
            document.getElementById('tipo').value = data.dataset.id_tipoTorneo;
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