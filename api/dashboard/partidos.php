<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/partidos.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    session_start();
    // Se instancia la clase correspondiente.
    $partido = new Partidos;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    $result['session'] = 1;
    // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
    switch ($_GET['action']) {
        case 'update':
            $_POST = $partido->validateForm($_POST);
            if (!$partido->setIdPartidos($_POST['idPartido'])) {
                $result['exception'] = 'Identificador incorrecto';
            } elseif (!$partido->readPartido()) {
                $result['exception'] = 'Identificador inexistente';
            } else if (!$partido->setGanadorPartido($_POST['idGanador'])) {
                $result['exception'] = 'Identificador del jugador incorrecto';
            } elseif ($partido->updatePartido()) {
                $result['status'] = 1;
                $result['message'] = 'El ganador del partido ha sido actualizado correctamente';
            } else {
                $result['exception'] = Database::getException();
            }
            break;
        case 'readPartidoSerie':
            if (!$partido->setIdSerie($_POST['id'])) {
                $result['exception'] = 'Identificador incorrecto';
            } elseif ($result['dataset'] = $partido->readPartidos()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'Identificador inexistente';
            }
            break;
        case 'readOnePartidoSerie':
            if (!$partido->setIdPartidos($_POST['id'])) {
                $result['exception'] = 'Identificador incorrecto';
            } elseif ($result['dataset'] = $partido->readPartido()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'Identificador inexistente';
            }
            break;
        case 'readJugadoresSerie':
            if (!$partido->setIdSerie($_POST['id'])) {
                $result['exception'] = 'Identificador incorrecto';
            } elseif ($result['dataset'] = $partido->readJugadoresSerie()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'Identificador inexistente';
            }
            break;
        case 'default':
                 exit('Recurso no disponible');
            break;
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    exit('Recurso denegado');
}
