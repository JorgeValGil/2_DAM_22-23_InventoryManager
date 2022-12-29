<?php

require_once dirname(__FILE__) . '/ComunesInventoryManager.php';

if (!defined('_PS_VERSION_'))
    exit;

/**
 * 
 */
class InventoryManager extends Module {

    use ComunesInventoryManager;

    private $_html = '';

    /**
     * 
     */
    public function __construct() {
        $this->name = 'inventorymanager';
        $this->tab = 'administration';
        $this->version = '1.0';
        $this->author = 'Jorge Val Gil';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        parent::__construct();
        $this->displayName = $this->l('Inventory Manager');
        $this->description = $this->l('Importa categorías y productos de InventoryManager');
    }

    /**
     * 
     * @return boolean
     */
    public function install() {
        if (!parent::install())
            return false;

        if (!$this->installTab()) {
            $this->_errors[] = $this->l('Error al instalar el tab');
            return false;
        }

        return true;
    }

    /**
     * 
     * @return boolean
     */
    public function uninstall() {
        if (!parent::uninstall())
            return false;

        if (!$this->uninstallTab()) {
            $this->_errors[] = $this->l('Error al eliminar el tab');
            return false;
        }

        return true;
    }

    /**
     * 
     * @return type
     */
    public function getContent() {
        $this->addCSS('core.css');
        $this->_html .= $this->createHelpHeader();
        if (!empty($_POST)) {
            $this->_html .= $this->_postProcess();
        }
        $this->_displayForm();
        return $this->_html;
    }

    /**
     * 
     * @return type
     */
    private function _postProcess() {
        $accion = Tools::getValue("accion");
        $this->idTab = Tools::getValue("idTab");

        $html = "";
        switch ($accion) {
            //Procesado de categorías
            case 'categories':
                if (isset($_FILES['categories']) && $_FILES['categories']['error'] == 0) {
                    $categories_filename = $_FILES["categories"]["name"];
                    $categories_tempname = $_FILES["categories"]["tmp_name"];

                    $contexto = Context::getContext();

                    $categories_process = 0;
                    $categories_error = 0;

                    if (($handle = fopen($categories_tempname, 'r')) !== FALSE) {
                        $row = 0;
                        while (($data = fgetcsv($handle, null, ';')) !== FALSE) {
                            if ($row > 0) {

                                $name = $data[0];
                                $description = $data[1];
                                $image = $data[2];
                                $link_rewrite = Tools::link_rewrite($this->cleanName($name));
                                $categoria = new Category(0, $contexto->language->id, $contexto->shop->id);
                                $categoria->doNotRegenerateNTree = false;
                                $categoria->id_parent = Configuration::getGlobalValue('PS_HOME_CATEGORY');
                                $categoria->id_shop_default = Configuration::getGlobalValue('PS_SHOP_DEFAULT');
                                $categoria->groupBox = [];
                                $categoria->date_add = date('Y-m-d');
                                $categoria->date_upd = date('Y-m-d');
                                $categoria->active = true;
                                $categoria->description = $description;

                                $categoria->meta_description = $this->limitar_cadena($description, 512);
                                $categoria->meta_keywords = $this->limitar_cadena($name, 512);
                                $categoria->meta_title = $this->limitar_cadena($name, 512);
                                $categoria->name = array();
                                $categoria->link_rewrite = array();
                                $categoria->description = array();
                                foreach (Language::getLanguages(false) as $lang) {
                                    $categoria->name[$lang['id_lang']] = $name;
                                    $categoria->link_rewrite[$lang['id_lang']] = $link_rewrite;
                                    $categoria->description[$lang['id_lang']] = $description;
                                }
                                if ($categoria->add(false)) {
                                    $categories_process++;

                                    $id_inserted_category = $this->getLastInsertCategory();
                                    $this->imageCategory($id_inserted_category, $image);
                                } else {
                                    $categories_error++;
                                }
                            }
                            $row++;
                        }
                        fclose($handle);
                    }

                    if ($categories_process > 0) {
                        $html .= $this->displayConfirmation($this->l('Procesadas ') . $categories_process . $this->l(' categorías correctamente.'));
                    }
                    if ($categories_error > 0) {
                        $html .= $this->displayError($categories_error . $this->l(' categorías procesadas con error'));
                    }
                }

                break;
            //Procesado de productos
            case 'products':
                if (isset($_FILES['products']) && $_FILES['products']['error'] == 0) {
                    $products_filename = $_FILES["products"]["name"];
                    $products_tempname = $_FILES["products"]["tmp_name"];

                    $contexto = Context::getContext();
                    $get_categories = Category::getCategories($contexto->language->id);
                    $products_process = 0;
                    $products_error = 0;

                    if (($handle = fopen($products_tempname, 'r')) !== FALSE) {
                        $row = 0;
                        while (($data = fgetcsv($handle, null, ';')) !== FALSE) {
                            if ($row > 0) {
                                $category_name = $data[0];
                                $ref = $data[1];
                                $name = $data[2];
                                $description = $data[3];
                                $units = $data[4];
                                $price = $data[5];
                                $image = $data[6];

                                $link_rewrite = Tools::link_rewrite($this->cleanName($name));
                                $reference = $this->cleanReference($ref);

                                $id_category = Configuration::getGlobalValue('PS_HOME_CATEGORY');

                                foreach ($get_categories as $gc) {
                                    foreach ($gc as $value) {
                                        if ($value['infos']['name'] == $category_name) {
                                            $id_category = $value['infos']['id_category'];
                                            break;
                                        }
                                    }
                                }

                                $producto = new Product();
                                $producto->id_shop_default = Configuration::getGlobalValue('PS_SHOP_DEFAULT');
                                $producto->name = array();
                                $producto->link_rewrite = array();
                                $producto->description = array();
                                $producto->description_short = array();
                                foreach (Language::getLanguages(false) as $lang) {
                                    $producto->name[$lang['id_lang']] = $name;
                                    $producto->link_rewrite[$lang['id_lang']] = $link_rewrite;
                                    $producto->description[$lang['id_lang']] = $description;
                                    $producto->description_short[$lang['id_lang']] = $description;
                                }
                                $producto->id_category_default = $id_category;
                                $producto->reference = $reference;
                                $producto->price = $this->parsearFloat($price);
                                $producto->meta_description = $this->limitar_cadena($description, 512);
                                $producto->meta_keywords = $this->limitar_cadena($name, 512);
                                $producto->meta_title = $this->limitar_cadena($name, 512);
                                $producto->date_add = date('Y-m-d');
                                $producto->date_upd = date('Y-m-d');
                                $producto->show_price = 1;
                                $producto->minimal_quantity = 1;
                                $producto->active = true;

                                if ($producto->add(false)) {
                                    $products_process++;
                                    $id_inserted_product = $this->getLastInsertProduct();
                                    StockAvailable::updateQuantity($id_inserted_product, 0, (int) $units);
                                    $this->imageProduct($id_inserted_product, $image);
                                } else {
                                    $products_error++;
                                }
                            }
                            $row++;
                        }
                        fclose($handle);
                    }

                    if ($products_process > 0) {
                        $html .= $this->displayConfirmation($this->l('Procesados ') . $products_process . $this->l(' productos correctamente.'));
                    }
                    if ($products_error > 0) {
                        $html .= $this->displayError($products_error . $this->l(' productos procesados con error'));
                    }
                }

                break;
            default:
                break;
        }

        return $html;
    }

    /**
     * 
     * @return type
     */
    public function _displayForm() {
        return $this->displayFormTrait('_configuracion', $this->l('Configuracion'));
    }

    /**
     * 
     * @return type
     */
    private function _configuracion() {
        include_once(dirname(__FILE__) . '/acordeon.php');
        $this->addCSS('css.css');
        $acordeon = new acordeon($this->_path);
        //Formulario importar categorías
        $form = '<fieldset><legend>' . $this->l('Importar categorías Inventory Manager') . '</legend>
            <form action="' . Tools::safeOutput($_SERVER['REQUEST_URI']) . '" method="post" enctype="multipart/form-data">';
        $form .= '<input type="hidden" name="accion" value="categories" />';
        $form .= '<input type="hidden" name="idTab" value="1" />';

        $form .= '<div class="form-group  bootstrap">';
        $form .= '<label for="categories" class="control-label col-lg-3">' . $this->l('Selecciona el archivo de categorías:') . '</label>';
        $form .= '<div class="col-lg-3"><input type="file" accept=".csv" name="categories"></div>';
        $form .= '</div>';

        $form .= '<button class="btn btn-default pull-right" name="submit" type="submit"><i class="process-icon-save"></i>' . $this->l('Procesar') . '</button>';
        $form .= '</form>';
        $form .= '</fieldset>';

        $html = $acordeon->renderAcordeon($this->l('Importar Categorías'), $form);

        //Formulario importar productos
        $form = '<fieldset><legend>' . $this->l('Importar productos Inventory Manager') . '</legend>
            <form action="' . Tools::safeOutput($_SERVER['REQUEST_URI']) . '" method="post" enctype="multipart/form-data">';
        $form .= '<input type="hidden" name="accion" value="products" />';
        $form .= '<input type="hidden" name="idTab" value="1" />';

        $form .= '<div class="form-group  bootstrap">';
        $form .= '<label for="products" class="control-label col-lg-3">' . $this->l('Selecciona el archivo de productos:') . '</label>';
        $form .= '<div class="col-lg-3"><input type="file" accept=".csv" name="products"></div>';
        $form .= '</div>';

        $form .= '<button class="btn btn-default pull-right" name="submit" type="submit"><i class="process-icon-save"></i>' . $this->l('Procesar') . '</button>';
        $form .= '</form>';
        $form .= '</fieldset>';

        $html .= $acordeon->renderAcordeon($this->l('Importar Productos'), $form);

        return $html;
    }

}
