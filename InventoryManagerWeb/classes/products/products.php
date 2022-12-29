<?php

namespace products;

session_start();

include '../../autoload.php';

/**
 * Clase productos
 */
class products {

    /**
     * Constructor
     */
    public function __construct() {
        
    }

    /**
     * Obtiene todos los productos
     * @return array productos
     */
    function getProducts() {
        $function = new \db\Functions();
        $products = $function->get_products();
        return $products;
    }

    /**
     * Obtiene un producto
     * @param int $id Id de producto
     * @return array datos de un producto
     */
    function getProduct($id) {
        $function = new \db\Functions();
        $product = $function->get_product($id);
        return $product;
    }

    /**
     * Obtiene los productos de una categoría
     * @param int $id id de categoría
     * @return array producto de una categoría
     */
    function getProductsCategory($id) {
        $function = new \db\Functions();
        $products = $function->get_products_category($id);
        return $products;
    }

    /**
     * Obtiene el nombre de la categoría de un producto
     * @param int $id Id de producto
     * @return string nombre de categoría
     */
    function getproductCategoryName($id) {
        $function = new \db\Functions();
        $name = $function->get_product_category_name($id);
        return $name;
    }

}

//Si no hay una sesión de usuario activa, se redirecciona
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
}

//Formulario editar producto
if (isset($_POST['Editar_prod'])) {
    $name = $_POST['name'];
    $id_category = $_POST['categoria'];
    $ref = $_POST['ref'];
    $description = $_POST['description'];
    $units = $_POST['units'];
    $price = $_POST['price'];
    $id = $_POST['id'];
    //Se comprueba que nombre, referencia, precio, unidades y descripción tengan valor
    if (trim($name) != '' && trim($ref) != '' && trim($price) != '' && trim($units) != '' && trim($description) != '') {
        $data = array($name, $id_category, $ref, $description, $units, $price, $id);
        $function = new \db\Functions();
        //Se actualizan los datos del producto
        if ($function->update_product($data)) {
            if (isset($_FILES["imageProduct"])) {
                $filename = $_FILES["imageProduct"]["name"];
                $tempname = $_FILES["imageProduct"]["tmp_name"];
                $folder = "../../images/products/" . $filename;
                if (move_uploaded_file($tempname, $folder)) {
                    $data_image = array($filename, $id);
                    //Se actualiza la imagen de producto
                    $function->update_product_image($data_image);
                }
            }
            //Se redireciona a la sección de productos
            header("Location: ../../html/products/products.php");
        }
    }
}

//Formulario crear producto
if (isset($_POST['Crear_prod'])) {
    $name = $_POST['name'];
    $id_category = $_POST['categoria'];
    $ref = $_POST['ref'];
    $description = $_POST['description'];
    $units = $_POST['units'];
    $price = $_POST['price'];
    $filename = $_FILES["imageProduct"]["name"];
    $tempname = $_FILES["imageProduct"]["tmp_name"];
    $folder = "../../images/products/" . $filename;
    if (move_uploaded_file($tempname, $folder) && trim($name) != '' && trim($description) != '') {
        $data = array($name, $id_category, $ref, $description, $units, $price, $filename);
        $function = new \db\Functions();
        //Se crea el producto
        if ($function->create_product($data)) {
            //Se redireciona a la sección de productos
            header("Location: ../../html/products/products.php?created");
        }
    }
}

//Formulario borrar producto
if (isset($_POST['Borrar_prod'])) {
    $id = $_POST['producto'];
    if ($id != '0') {
        $function = new \db\Functions();
        //Se borra el producto
        if ($function->delete_product($id)) {
            //Se redireciona a la sección de productos
            header("Location: ../../html/products/products.php?deleted");
        }
    }
}
?>
