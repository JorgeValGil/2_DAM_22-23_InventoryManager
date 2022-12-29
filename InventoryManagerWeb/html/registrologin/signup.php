<?php
require_once '../../classes/registrologin/signup.php';
require_once '../header_login.php';

if (isset($newaccountblank) and $newaccountblank == true) {
    ?>
    <script type="text/javascript">
        function blankNewAccount() {
            $.growl.warning({title: "Aviso!", message: "Rellena todos los campos"});
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', blankNewAccount);
        } else {
            blankNewAccount();
        }
    </script>
    <?php
}

if (isset($password_error) and $password_error == true) {
    ?>
    <script type="text/javascript">
        function errorPassword() {
            $.growl.warning({title: "Aviso!", message: "Las contraseñas no coinciden"});
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', errorPassword);
        } else {
            errorPassword();
        }
    </script>
    <?php
}

if (isset($email_error) and $email_error == true) {
    ?>
    <script type="text/javascript">
        function errorEmail() {
            $.growl.error({message: "Email existente"});
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', errorEmail);
        } else {
            errorEmail();
        }
    </script>
    <?php
}
?>

<div id="signup" class="container">
    <div class="d-flex justify-content-center">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                <div class="brand_logo_container">
                    <a class="link-signup-logo" href="../../index.php">
                        <span class="logo-naranja">Inventory</span><span class="logo-rojo">Manager</span>
                    </a>
                </div>
            </div>
            <div class="d-flex flex-column justify-content-center form_container">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text user-icon">
                                <img src="../../images/icons/person.svg" alt="icono usuario" title="icono usuario">
                            </span>
                        </div>
                        <input type="email" class="form-control" name="email" placeholder="Introducir email">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text key-icon">
                                <img src="../../images/icons/key.svg" alt="icono llave" title="icono llave">
                            </span>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="Contraseña">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text key-icon">
                                <img src="../../images/icons/key.svg" alt="icono llave" title="icono llave">
                            </span>
                        </div>
                        <input type="password" name="password1" class="form-control" placeholder="Confirmar Contraseña">
                    </div>
                    <div class="d-flex justify-content-center mt-3 signup_container">
                        <button type="submit" name="SignUp" class="btn signup_btn">Crear Cuenta</button>
                    </div>
                </form>
            </div>
            <div class="mt-4">
                <div class="d-flex justify-content-center go-to-login-container">
                    <span>¿Ya tienes cuenta? </span>
                    <a href="login.php" >Iniciar Sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
require_once '../footer.php';
?>