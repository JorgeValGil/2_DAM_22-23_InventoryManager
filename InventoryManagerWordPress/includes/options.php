<?php

defined('ABSPATH') or die("Bye bye");

add_action('admin_menu', 'menu_admin_inventorymanager');

function menu_admin_inventorymanager() {
    add_menu_page(INVENTORYMANAGER_PLUGIN_NOMBRE, INVENTORYMANAGER_PLUGIN_NOMBRE, 'manage_options', INVENTORYMANAGER_PLUGIN_RUTA . '/includes/configuracion.php');
    add_options_page(INVENTORYMANAGER_PLUGIN_NOMBRE, INVENTORYMANAGER_PLUGIN_NOMBRE, 'manage_options', 'inventorymanager');
}

?>