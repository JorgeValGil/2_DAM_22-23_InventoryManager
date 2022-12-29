<?php

namespace extras;

session_start();

include '../../autoload.php';

/**
 * Clase extras
 */
class extras {

    /**
     * Constructor
     */
    public function __construct() {
        
    }

    /**
     * Crea el archivo CSV con los productos
     */
    function csvProducts() {
        $function = new \db\Functions();
        $products = $function->get_products();

        $data = array(
            array('category', 'ref', 'name', 'description', 'units', 'price', 'image')
        );

        foreach ($products as $product) {
            $category = $function->get_product_category_name($product['id_category']);
            $data_product = array($category, $product['ref'], $product['name'], $product['description'], $product['units'], $product['price'], 'http://localhost/inventorymanagerweb/images/products/' . $product['image']);
            array_push($data, $data_product);
        }

        $fp = fopen('products.csv', 'w');
        fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
        foreach ($data as $fields) {
            fputcsv($fp, $fields, ';');
        }
        fclose($fp);
    }

    /**
     * Crea el archivo CSV con las categorías
     */
    function csvCategories() {
        $function = new \db\Functions();
        $categories = $function->get_categories();

        $data = array(
            array('name', 'description', 'image')
        );

        foreach ($categories as $category) {
            $data_category = array($category['name'], $category['description'], 'http://localhost/inventorymanagerweb/images/categories/' . $category['image']);
            array_push($data, $data_category);
        }

        $fp = fopen('categories.csv', 'w');
        fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
        foreach ($data as $fields) {
            fputcsv($fp, $fields, ';');
        }
        fclose($fp);
    }

}

//Si no hay una sesión de usuario activa, se redirecciona
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
}
?>
