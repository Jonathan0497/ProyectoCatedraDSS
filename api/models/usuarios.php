<?php
class Usuarios extends Validator
{
    // Declaración de atributos (propiedades).
    private $id_usuario = null;
    private $nombre_usuario = null;
    private $apellido_usuario = null;
    private $usuario = null;
    private $correo = null;
    private $clave = null;
    private $telefono = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombreUsuario($value)
    {
        if ($this->validateAlphanumeric($value, 1, 150)) {
            $this->nombre_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setApellidoUsuario($value)
    {
        if ($this->validateAlphanumeric($value, 1, 150)) {
            $this->apellido_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setUsuario($value)
    {
        if ($this->validateAlphanumeric($value, 1, 150)) {
            $this->usuario = $value;
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

    public function setClave($value)
    {
        if ($this->validatePassword($value)) {
            $this->clave = password_hash($value, PASSWORD_DEFAULT);
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

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id_usuario;
    }

    public function getNombreUsuario()
    {
        return $this->nombre_usuario;
    }

    public function getApellidoUsuario()
    {
        return $this->apellido_usuario;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    //Operaciones de gestion de usuarios
    public function checkUser($usuarios)
    {
        $sql = 'SELECT id_usuario FROM usuarios WHERE alias_usuario = ?';
        $params = array($usuarios);
        if ($data = database::getRow($sql, $params)) {
            $this->id_usuario = $data['id_usuario'];
            $this->usuario = $usuarios;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave FROM usuarios WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['clave'])) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE usuarios SET clave = ? WHERE id_usuario = ?';
        $params = array($this->clave, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo, alias_usuario, telefono
                FROM usuarios
                WHERE id_usuario = ?';
        $params = array($_SESSION['id_usuario']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE usuarios
                SET nombre_usuario = ?, apellido_usuario = ?, correo = ?, telefono = ?
                WHERE id_usuario = ?';
        $params = array($this->nombre_usuario, $this->apellido_usuario, $this->correo, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    // Métodos para manejar la operaciones CRUD
    public function createRow()
    {
        $sql = 'INSERT INTO usuarios(nombre_usuario, apellido_usuario, 	alias_usuario, correo, clave, telefono)
                VALUES(?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre_usuario, $this->apellido_usuario, $this->usuario, $this->correo, $this->clave, $this->telefono);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, alias_usuario, correo, clave, telefono FROM usuarios';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, alias_usuario, correo, clave, telefono FROM usuarios WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE usuarios SET nombre_usuario = ?, apellido_usuario = ?, alias_usuario = ?, correo = ?, clave = ?, telefono = ? WHERE id_usuario = ?';
        $params = array($this->nombre_usuario, $this->apellido_usuario, $this->usuario, $this->correo, $this->clave, $this->telefono, $this->id_usuario);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM usuarios WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        return Database::executeRow($sql, $params);
    }

    // Aquí puedes agregar otros métodos que necesites para tu lógica de negocio.

}
?>