<?php
session_start();
include 'autoload.php';

if (isset($_GET['created'])) {
    ?>
    <script type="text/javascript">
        function accountCreated() {
            $.growl.notice({title: "Cuenta Creada!", message: ""});
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', accountCreated);
        } else {
            accountCreated();
        }
    </script>
    <?php
}

if (isset($_SESSION['usuario'])) {
    require_once './html/header_index.php';
    ?>
    <div id="index" class="row">
        <div class="col-xs-12 col-md-6 general categories" data-target="html/categories/categories.php">
            <a href="html/categories/categories.php" class="general-title">Categorías</a>
        </div>
        <div class="col-xs-12 col-md-6 general products" data-target="html/products/products.php">
            <a href="html/products/products.php" class="general-title">Productos</a>
        </div>
        <div class="col-xs-12 col-md-6 general export" data-target="html/extras/extras.php">
            <a href="html/extras/extras.php" class="general-title">Extras</a>
        </div>
        <div class="col-xs-12 col-md-6 general profile" data-target="html/profile/profile.php">
            <a href="html/profile/profile.php" class="general-title">Perfil</a>
        </div>
    </div>

    <?php
    require_once './html/footer_index.php';
} else {
    header("Location: html/registrologin/login.php");
}
?>
