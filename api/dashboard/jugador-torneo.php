<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/jugador-torneo.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $jugadorTorneo = new JugadorTorneo;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    $result['session'] = 1;
    // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
    switch ($_GET['action']) {
        case 'readAll':
            if ($result['dataset'] = $jugadorTorneo->readAll()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No hay datos registrados';
            }
            break;
        case 'create':
            $_POST = $jugadorTorneo->validateForm($_POST);
            if (!$jugadorTorneo->setIdJugador($_POST['idJugador'])) {
                $result['exception'] = 'Identificador del jugador incorrecto';
            } elseif (!$jugadorTorneo->setIdTorneo($_POST['idTorneo'])) {
                $result['exception'] = 'Identificador del torneo incorrecto';
            } elseif ($jugadorTorneo->createRow()) {
                $result['status'] = 1;
                $result['message'] = 'Inscripcion al torneo realizada correctamente';
            } else {
                $result['exception'] = Database::getException();
            }
            break;
        case 'readOne':
            if (!$jugadorTorneo->setId($_POST['id'])) {
                $result['exception'] = 'Identificador incorrecto';
            } elseif ($result['dataset'] = $jugadorTorneo->readOne()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'Identificador inexistente';
            }
            break;
        case 'update':
            $_POST = $jugadorTorneo->validateForm($_POST);
            if (!$jugadorTorneo->setId($_POST['id'])) {
                $result['exception'] = 'Identificador incorrecto';
            } elseif (!$jugadorTorneo->readOne()) {
                $result['exception'] = 'Identificador inexistente';
            } else if (!$jugadorTorneo->setIdJugador($_POST['idJugador'])) {
                $result['exception'] = 'Identificador del jugador incorrecto';
            } elseif (!$jugadorTorneo->setIdTorneo($_POST['idTorneo'])) {
                $result['exception'] = 'Identificador del torneo incorrecto';
            } elseif ($jugadorTorneo->updateRow()) {
                $result['status'] = 1;
                $result['message'] = 'Inscripcion modificada correctamente';
            } else {
                $result['exception'] = Database::getException();
            }
            break;
        case 'delete':
            if (!$jugadorTorneo->setId($_POST['id'])) {
                $result['exception'] = 'Identificador incorrecto';
            } elseif (!$jugadorTorneo->readOne()) {
                $result['exception'] = 'Identificador inexistente';
            } elseif ($jugadorTorneo->deleteRow()) {
                $result['status'] = 1;
                $result['message'] = 'Inscripcion eliminada correctamente';
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
