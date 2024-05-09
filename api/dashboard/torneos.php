<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/torneo.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $torneo = new Torneo();
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);

    // Se comprueba si hay una sesión activa y se recupera el nombre del usuario actual.
    if (isset($_SESSION['id_usuario'])) {

        $result['session'] = 1; // Simula una sesión activa para todos los casos

        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $torneo->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readNivelHabilidad':
                if ($result['dataset'] = $torneo->readNivelHabilidad()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readEstadoTorneo':
                if ($result['dataset'] = $torneo->readEstadoTorneo()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readTipoTorneo':
                if ($result['dataset'] = $torneo->readTipoTorneo()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readFormatoPartido':
                if ($result['dataset'] = $torneo->readFormatoPartido()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = $torneo->validateForm($_POST);
                if (empty($_POST['search'])) {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $torneo->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = $torneo->validateForm($_POST);
                if (!$torneo->setNombreTorneo($_POST['nombre_torneo'])) {
                    $result['exception'] = 'Nombre de torneo incorrecto';
                } elseif (!$torneo->setIdNivelHabilidad($_POST['idNivelHabilidad'])) {
                    $result['exception'] = 'Nivel de habilidad incorrecto';
                } elseif (!$torneo->setFechaInicio($_POST['fechaInicio'])) {
                    $result['exception'] = 'Fecha de inicio incorrecta';
                } elseif (!$torneo->setIdEstadoTorneo($_POST['idEstadoTorneo'])) {
                    $result['exception'] = 'Estado de torneo incorrecto';
                } elseif (!$torneo->setIdTipoTorneo($_POST['idTipoTorneo'])) {
                    $result['exception'] = 'Tipo de torneo incorrecto';
                } elseif (!$torneo->setIdUsuario($_SESSION['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$torneo->setIdFormatoPartido($_POST['idFormatoPartido'])) {
                    $result['exception'] = 'Formato de partido incorrecto';
                } elseif (!$torneo->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Dirección incorrecta';
                } elseif ($torneo->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Torneo creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$torneo->setId($_POST['id'])) {
                    $result['exception'] = 'Identificador de torneo incorrecto';
                } elseif ($result['dataset'] = $torneo->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Torneo inexistente';
                }
                break;
            case 'update':
                $_POST = $torneo->validateForm($_POST);
                if (!$torneo->setId($_POST['id'])) {
                    $result['exception'] = 'Identificador de torneo incorrecto';
                } elseif (!$torneo->readOne()) {
                    $result['exception'] = 'Torneo inexistente';
                } elseif (!$torneo->setNombreTorneo($_POST['nombre_torneo'])) {
                    $result['exception'] = 'Nombre de torneo incorrecto';
                } elseif (!$torneo->setIdNivelHabilidad($_POST['idNivelHabilidad'])) {
                    $result['exception'] = 'Nivel de habilidad incorrecto';
                } elseif (!$torneo->setFechaInicio($_POST['fechaInicio'])) {
                    $result['exception'] = 'Fecha de inicio incorrecta';
                } elseif (!$torneo->setIdEstadoTorneo($_POST['idEstadoTorneo'])) {
                    $result['exception'] = 'Estado de torneo incorrecto';
                } elseif (!$torneo->setIdTipoTorneo($_POST['idTipoTorneo'])) {
                    $result['exception'] = 'Tipo de torneo incorrecto';
                } elseif (!$torneo->setIdUsuario($_POST['idUsuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$torneo->setIdFormatoPartido($_POST['idFormatoPartido'])) {
                    $result['exception'] = 'Formato de partido incorrecto';
                } elseif (!$torneo->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Dirección incorrecta';
                } elseif ($torneo->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Torneo actualizado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$torneo->setId($_POST['id'])) {
                    $result['exception'] = 'Identificador de torneo incorrecto';
                } elseif (!$torneo->readOne()) {
                    $result['exception'] = 'Torneo inexistente';
                } elseif ($torneo->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Torneo eliminado correctamente';
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
        print(json_encode('Acción no disponible'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
