<?php

namespace registrologin;

session_start();

include '../../autoload.php';

/*
 * Clase iniciar sesión
 */

class login {

    private $blank;
    private $err;

    /**
     * Constructor
     */
    public function __construct() {
        
    }

    public function __get($value) {
        return $this->$value;
    }

    /**
     * Iniciar sesión
     */
    function login() {
        if ($_POST['email'] == '' || $_POST['password'] == '') {
            $this->blank = true;
        } else {
            $function = new \db\Functions();
            $usu = $function->comprobar_usuario($_POST['email'], $_POST['password']);
            if ($usu === false) {
                $this->err = true;
            } else {
                $_SESSION['id_user'] = $usu[0];
                $_SESSION['usuario'] = $usu[1];

                header("Location: ../../index.php");
            }
        }
    }

}

//Formulario iniciar sesión
if (isset($_POST['Login'])) {
    $login = new \registrologin\login();
    $login->login();
    $blank = $login->blank;
    $err = $login->err;
}

//Si no hay una sesión de usuario activa, se redirecciona
if (isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
}
?>
