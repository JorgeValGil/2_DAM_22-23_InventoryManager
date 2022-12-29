<?php
session_start();
session_destroy();
require_once '../header_login.php';
?>

<div id="logout" class="container">
    <div class="d-flex justify-content-center">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                <div class="brand_logo_container">
                    <a class="link-logout-logo" href="../../index.php">
                        <span class="logo-naranja">Inventory</span><span class="logo-rojo">Manager</span>
                    </a>
                </div>
            </div>
            <div class="d-flex flex-column justify-content-center contenido">
                <p>La sesión se ha cerrado correctamente, nos vemos pronto</p>
                <p>Redirigiendo a la página principal</p>
                <img src="../../images/loading.gif" alt="imagen de cargando" title="imagen de cargando"/>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../footer.php';
header("Refresh:2; url=../../index.php");
?>