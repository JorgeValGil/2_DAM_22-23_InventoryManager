<?php

/**
 * Plugin Name: inventorymanager
 * Plugin URI: https://github.com/JorgeValGil/InventoryManagerWordPress
 * Description: Importa categorías y productos de InventoryManager
 * Version: 1.0
 * Author: Jorge Val Gil
 * Author URI: https://github.com/JorgeValGil
 */
defined('ABSPATH') or die("Bye bye");

define('INVENTORYMANAGER_PLUGIN_RUTA', plugin_dir_path(__FILE__));
define('INVENTORYMANAGER_PLUGIN_NOMBRE', 'inventorymanager');

include(INVENTORYMANAGER_PLUGIN_RUTA . '/includes/options.php');
?>