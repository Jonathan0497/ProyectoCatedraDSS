<?php
/*
*	Clase para manejar la tabla usuarios de la base de datos.
*   Es clase hija de Validator.
*/
class Serie extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $idTorneo = null;
    private $idJugador1 = null;
    private $idJugador2 = null;
    private $fechaHora = null;
    private $ganadorSerie = null;
    private $idestadoSerie = null;
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

    public function setIdTorneo($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->idTorneo = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setIdJugador1($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->idJugador1 = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdJugador2($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->idJugador2 = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaHora($value)
    {
        if ($this->validateDateTime($value)) {
            $this->fechaHora = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setGanadorSerie($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->ganadorSerie = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdEstadoSerie($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->idestadoSerie = $value;
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

    public function getIdTorneo()
    {
        return $this->idTorneo;
    }


    public function getIdJugador1()
    {
        return $this->idJugador1;
    }

    public function getIdJugador2()
    {
        return $this->idJugador2;
    }

    public function getFechaHora()
    {
        return $this->fechaHora;
    }

    public function getGanadorSerie()
    {
        return $this->ganadorSerie;
    }

    public function getIdEstadoSerie()
    {
        return $this->idestadoSerie;
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
        $sql = 'INSERT INTO serie(id_torneo, id_jugador1, id_jugador2, fechaHora, ganadorSerie, id_estadoSerie)
            VALUES(?, ?, ?, ?, ?, ?)';
        $params = array($this->idTorneo, $this->idJugador1, $this->idJugador2, $this->fechaHora, $this->ganadorSerie, $this->idestadoSerie);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_serie, id_torneo, id_jugador1, id_jugador2, fechaHora, ganadorSerie, id_estadoSerie
            FROM serie';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_serie, id_torneo, id_jugador1, id_jugador2, fechaHora, ganadorSerie, id_estadoSerie
            FROM serie
            WHERE id_serie = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE serie
            SET id_torneo = ?, id_jugador1 = ?, id_jugador2 = ?, fechaHora = ?, ganadorSerie = ?, id_estadoSerie = ?
            WHERE id_serie = ?';
        $params = array($this->idTorneo, $this->idJugador1, $this->idJugador2, $this->fechaHora, $this->ganadorSerie, $this->idestadoSerie, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM serie
            WHERE id_serie = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
