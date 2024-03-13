<?php
require_once('../helpers/database.php');
require_once('../helpers/validator.php');
require_once('../models/torneo.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $torneo = new Torneo;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
        $result['session'] = 1;
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
            case 'search':
                $_POST = $torneo->validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $torneo->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valor encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = $torneo->validateForm($_POST);
                if (!$torneo->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$torneo->setOblNivelHabilidad($_POST['nivelHabilidad'])) {
                    $result['exception'] = 'Nivel de Habilidad obligatorio incorrecto';
                } elseif (!$torneo->setIdNivelHabilidad($_POST['idNivelHabilidad'])) {
                    $result['exception'] = 'Nivel de Habilidad incorrecto';
                } elseif (!$torneo->setMaxJugadores($_POST['maxJugadores'])) {
                    $result['exception'] = 'Maximo de Jugadores incorrecto';
                } elseif (!$torneo->setFechaInicio($_POST['fechaInicio'])) {
                    $result['exception'] = 'fecha de inicio incorrecta';
                } elseif (!$torneo->setIdEstadoTorneo($_POST['estadoTorneo'])) {
                    $result['exception'] = 'Estado de torneo incorrecto';
                } elseif (!$torneo->setIdTipoTorneo($_POST['tipoTorneo'])) {
                    $result['exception'] = 'Tipo de torneo incorrecto';
                } elseif (!$torneo->setIdFormatoPartido($_POST['formatoPartido'])) {
                    $result['exception'] = 'Formato partido incorrecto';
                } elseif (!$torneo->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'direccion incorrecto';
                } elseif ($torneo->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Torneo creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$torneo->setId($_POST['id'])) {
                    $result['exception'] = 'Torneo incorrecto';
                } elseif ($result['dataset'] = $torneo->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Torneo inexistente';
                }
                break;
            case 'update':
                $_POST = $usuario->validateForm($_POST);
                if (!$torneo->setId($_POST['id'])) {
                    $result['exception'] = 'Torneo incorrecto';
                } elseif (!$torneo->readOne()) {
                    $result['exception'] = 'Torneo inexistente';
                } elseif (!$torneo->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$torneo->setOblNivelHabilidad($_POST['nivelHabilidad'])) {
                    $result['exception'] = 'Nivel de Habilidad incorrecto';
                } elseif (!$torneo->setMaxJugadores($_POST['maxJugadores'])) {
                    $result['exception'] = 'Maximo de Jugadores incorrecto';
                } elseif (!$torneo->setFechaInicio($_POST['fechaInicio'])) {
                    $result['exception'] = 'fecha de inicio incorrecta';
                } elseif (!$torneo->setIdEstadoTorneo($_POST['estadoTorneo'])) {
                    $result['exception'] = 'Estado de torneo incorrecto';
                } elseif (!$torneo->setIdTipoTorneo($_POST['tipoTorneo'])) {
                    $result['exception'] = 'Tipo de torneo incorrecto';
                } elseif (!$torneo->setIdUsuario($_POST['idUsuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$torneo->setIdFormatoPartido($_POST['formatoPartido'])) {
                    $result['exception'] = 'Formato partido incorrecto';
                } elseif (!$torneo->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'direccion incorrecto';
                } elseif ($torneo->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Torneo modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$torneo->setId($_POST['id'])) {
                    $result['exception'] = 'Torneo incorrecto';
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
    print(json_encode('Recurso no disponible'));
}
?>