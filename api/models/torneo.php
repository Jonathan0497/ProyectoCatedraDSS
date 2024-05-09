<?php
/*
*   Clase para manejar la tabla torneo de la base de datos.
*   Es clase hija de Validator.
*/
class Torneo extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $nombre_torneo = null;
    private $direccion = null;
    private $maxJugadores = null;
    private $fechaInicio = null;
    private $idEstadoTorneo = null;
    private $idTipoTorneo = null;
    private $idUsuario = null;
    private $idFormatoPartido = null;
    private $idNivelHabilidad = null;  // Asegúrate de que este campo pueda ser opcional

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

    public function setNombreTorneo($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->nombre_torneo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setMaxJugadores($value)
    {
        if ($this->validateNaturalNumber($value)) {
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

    public function getNombreTorneo()
    {
        return $this->nombre_torneo;
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
        $sql = 'INSERT INTO torneo (nombre_torneo, direccion, id_estadoTorneo, id_tipoTorneo, id_usuario, id_formatoPartido, fechaInicio, id_nivelHabilidad)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre_torneo, $this->direccion, $this->idEstadoTorneo, $this->idTipoTorneo, $this->idUsuario, $this->idFormatoPartido, $this->fechaInicio, $this->idNivelHabilidad);
        return Database::executeRow($sql, $params);
    }


    public function readAll()
    {
        $sql = 'SELECT t.id_torneo, t.nombre_torneo, t.direccion, t.maxjugadores, t.fechaInicio, nh.nivelHabilidad AS NivelHabilidad, fp.descripcion AS FormatoPartido, et.estadoTorneo AS EstadoTorneo
            FROM torneo t
            INNER JOIN formatopartido fp ON t.id_formatoPartido = fp.id_formatoPartido
            LEFT JOIN nivelhabilidad nh ON t.id_nivelHabilidad = nh.id_nivelHabilidad
            INNER JOIN estadotorneo et ON t.id_estadoTorneo = et.id_estadoTorneo';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readNivelHabilidad()
    {
        $sql = 'SELECT id_nivelHabilidad, nivelHabilidad
            FROM nivelhabilidad';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readFormatoPartido()
    {
        $sql = 'SELECT id_formatoPartido, descripcion
            FROM formatopartido';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readEstadoTorneo()
    {
        $sql = 'SELECT id_estadoTorneo, estadoTorneo
            FROM estadotorneo';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readTipoTorneo()
    {
        $sql = 'SELECT id_tipoTorneo, tipotorneo FROM tipotorneo';
        $params = null;
        return Database::getRows($sql, $params);
    }


    public function readOne()
    {
        $sql = 'SELECT id_torneo, nombre_torneo, direccion, maxJugadores, id_estadoTorneo, id_tipoTorneo, id_usuario, id_formatoPartido, fechaInicio, id_nivelHabilidad
            FROM torneo
            WHERE id_torneo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }


    public function updateRow()
    {
        $sql = 'UPDATE torneo
            SET nombre_torneo = ?, direccion = ?, id_estadoTorneo = ?, id_tipoTorneo = ?, id_usuario = ?, id_formatoPartido = ?, fechaInicio = ?, id_nivelHabilidad = ?
            WHERE id_torneo = ?';
        $params = array($this->nombre_torneo, $this->direccion, $this->idEstadoTorneo, $this->idTipoTorneo, $this->idUsuario, $this->idFormatoPartido, $this->fechaInicio, $this->idNivelHabilidad, $this->id);
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
