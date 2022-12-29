<?php

namespace registrologin;

session_start();

include '../../autoload.php';

/**
 * Clase darse de alta
 */
class signup {

    private $newaccountblank;
    private $email_error;
    private $password_error;

    /**
     * Constructor
     */
    public function __construct() {
        
    }

    public function __get($value) {
        return $this->$value;
    }

    /**
     * Crear cuenta de usuario
     */
    function create() {
        if ($_POST['email'] == '' || $_POST['password'] == '' || $_POST['password1'] == '') {
            $this->newaccountblank = true;
        } else {
            $function = new \db\Functions();
            $email = $function->comprobar_email(array($_POST['email']));
            if ($email === false) {
                $this->email_error = true;
            }
            $password = false;
            if ($_POST['password'] === $_POST['password1']) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
            if ($password === false) {
                $this->password_error = true;
            }
            if (!isset($this->password_error) && !isset($this->email_error)) {
                $datos_usuario = array($_POST['email'], $password);
                $added = $function->anadir_usuario($datos_usuario);
                if ($added) {
                    $user = $function->comprobar_usuario($_POST['email'], $_POST['password']);
                    $_SESSION['id_user'] = $user[0];
                    $_SESSION['usuario'] = $user[1];
                    header("Location: ../../index.php?created");
                }
            }
        }
    }

}

//Formulario crear cuenta
if (isset($_POST['SignUp'])) {
    $create = new \registrologin\signup();
    $create->create();
    $newaccountblank = $create->newaccountblank;
    $email_error = $create->email_error;
    $password_error = $create->password_error;
}

//Si no hay una sesión de usuario activa, se redirecciona
if (isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
}
?>