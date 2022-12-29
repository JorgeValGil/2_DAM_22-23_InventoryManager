<?php
require_once '../../classes/extras/extras.php';
require_once '../header.php';

$extras = new \extras\extras();
$extras->csvProducts();
$extras->csvCategories();
?>


<div id="extras" class="row">
    <div class="col-xs-12 col-md-6 general categories" data-target="categories.csv">
        <a href="categories.csv" class="general-title">Descargar fichero de exportación de Categorías</a>
    </div>
    <div class="col-xs-12 col-md-6 general products" data-target="products.csv">
        <a href="products.csv" class="general-title">Descargar fichero de exportación de Productos</a>
    </div>
    <div class="col-xs-12 col-md-6 general prestashop" data-target="prestashop/inventorymanager.zip">
        <a href="prestashop/inventorymanager.zip" class="general-title">Descargar módulo de importación para Prestashop</a>
    </div>
    <div class="col-xs-12 col-md-6 general wordpress" data-target="wordpress/inventorymanager.zip">
        <a href="wordpress/inventorymanager.zip" class="general-title">Descargar plugin de importación para Wordpress</a>
    </div>
</div>
<iframe id="iframe_extras" style="display:none;"></iframe>
<?php
require_once '../footer.php';
?>