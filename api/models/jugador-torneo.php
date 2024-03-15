<?php
class JugadorTorneo extends Validator
{
    // Declaración de atributos (propiedades).
    private $idJugadorTorneo = null;
    private $idJugador = null;
    private $idTorneo = null;
    
    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->idJugadorTorneo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdJugador($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->idJugador = $value;
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
    
    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->idJugadorTorneo;
    }

    public function getIdJugador()
    {
        return $this->idJugador;
    }

    public function getIdTorneo()
    {
        return $this->idTorneo;
    }

    // Aquí irían los demás métodos que interactúan con la base de datos.
    
    public function createRow()
    {
        $sql = 'INSERT INTO jugador_torneo(id_jugador, id_torneo)
                VALUES(?, ?)';
        $params = array($this->idJugador, $this->idTorneo);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_jugadorTorneo, id_jugador, id_torneo
                FROM jugador_torneo';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_jugadorTorneo, id_jugador, id_torneo
                FROM jugador_torneo
                WHERE id_jugadorTorneo = ?';
        $params = array($this->idJugadorTorneo);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE jugador_torneo
                SET id_jugador = ?, id_torneo = ?
                WHERE id_jugadorTorneo = ?';
        $params = array($this->idJugador, $this->idTorneo, $this->idJugadorTorneo);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM jugador_torneo
                WHERE id_jugadorTorneo = ?';
        $params = array($this->idJugadorTorneo);
        return Database::executeRow($sql, $params);
    }

}
?>