<?php

namespace categories;

session_start();

include '../../autoload.php';

/**
 * Clase categories
 */
class categories {

    /**
     * Constructor
     */
    public function __construct() {
        
    }

    /**
     * Obtiene todas las categorías
     * @return array categorías
     */
    function getCategories() {
        $function = new \db\Functions();
        $categories = $function->get_categories();
        return $categories;
    }

    /**
     * Obtiene una categoría
     * @param int $id Id de categoría
     * @return array datos de una categoría
     */
    function getCategory($id) {
        $function = new \db\Functions();
        $category = $function->get_category($id);
        return $category;
    }

}

//Si no hay una sesión de usuario activa, se redirecciona
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
}

//Formulario editar categoría
if (isset($_POST['Editar_cat'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $id = $_POST['id'];
    //Se comprueba que nombre y descripción tengan valor
    if (trim($name) != '' && trim($description) != '') {
        $data = array($name, $description, $id);
        $function = new \db\Functions();
        //Se actualizan los datos de la categoría
        if ($function->update_category($data)) {
            //Se comprueba si se ha subido una imagen
            if (isset($_FILES["imageCategory"])) {
                $filename = $_FILES["imageCategory"]["name"];
                $tempname = $_FILES["imageCategory"]["tmp_name"];
                $folder = "../../images/categories/" . $filename;
                if (move_uploaded_file($tempname, $folder)) {
                    $data_image = array($filename, $id);
                    //Se actualiza la imagen la categoría
                    $function->update_category_image($data_image);
                }
            }
            //Se redireciona a la sección de categorías
            header("Location: ../../html/categories/categories.php");
        }
    }
}

//Formulario crear categoría
if (isset($_POST['Crear_cat'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $filename = $_FILES["imageCategory"]["name"];
    $tempname = $_FILES["imageCategory"]["tmp_name"];
    $folder = "../../images/categories/" . $filename;
    if (move_uploaded_file($tempname, $folder) && trim($name) != '' && trim($description) != '') {
        $data = array($name, $description, $filename);
        $function = new \db\Functions();
        //Se crea la categoría
        if ($function->create_category($data)) {
            //Se redireciona a la sección de categorías
            header("Location: ../../html/categories/categories.php?created");
        }
    }
}

//Formulario borrar categoría
if (isset($_POST['Borrar_cat'])) {
    $id = $_POST['categoria'];
    if ($id != '0') {
        $function = new \db\Functions();
        //Se borra la categoría
        if ($function->delete_category($id)) {
            //Se redireciona a la sección de categorías
            header("Location: ../../html/categories/categories.php?deleted");
        }
    }
}
?>
