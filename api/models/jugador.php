<?php
/*
*	Clase para manejar la tabla usuarios de la base de datos.
*   Es clase hija de Validator.
*/
class Jugador extends Validator
{
    // Declaración de atributos (propiedades).
    private $id_jugador = null;
    private $nombre_jugador = null;
    private $edad = null;
    private $telefono = null;
    private $correo = null;
    private $id_nivelHabilidad = null;
    private $id_genero = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setIdJugador($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_jugador = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombreJugador($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->nombre_jugador = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEdad($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->edad = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefono($value)
    {
        if ($this->validatePhone($value)) {
            $this->telefono = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if ($this->validateEmail($value)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setIdNivelHabilidad($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_nivelHabilidad = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdGenero($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_genero = $value;
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
        return $this->id_jugador;
    }

    public function getNombres()
    {
        return $this->nombre_jugador;
    }

    public function getEdad()
    {
        return $this->edad;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getIdNivelHabilidad()
    {
        return $this->id_nivelHabilidad;
    }

    public function getIdGenero()
    {
        return $this->id_genero;
    }

    public function searchRows($value)
    {
        $sql = 'SELECT id_jugador, nombre_jugador, edad, telefono, correo, id_nivelHabilidad, id_genero
                FROM pingpong
                WHERE apellidos_usuario ILIKE ? OR nombres_usuario ILIKE ?
                ORDER BY apellidos_usuario';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO jugador(id_jugador, nombre_jugador, edad, telefono, correo, id_nivelHabilidad, id_genero)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->id_jugador, $this->nombre_jugador, $this->edad, $this->telefono, $this->correo, $this->id_nivelHabilidad, $this->id_genero);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_jugador, nombre_jugador, edad, telefono, correo, nivelhabilidad.nivelHabilidad, genero.genero
        FROM jugador
        INNER JOIN nivelhabilidad ON jugador.id_nivelHabilidad = nivelhabilidad.id_nivelHabilidad
        INNER JOIN genero ON jugador.id_genero = genero.id_genero';
        $params = null;
        return Database::getRows($sql, $params);
    }


    public function readAllNivelHabilidad()
    {
        $sql = 'SELECT id_nivelHabilidad, nivelHabilidad FROM nivelhabilidad';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readAllGenero()
    {
        $sql = 'SELECT id_genero, genero FROM genero';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_jugador, nombre_jugador, edad, telefono, correo, id_nivelHabilidad, id_genero FROM jugador
                WHERE id_jugador = ?';
        $params = array($this->id_jugador);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE jugador 
                SET nombre_jugador = ?, edad = ?, telefono = ?, correo = ?, id_nivelHabilidad = ?, id_genero = ?
                WHERE id_jugador = ?';
        $params = array($this->nombre_jugador, $this->edad, $this->telefono, $this->correo, $this->id_nivelHabilidad, $this->id_genero, $this->id_jugador);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM jugador
                WHERE id_jugador = ?';
        $params = array($this->id_jugador);
        return Database::executeRow($sql, $params);
    }
}
