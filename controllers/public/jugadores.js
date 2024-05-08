
const SERVER = 'http://localhost/ProyectoCatedraDSS/api/';
const API_JUGADORES = SERVER + 'dashboard/jugador.php?action=';
const ENDPOINT_HABILIDAD = SERVER + 'dashboard/jugador.php?action=readAllNivelHabilidad';
const ENDPOINT_GENERO = SERVER + 'dashboard/jugador.php?action=readAllGenero';

function editarJugador(jugadorId) {
    const formData = new FormData();
    formData.append('id', jugadorId); // Asegúrate de enviar el ID

    fetch(API_JUGADORES + 'readOne&id=' + jugadorId, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 1 && data.dataset) {
            document.getElementById('id').value = data.dataset.id_jugador;
            document.getElementById('nombre').value = data.dataset.nombre_jugador;
            document.getElementById('genero').value = data.dataset.id_genero; // Asegúrate de que los IDs coincidan
            document.getElementById('telefono').value = data.dataset.telefono;
            document.getElementById('edad').value = data.dataset.edad;
            document.getElementById('correo').value = data.dataset.correo;
            document.getElementById('nivelHabilidad').value = data.dataset.id_nivelHabilidad;
        } else {
            throw new Error('Error al cargar datos del jugador: ' + data.exception);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('No se pudo cargar la información del jugador: ' + error.message);
    });
}

function eliminarJugador(jugadorId) {
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
            formData.append('id', jugadorId); // Asegúrate de enviar el ID

            fetch(API_JUGADORES + 'delete', {
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
                    listarJugadores(); // Actualizar la lista de jugadores
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

document.addEventListener('DOMContentLoaded', function () {
    listarJugadores();
    listarHabilidades();
    listarGeneros();

    const form = document.getElementById('save-form');
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Previene el envío tradicional del formulario
        const jugadorId = document.getElementById('id').value;
        if (jugadorId) {
            actualizarJugador(jugadorId);
        } else {
            crearJugador();
        }
    });
});

// Listar jugadores
function listarJugadores() {
    fetch(API_JUGADORES + 'readAll', {
        method: 'GET',
        headers: { 'Content-Type': 'application/json;charset=UTF-8' }
    })
    .then(response => response.json())
    .then(data => {
        let contenido = '';
        data.dataset.forEach(jugador => {
            contenido += `
                <tr>
                    <td>${jugador.id_jugador}</td>
                    <td>${jugador.nombre_jugador}</td>
                    <td>${jugador.genero}</td>
                    <td>${jugador.telefono}</td>
                    <td>${jugador.edad}</td>
                    <td>${jugador.correo}</td>
                    <td>${jugador.nivelHabilidad}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" id="edit-${jugador.id_jugador}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" id="delete-${jugador.id_jugador}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        document.getElementById('tabla-jugadores').innerHTML = contenido;
        data.dataset.forEach(jugador => {
            document.getElementById(`edit-${jugador.id_jugador}`).addEventListener('click', function() {
                editarJugador(jugador.id_jugador);
            });
            document.getElementById(`delete-${jugador.id_jugador}`).addEventListener('click', function() {
                eliminarJugador(jugador.id_jugador);
            });
        });
    });
}


// Función para crear un jugador
function crearJugador() {
    const formData = new FormData(document.getElementById('save-form'));

    fetch(API_JUGADORES + 'create', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === 1) {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Jugador creado correctamente!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            document.getElementById('save-form').reset();
            listarJugadores(); // Actualizar la lista de jugadores
        } else {
            throw new Error(result.exception); // Manejar errores específicos de la API
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error',
            text: 'Error al crear el jugador: ' + error.message,
            icon: 'error',
            confirmButtonText: 'OK'
        });
        console.error('Error en fetch:', error);
    });
}


// Función para actualizar un jugador
function actualizarJugador(jugadorId) {
    const formData = new FormData(document.getElementById('save-form'));
    formData.append('id', jugadorId); // Asegúrate de enviar el ID

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

function listarHabilidades() {
    fetch(ENDPOINT_HABILIDAD, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json;charset=UTF-8' }
    })
        .then(response => response.json())
        .then(data => {
            let contenido = '';
            data.dataset.forEach(habilidad => {
                contenido += `
                    <option value="${habilidad.id_nivelHabilidad}">${habilidad.nivelHabilidad}</option>
                `;
            });
            document.getElementById('nivelHabilidad').innerHTML = contenido;
        });
}

function listarGeneros() {
    fetch(ENDPOINT_GENERO, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json;charset=UTF-8' }
    })
        .then(response => response.json())
        .then(data => {
            let contenido = '';
            data.dataset.forEach(genero => {
                contenido += `
                    <option value="${genero.id_genero}">${genero.genero}</option>
                `;
            });
            document.getElementById('genero').innerHTML = contenido;
        });
}

