<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/serie.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $serie = new Serie;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.

    $result['session'] = 1;
    // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
    switch ($_GET['action']) {
        case 'readAll':
            if ($result['dataset'] = $serie->readAll()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No hay datos registrados';
            }
            break;
        case 'readAllEstadoSerie':
            if ($result['dataset'] = $serie->readEstadoSerie()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No hay datos registrados';
            }
            break;
        case 'search':
            $_POST = $serie->validateForm($_POST);
            if ($_POST['search'] == '') {
                $result['exception'] = 'Ingrese un valor para buscar';
            } elseif ($result['dataset'] = $serie->searchRows($_POST['search'])) {
                $result['status'] = 1;
                $result['message'] = 'Valor encontrado';
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No hay coincidencias';
            }
            break;
        case 'create':
            $_POST = $serie->validateForm($_POST);
            // Aquí deberás recoger y validar los datos de la serie, no de los torneos.
            // Los nombres de los métodos de set deben coincidir con los que has definido en la clase Serie.
            if (!$serie->setIdTorneo($_POST['idTorneo'])) {
                $result['exception'] = 'Identificador del torneo incorrecto';
            } elseif (!$serie->setIdJugador1($_POST['idJugador1'])) {
                $result['exception'] = 'Identificador del jugador 1 incorrecto';
            } elseif (!$serie->setIdJugador2($_POST['idJugador2'])) {
                $result['exception'] = 'Identificador del jugador 2 incorrecto';
            } elseif (!$serie->setFechaHora($_POST['fechaHora'])) {
                $result['exception'] = 'Fecha y hora incorrectas';
            // Aseguramos que setGanadorSerie sea llamado sólo si ganadorSerie está definido y no es nulo.
            } elseif (!$serie->setIdEstadoSerie($_POST['estadoSerie'])) {
                $result['exception'] = 'Estado de la serie incorrecto';
            } elseif ($serie->createRow()) {
                $result['status'] = 1;
                $result['message'] = 'Serie creada correctamente';
            } else {
                $result['exception'] = Database::getException();
            }
            
            break;
        case 'readOne':
            if (!$serie->setId($_POST['id'])) {
                $result['exception'] = 'Serie incorrecto';
            } elseif ($result['dataset'] = $serie->readOne()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'Serie inexistente';
            }
            break;
        case 'update':
            $_POST = $serie->validateForm($_POST);
            if (!$serie->setId($_POST['id'])) {
                $result['exception'] = 'Serie incorrecto';
            } elseif (!$serie->readOne()) {
                $result['exception'] = 'Serie inexistente';
            } elseif (!$serie->setIdTorneo($_POST['idTorneo'])) {
                $result['exception'] = 'Identificador del torneo incorrecto';
            } elseif (!$serie->setIdJugador1($_POST['idJugador1'])) {
                $result['exception'] = 'Identificador del jugador 1 incorrecto';
            } elseif (!$serie->setIdJugador2($_POST['idJugador2'])) {
                $result['exception'] = 'Identificador del jugador 2 incorrecto';
            } elseif (!$serie->setFechaHora($_POST['fechaHora'])) {
                $result['exception'] = 'Fecha y hora incorrectas';
            } elseif (!$serie->setIdEstadoSerie($_POST['estadoSerie'])) {
                $result['exception'] = 'Estado de la serie incorrecto';
            } elseif ($serie->updateRow()) {
                $result['status'] = 1;
                $result['message'] = 'Serie modificado correctamente';
            } else {
                $result['exception'] = Database::getException();
            }
            break;
        case 'delete':
            if (!$serie->setId($_POST['id'])) {
                $result['exception'] = 'Torneo incorrecto';
            } elseif (!$serie->readOne()) {
                $result['exception'] = 'Torneo inexistente';
            } elseif ($serie->deleteRow()) {
                $result['status'] = 1;
                $result['message'] = 'Serie eliminado correctamente';
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
