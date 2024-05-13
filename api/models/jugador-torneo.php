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

    public function readAllJugadores()
    {
        $sql = 'SELECT 
        jugador.id_jugador, 
        jugador.nombre_jugador, 
        jugador.edad, 
        jugador.telefono, 
        jugador.correo, 
        nivelhabilidad.nivelHabilidad, 
        genero.genero
    FROM 
        jugador
    INNER JOIN 
        nivelhabilidad ON jugador.id_nivelHabilidad = nivelhabilidad.id_nivelHabilidad
    INNER JOIN 
        genero ON jugador.id_genero = genero.id_genero
    INNER JOIN 
        jugador_torneo ON jugador.id_jugador = jugador_torneo.id_jugador
    WHERE 
        jugador_torneo.id_torneo = ?';  
        $params = array($this->idTorneo);

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

    public function readOneId()
    {
        $sql = 'SELECT id_jugadorTorneo, id_jugador, id_torneo
                FROM jugador_torneo
                WHERE id_jugador = ? and id_torneo = ?';
        $params = array($this->idJugador, $this->idTorneo);
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
                WHERE id_jugador = ? and id_torneo = ?';
        $params = array($this->idJugadorTorneo, $this->idTorneo);
        return Database::executeRow($sql, $params);
    }

}
?>