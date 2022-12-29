<?php
session_start();
include '../../autoload.php';
require_once '../header.php';
?>
<div id="error_404" class="container">
    <div class="d-flex justify-content-center contenido">
        <div class="brand_logo_container">
            <a class="link-404-logo" href="../../index.php">
                <span class="logo-naranja">Inventory</span><span class="logo-rojo">Manager</span>
            </a>
        </div>
        <p class="text-comicbook">Error 404</p>
        <a class="text-comicbook" href="../../index.php">Volver a la página principal</a>
        <img src="../../images/404.png" class="error" alt="Imagen error 404" title="Imagen error 404">
    </div>
</div>

<?php
require_once '../footer.php';
?>
