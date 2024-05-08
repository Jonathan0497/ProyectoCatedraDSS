<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/jugador.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $jugador = new Jugador;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    $result['session'] = 1;
    // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
    switch ($_GET['action']) {
        case 'readAll':
            if ($result['dataset'] = $jugador->readAll()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No hay datos registrados';
            }
            break;
        case 'readAllNivelHabilidad':
            if ($result['dataset'] = $jugador->readAllNivelHabilidad()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No hay datos registrados';
            }
            break;
        case 'readAllGenero':
            if ($result['dataset'] = $jugador->readAllGenero()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No hay datos registrados';
            }
            break;
        case 'search':
            $_POST = $jugador->validateForm($_POST);
            if ($_POST['search'] == '') {
                $result['exception'] = 'Ingrese un valor para buscar';
            } elseif ($result['dataset'] = $jugador->searchRows($_POST['search'])) {
                $result['status'] = 1;
                $result['message'] = 'Valor encontrado';
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No hay coincidencias';
            }
            break;
        case 'create':
            $_POST = $jugador->validateForm($_POST);
            if (!$jugador->setNombreJugador($_POST['nombre'])) {
                $result['exception'] = 'Nombre incorrectos';
            } elseif (!$jugador->setEdad($_POST['edad'])) {
                $result['exception'] = 'Edad incorrecta';
            } elseif (!$jugador->setTelefono($_POST['telefono'])) {
                $result['exception'] = 'Telefono incorrecto';
            } elseif (!$jugador->setCorreo($_POST['correo'])) {
                $result['exception'] = 'Correo incorrecto';
            } elseif (!$jugador->setIdNivelHabilidad($_POST['nivelHabilidad'])) {
                $result['exception'] = 'Nivel de habilidad incorrecto';
            } elseif (!$jugador->setIdGenero($_POST['genero'])) {
                $result['exception'] = 'Genero incorrecto';
            } elseif ($jugador->createRow()) {
                $result['status'] = 1;
                $result['message'] = 'Jugador creado correctamente';
            } else {
                $result['exception'] = Database::getException();
            }
            break;
        case 'readOne':
            if (!$jugador->setIdJugador($_POST['id'])) {
                $result['exception'] = 'Jugador incorrecto';
            } elseif ($result['dataset'] = $jugador->readOne()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'Jugador inexistente';
            }
            break;
        case 'update':
            $_POST = $jugador->validateForm($_POST);
            if (!$jugador->setIdJugador($_POST['id'])) {
                $result['exception'] = 'Jugador incorrecto';
            } elseif (!$jugador->readOne()) {
                $result['exception'] = 'Jugador inexistente';
            } elseif (!$jugador->setNombreJugador($_POST['nombre'])) {
                $result['exception'] = 'Nombre incorrecta';
            } elseif (!$jugador->setEdad($_POST['edad'])) {
                $result['exception'] = 'Edad incorrecta';
            } elseif (!$jugador->setTelefono($_POST['telefono'])) {
                $result['exception'] = 'Telefono incorrecto';
            } elseif (!$jugador->setCorreo($_POST['correo'])) {
                $result['exception'] = 'Correo incorrecto';
            } elseif (!$jugador->setIdNivelHabilidad($_POST['nivelHabilidad'])) {
                $result['exception'] = 'Nivel de habilidad incorrecto';
            } elseif (!$jugador->setIdGenero($_POST['genero'])) {
                $result['exception'] = 'Genero incorrecto';
            } elseif ($jugador->updateRow()) {
                $result['status'] = 1;
                $result['message'] = 'Jugador modificado correctamente';
            } else {
                $result['exception'] = Database::getException();
            }
            break;
        case 'delete':
            if (!$jugador->setIdJugador($_POST['id'])) {
                $result['exception'] = 'Jugador incorrecto';
            } elseif (!$jugador->readOne()) {
                $result['exception'] = 'Jugador inexistente';
            } elseif ($jugador->deleteRow()) {
                $result['status'] = 1;
                $result['message'] = 'Jugador eliminado correctamente';
            } else {
                $result['exception'] = Database::getException();
            }
            break;
        default:
            $result['exception'] = 'Acción no disponible dentro de la sesión';
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
