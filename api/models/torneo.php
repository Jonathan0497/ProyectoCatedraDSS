<?php
/*
*	Clase para manejar la tabla usuarios de la base de datos.
*   Es clase hija de Validator.
*/
class Torneo extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $nombres = null;
    private $direccion = null;
    private $oblNivelHabilidad = null;
    private $idNivelHabilidad = null;
    private $maxJugadores = null;
    private $fechaInicio = null;
    private $idEstadoTorneo = null;
    private $idTipoTorneo = null;
    private $idUsuario = null;
    private $idFormatoPartido = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombres($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->nombres = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setOblNivelHabilidad($value)
    {
        if ($this->validateBoolean($value)) {
            $this->oblNivelHabilidad = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setMaxJugadores($value)
    {
        if ($this->validateBoolean($value)) {
            $this->maxJugadores = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaInicio($value)
    {
        if ($this->validateDate($value)) {
            $this->fechaInicio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdEstadoTorneo($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->idEstadoTorneo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdTipoTorneo($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->idTipoTorneo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdUsuario($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->idUsuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdFormatoPartido($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->idFormatoPartido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccion($value)
    {
        if ($this->validateString($value, 1, 200)) {
            $this->direccion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdNivelHabilidad($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->idNivelHabilidad = $value;
            return true;
        } else {
            return false;
        }
    }


    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id;
    }

    public function getNombres()
    {
        return $this->nombres;
    }


    public function getOblNivelHabilidad()
    {
        return $this->oblNivelHabilidad;
    }

    public function getMaxJugadores()
    {
        return $this->maxJugadores;
    }

    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    public function getIdEstadoTorneo()
    {
        return $this->idEstadoTorneo;
    }

    public function getIdTipoTorneo()
    {
        return $this->idTipoTorneo;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function getIdFormatoPartido()
    {
        return $this->idFormatoPartido;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getIdNivelHabilidad()
    {
        return $this->idNivelHabilidad;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT id_usuario, nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario
                FROM usuarios
                WHERE apellidos_usuario ILIKE ? OR nombres_usuario ILIKE ?
                ORDER BY apellidos_usuario';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO torneo(nombre_torneo, direccion, maxJugadores, obl_nivelHabilidad, id_estadoTorneo, id_tipoTorneo, id_usuario, id_formatoPartido, fechaInicio, id_nivelHabilidad)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombres, $this->direccion, $this->maxJugadores, $this->oblNivelHabilidad, $this->idEstadoTorneo, $this->idTipoTorneo, $this->idUsuario, $this->idFormatoPartido, $this->fechaInicio, $this->idNivelHabilidad);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_torneo, nombre_torneo, direccion, maxJugadores, obl_nivelHabilidad, id_estadoTorneo, id_tipoTorneo, id_usuario, id_formatoPartido, fechaInicio, id_nivelHabilidad
                FROM torneo';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_torneo, nombre_torneo, direccion, maxJugadores, obl_nivelHabilidad, id_estadoTorneo, id_tipoTorneo, id_usuario, id_formatoPartido, fechaInicio, id_nivelHabilidad
                FROM torneo
                WHERE id_torneo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE torneo 
                SET nombre_torneo = ?, direccion = ?, maxJugadores = ?, obl_nivelHabilidad = ?, id_estadoTorneo = ?, id_tipoTorneo = ?, id_usuario = ?, id_formatoPartido = ?, fechaInicio = ?, id_nivelHabilidad = ?
                WHERE id_torneo = ?';
        $params = array($this->nombres, $this->direccion, $this->maxJugadores, $this->oblNivelHabilidad, $this->idEstadoTorneo, $this->idTipoTorneo, $this->idUsuario, $this->idFormatoPartido, $this->fechaInicio, $this->idNivelHabilidad, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM torneo
                WHERE id_torneo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
?>