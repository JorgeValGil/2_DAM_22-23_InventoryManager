<?php
require_once '../../classes/profile/profile.php';
require_once '../header.php';

$prof = new \profile\profile();
?>
<div id="profile" class="container">
    <?php
    if (isset($blank) and $blank == true) {
        ?>
        <script type="text/javascript">
            function blankPassword() {
                $.growl.warning({title: "Aviso!", message: "Rellene todos los campos"});
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', blankPassword);
            } else {
                blankPassword();
            }
        </script>
        <?php
    }
    if (isset($wrong) and $wrong == true) {
        ?>
        <script type="text/javascript">
            function wrongPassword() {
                $.growl.warning({title: "Aviso!", message: "Las nuevas contraseñas deben coincidir"});
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', wrongPassword);
            } else {
                wrongPassword();
            }
        </script>
        <?php
    }
    if (isset($error) and $error == true) {
        ?>
        <script type="text/javascript">
            function errorPassword() {
                $.growl.error({message: "Los datos no son correctos"});
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', errorPassword);
            } else {
                errorPassword();
            }
        </script>
        <?php
    }
    if (isset($changed) and $changed == true) {
        ?>
        <script type="text/javascript">
            function passwordChanged() {
                $.growl.notice({title: "Cambio de contraseña!", message: "Contraseña modificada correctamente."});
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', passwordChanged);
            } else {
                passwordChanged();
            }
        </script>
        <?php
    }
    ?>
    <div class="d-flex flex-column justify-content-center form_container">
        <h1 class="display-6">Modificar Contraseña</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">
            <div class="input-group mb-2">
                <div class="input-group-append">
                    <span class="input-group-text key-icon-red">
                        <img src="../../images/icons/key.svg" alt="icono llave" title="icono llave">
                    </span>
                </div>
                <input type="password" class="form-control" name="password" placeholder="Introducir Contraseña Actual">
            </div>
            <div class="input-group mb-2">
                <div class="input-group-append">
                    <span class="input-group-text key-icon">
                        <img src="../../images/icons/key.svg" alt="icono llave" title="icono llave">
                    </span>
                </div>
                <input type="password" name="password1" class="form-control" placeholder="Contraseña Nueva">
            </div>
            <div class="input-group mb-2">
                <div class="input-group-append">
                    <span class="input-group-text key-icon">
                        <img src="../../images/icons/key.svg" alt="icono llave" title="icono llave">
                    </span>
                </div>
                <input type="password" name="password2" class="form-control" placeholder="Confirmar Contraseña Nueva">
            </div>
            <div class="d-flex justify-content-center mt-3 signup_container">
                <button type="submit" name="ChangePassword" class="btn change_password_btn">Cambiar Contraseña</button>
            </div>
        </form>
    </div>
</div>
<?php
require_once '../footer.php';
?>