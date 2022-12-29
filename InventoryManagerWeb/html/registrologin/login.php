<?php
require_once '../../classes/registrologin/login.php';
require_once '../header_login.php';

if (isset($blank) and $blank == true) {
    ?>
    <script type="text/javascript">
        function blankLogin() {
            $.growl.warning({title: "Aviso!", message: "Rellene ambos campos"});
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', blankLogin);
        } else {
            blankLogin();
        }
    </script>
    <?php
}

if (isset($err) and $err == true) {
    ?>
    <script type="text/javascript">
        function errorLogin() {
            $.growl.error({message: "Revise usuario y contraseña"});
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', errorLogin);
        } else {
            errorLogin();
        }
    </script>
    <?php
}
?>

<div id="login" class="container">
    <div class="d-flex justify-content-center">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                <div class="brand_logo_container">
                    <a class="link-login-logo" href="../../index.php">
                        <span class="logo-naranja">Inventory</span><span class="logo-rojo">Manager</span>
                    </a>
                </div>
            </div>
            <div class="d-flex flex-column justify-content-center form_container">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text user-icon">
                                <img src="../../images/icons/person.svg" alt="icono usuario" tile="icono usuario">
                            </span>
                        </div>
                        <input type="email" name="email" class="form-control" placeholder="Correo Electrónico">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text key-icon">
                                <img src="../../images/icons/key.svg" alt="icono llave" title="icono llave">
                            </span>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="Contraseña">
                    </div>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button type="submit" name="Login" class="btn login_btn">Iniciar Sesión</button>
                    </div>
                </form>
            </div>
            <div class="d-flex justify-content-center create-account-container">
                <span>¿No tienes cuenta? </span> 
                <a href="signup.php" class="create-account">Crear Cuenta</a>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../footer.php';
?>