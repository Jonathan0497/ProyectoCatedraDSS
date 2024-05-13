<?php
/*
*	Clase para manejar la tabla usuarios de la base de datos.
*   Es clase hija de Validator.
*/
class Partidos extends Validator
{
    private $id_partidos = null;
    private $numeroPartido = null;
    private $id_serie = null;
    private $ganadorPartido = null;
    private $id_estadoPartido = null;

    public function setIdPartidos($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_partidos = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNumeroPartido($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->numeroPartido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdSerie($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_serie = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setGanadorPartido($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->ganadorPartido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdEstadoPartido($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_estadoPartido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getIdPartidos()
    {
        return $this->id_partidos;
    }

    public function getNumeroPartido()
    {
        return $this->numeroPartido;
    }

    public function getIdSerie()
    {
        return $this->id_serie;
    }

    public function getGanadorPartido()
    {
        return $this->ganadorPartido;
    }

    public function getIdEstadoPartido()
    {
        return $this->id_estadoPartido;
    }

    public function updatePartido()
    {
        $sql = 'UPDATE partidos SET ganadorPartido = ?, id_estadoPartido = ? WHERE id_partidos = ?';
        $params = array($this->ganadorPartido, 3, $this->id_partidos);
        return Database::executeRow($sql, $params);
    }

    public function readPartidos()
    {
        $sql = 'SELECT 
        p.id_partidos,
        p.numeroPartido,
        p.id_estadoPartido,
        s.id_torneo,
        s.id_jugador1,
        s.id_jugador2,
        j1.nombre_jugador AS nombre_jugador1,
        j2.nombre_jugador AS nombre_jugador2,
        t.nombre_torneo,
        t.direccion
    FROM 
        partidos p
    JOIN 
        serie s ON p.id_serie = s.id_serie
    JOIN 
        jugador j1 ON s.id_jugador1 = j1.id_jugador
    JOIN 
        jugador j2 ON s.id_jugador2 = j2.id_jugador
    JOIN 
        torneo t ON s.id_torneo = t.id_torneo 
    WHERE s.id_serie = ?';
        $params = array($this->id_serie);
        return Database::getRows($sql, $params);
    }

    public function readPartido()
    {
        $sql = 'SELECT 
        p.id_partidos,
        p.numeroPartido,
        p.id_estadoPartido,
        s.id_torneo,
        s.id_jugador1,
        s.id_jugador2,
        j1.nombre_jugador AS nombre_jugador1,
        j2.nombre_jugador AS nombre_jugador2,
        t.nombre_torneo,
        t.direccion
    FROM
        partidos p
    JOIN
        serie s ON p.id_serie = s.id_serie
    JOIN
        jugador j1 ON s.id_jugador1 = j1.id_jugador
    JOIN
        jugador j2 ON s.id_jugador2 = j2.id_jugador
    JOIN
        torneo t ON s.id_torneo = t.id_torneo
    WHERE id_partidos = ?';
        $params = array($this->id_partidos);
        return Database::getRow($sql, $params);
    }

    public function readJugadoresSerie()
    {
        $sql = 'SELECT 
        s.id_serie,
        s.id_torneo,
        j1.id_jugador AS id_jugador1,
        j1.nombre_jugador AS nombre_jugador1,
        j2.id_jugador AS id_jugador2,
        j2.nombre_jugador AS nombre_jugador2
    FROM 
        serie s
    JOIN 
        jugador j1 ON s.id_jugador1 = j1.id_jugador
    JOIN 
        jugador j2 ON s.id_jugador2 = j2.id_jugador
    WHERE
        s.id_serie = ?;';
        $params = array($this->id_serie);
        return Database::getRows($sql, $params);
    }
}
