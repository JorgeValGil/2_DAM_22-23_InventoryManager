<?php

namespace profile;

session_start();

include '../../autoload.php';

/**
 * Clase perfil
 */
class profile {

    private $blank;
    private $wrong;
    private $error;
    private $changed;

    /**
     * Constructor
     */
    public function __construct() {
        
    }

    public function __get($value) {
        return $this->$value;
    }

    /**
     * Cambia la contraseña de un usuario
     */
    function changePassword() {
        if ($_POST['password'] == '' || $_POST['password1'] == '' || $_POST['password2'] == '') {
            $this->blank = true;
        } else {
            if ($_POST['password1'] == $_POST['password2']) {
                $id_user = $_SESSION['id_user'];
                $function = new \db\Functions();
                $password = $function->get_password($id_user);
                if ($password) {
                    if (password_verify($_POST['password'], $password)) {
                        $new_pass = password_hash($_POST['password1'], PASSWORD_DEFAULT);
                        $data = array($new_pass, $id_user);
                        if ($function->update_password($data)) {
                            $this->changed = true;
                        }
                    } else {
                        $this->error = true;
                    }
                }
            } else {
                $this->wrong = true;
            }
        }
    }

}

//Si no hay una sesión de usuario activa, se redirecciona
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../html/registrologin/login.php");
}

//Formulario cambio de contraseña
if (isset($_POST['ChangePassword'])) {
    $password = new \profile\profile();
    $password->changePassword();
    $blank = $password->blank;
    $error = $password->error;
    $wrong = $password->wrong;
    $changed = $password->changed;
}
?>
