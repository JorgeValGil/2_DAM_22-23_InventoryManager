<?php

defined('ABSPATH') or die("Bye bye");

require('InventoryManagerCsv.php');

if (!current_user_can('manage_options')) {
    wp_die(__('No tienes suficientes permisos para acceder a esta p&aacute;gina.'));
}

//Formulario para subir los archivos categories.csv y products.csv
$form = '<h2>Importar categor&iacute;as Inventory Manager</h2>';
$form .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post" enctype="multipart/form-data">';
$form .= '<div><label for="categories">Selecciona el archivo de categor&iacute;as:</label>';
$form .= '<div><input type="file" accept=".csv" name="categories"></div></div>';
$form .= '<label for="products">Selecciona el archivo de productos:</label>';
$form .= '<div><input type="file" accept=".csv" name="products"></div>';
$form .= '<button name="Procesar" type="submit">Procesar</button>';
$form .= '</form>';

echo $form;
?>

<?php

//Se comprueba que se pulsa el botón procesar
if (isset($_POST['Procesar'])) {

    //Contador de categorias procesadas
    $categories = 0;
    //Contador de productos procesados
    $products = 0;
    //Error
    $error = '';

    //Se comprueba que el usuario seleccionara dos archivos
    if (isset($_FILES['categories']) && $_FILES['categories']['name'] != '' && isset($_FILES['products']) && $_FILES['products']['name'] != '') {
        $file_categories_name = $_FILES['categories']['name'];
        $file_products_name = $_FILES['products']['name'];
        //Se comprueba que el usuario seleccionara los archivos categories.csv y products.csv
        if ($file_categories_name == "categories.csv" && $file_products_name == "products.csv") {
            $file_categories = $_FILES['categories']['tmp_name'];
            $file_products = $_FILES['products']['tmp_name'];
            //Se procesan las categorias
            $categories = InventoryManagerCsv::categories($file_categories);
            //Se procesan los productos
            $products = InventoryManagerCsv::products($file_products);
        } else {
            $error = 'name';
        }
    } else {
        $error = 'file';
    }

    //Mensajes de error o confirmación
    switch ($error) {
        case 'file':
            echo '<p style="color:red;">Seleccione los dos ficheros para procesar</p>';
            break;
        case 'name':
            echo '<p style="color:red;">Debe de seleccionar los ficheros descargados de Inventory Manager</p>';
            break;
        default:
            echo '<p style="color:green;">Procesadas ' . $categories . ' categor&iacute;as.</p>';
            echo '<p style="color:green;">Procesados ' . $products . ' productos.</p>';
    }
}
?>