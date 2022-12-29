<?php

/**
 * 
 */
Trait ComunesInventoryManager {

    /**
     * 
     * @param type $css
     * @return type
     */
    public function addCSS($css) {
        $tab = Tools::getValue('tab', 0);
        if (!$tab || ($tab && $tab != 'AdminSelfUpgrade')) {
            $this->context->controller->addCss($this->_path . 'css/' . $css, 'all');
        }

        return;
    }

    /**
     * 
     * @param type $js
     * @return type
     */
    public function addJS($js) {
        $tab = Tools::getValue('tab', 0);
        if (!$tab || ($tab && $tab != 'AdminSelfUpgrade')) {
            $this->context->controller->addJs($this->_path . 'js/' . $js);
        }

        return;
    }

    /**
     * 
     * @return string
     */
    public function createHelpHeader() {
        $html = '<div class="module-header">';
        $html .= '<div class="module-title-container">';
        $html .= '<h2 class="module-title">' . $this->displayName . '</h2>';
        $html .= '<h3 class="module-version">' . $this->l('Version: ') . $this->version . '</h3>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * 
     * @param type $msg
     * @param string $modulo
     * @param type $locale
     * @return type
     */
    public function l($msg, $modulo = '', $locale = null) {
        if ($modulo == '') {
            $modulo = 'traducciones' . strtolower($this->name);
        }
        return parent::l($msg, $modulo, $locale);
    }

    /**
     * Crea un nuevo tab.
     * @param string $clase
     * @param string $nombre
     * @param string $padre
     * @return boolean
     */
    private function crearTab($clase, $nombre, $padre, $imagen) {
        if (!Tab::getIdFromClassName($clase)) {
            $tab = new Tab();
            $tab->active = 1;
            $tab->class_name = $clase;
            $tab->name = array();
            foreach (Language::getLanguages(true) as $lang) {
                $tab->name[$lang['id_lang']] = $nombre;
            }
            if ($padre == '') {
                $posicion = 0;
            } else {
                $posicion = Tab::getIdFromClassName($padre);
            }
            $tab->id_parent = intval($posicion);
            $tab->module = $this->name;
            $tab->icon = $imagen;
            try {
                if (!$tab->add()) {
                    return false;
                }
            } catch (Exception $exc) {
                return false;
            }
        }

        return true;
    }

    /**
     * Borra un tab.
     * @param string $clase
     * @return boolean
     */
    private function borrarTab($clase) {
        $id_tab = (int) Tab::getIdFromClassName($clase);
        if ($id_tab) {
            $tab = new Tab($id_tab);
            try {
                if (!$tab->delete()) {
                    return false;
                }
            } catch (Exception $exc) {
                return false;
            }
        }

        return true;
    }

    /**
     * Instala los tabs del módulo.
     * @return boolean
     */
    private function installTab() {
        include(dirname(__FILE__) . '/configuration.php');

        //Instalamos el root
        if (isset($moduleTabRoot) && $moduleTabRoot) {
            $this->crearTab($moduleTabRoot['clase'], $moduleTabRoot['name'], $moduleTabRoot['padre'], $moduleTabRoot['imagen']);
        }

        //Instalamos el resto de tabs
        if (isset($moduleTabs) && $moduleTabs) {
            foreach ($moduleTabs AS $moduleTab) {
                $this->borrarTab($moduleTab['clase']);
                if (!$this->crearTab($moduleTab['clase'], $moduleTab['name'], $moduleTab['padre'], $moduleTab['imagen'])) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Desinstala los tabs del módulo.
     * @return boolean
     */
    private function uninstallTab() {
        include(dirname(__FILE__) . '/configuration.php');

        //Desinstalamos las tabs de este módulo
        if (isset($moduleTabs) && $moduleTabs) {
            foreach ($moduleTabs AS $moduleTab) {
                if (!$this->borrarTab($moduleTab['clase'])) {
                    return false;
                }
            }
        }

        //Desinstalamos el root si está vacío
        if (isset($moduleTabRoot) && $moduleTabRoot) {
            $id_tab = (int) Tab::getIdFromClassName($moduleTabRoot['clase']);
            if ($id_tab && Tab::getNbTabs($id_tab) == 0) {
                if (!$this->borrarTab($moduleTabRoot['clase'])) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Version comun de displayForm.
     * @param string[] $tabsArray [$funcion => $nombreTab]
     */
    private function displayFormTrait($funcion, $nombreTab) {
        if ($this->idTab == '' || empty($this->idTab)) {
            $this->idTab = 1;
        }
        $this->_html .= '<ul id="menuTab">';
        $this->_html .= '<li id="menuTab1" class="menuTabButton selected">' . $nombreTab . '</li>';
        $this->_html .= '</ul>';
        $this->_html .= '<div id="tabList">';
        $this->_html .= '<div id="menuTab1Sheet" class="tabItem selected">' . $this->{$funcion}() . '</div>';
        $this->_html .= '</div>';
    }

    /**
     * Limpia un texto para hacerlo correcto desde el punto de vista de Prestashop.
     * 
     * @param string $texto
     * @return string
     */
    protected function cleanName($texto) {
        $texto = trim($texto);
        $texto = Tools::replaceAccentedChars($texto);
        $texto = preg_replace('/[^a-zA-Z0-9\s\'\:\/\[\]\-\pL]/u', '', $texto);
        $texto = preg_replace('/[\s\'\:\/\[\]\-]+/', ' ', $texto);
        $texto = str_replace(array("\xC2\xA0", "/"), ' ', $texto);

        return $texto;
    }

    /**
     * Limpia una referencia para hacerla correcta segun los validadores de Prestashop
     * 
     * @param string $texto
     * @return string
     */
    protected function cleanReference($texto) {
        $texto = trim($texto);
        $texto = Tools::replaceAccentedChars($texto);
        $texto = str_replace(array('<', '>', ';', '=', '{', '}'), ' ', $texto);
        return $texto;
    }

    /**
     * Convierte un string a float.
     * 
     * @param string $numero
     * @return float
     */
    protected function parsearFloat($numero) {
        return (float) str_replace(',', '.', trim($numero));
    }

    /**
     * Corta una cadena hasta una longitud máxima
     * 
     * @param string $cadena cadena
     * @param int $limite limite de la cadena
     * @return type
     */
    protected function limitar_cadena($cadena, $limite) {
        if (strlen($cadena) > $limite) {
            $cadena = substr($cadena, 0, $limite);
        }
        return $cadena;
    }

    /**
     * Obtiene el id de categoría más alto
     * 
     * @return type
     */
    function getLastInsertCategory() {
        return Db::getInstance()->getValue('SELECT MAX(id_category) FROM `' . _DB_PREFIX_ . 'category`');
    }

    /**
     * Obtiene el id de producto más alto
     * 
     * @return type
     */
    function getLastInsertProduct() {
        return Db::getInstance()->getValue('SELECT MAX(id_product) FROM `' . _DB_PREFIX_ . 'product`');
    }

    /**
     * Añade una imagen a un producto
     * 
     * @param type $id_product ID producto
     * @param type $imgurl URL imagen
     */
    function imageProduct($id_product, $imgurl) {
        $image = new Image();
        $image->id_product = (int) $id_product;
        $image->position = Image::getHighestPosition($id_product) + 1;
        $image->cover = true;
        $image->add();
        if (!$this->copyImg($id_product, $image->id, $imgurl, 'products')) {
            $image->delete();
        }
    }

    /**
     * Añade una imagen a una categoría
     * 
     * @param type $id_category ID categoría
     * @param type $imgurl URL imagen
     */
    function imageCategory($id_category, $imgurl) {
        $image = new Image();
        $image->id_product = (int) $id_category;
        $image->position = Image::getHighestPosition($id_category) + 1;
        $image->cover = true;
        $image->add();
        if (!$this->copyImg($id_category, $image->id, $imgurl, 'categories')) {
            $image->delete();
        }
    }

    /**
     * Sube una imagen
     * 
     * @param type $id_entity ID producto o ID categoría
     * @param type $id_image ID imagen
     * @param type $url URL imagen
     * @param type $entity 'products' o 'categories'
     * @return boolean
     */
    function copyImg($id_entity, $id_image, $url, $entity) {
        $tmpfile = tempnam(_PS_TMP_IMG_DIR_, 'ps_import');
        $watermark_types = explode(',', Configuration::get('WATERMARK_TYPES'));

        switch ($entity) {
            default:
            case 'products':
                $image_obj = new Image($id_image);
                $path = $image_obj->getPathForCreation();
                break;
            case 'categories':
                $path = _PS_CAT_IMG_DIR_ . (int) $id_entity;
                break;
        }
        $url = str_replace(' ', '%20', trim($url));

        if (!ImageManager::checkImageMemoryLimit($url))
            return false;

        if (Tools::copy($url, $tmpfile)) {
            ImageManager::resize($tmpfile, $path . '.jpg');
            $images_types = ImageType::getImagesTypes($entity);

            foreach ($images_types as $image_type) {
                ImageManager::resize($tmpfile, $path . '-' . stripslashes($image_type['name']) . '.jpg', $image_type['width'], $image_type['height']);
                if (in_array($image_type['id_image_type'], $watermark_types))
                    Hook::exec('actionWatermark', array('id_image' => $id_image, 'id_product' => $id_entity));
            }
        } else {
            unlink($tmpfile);
            return false;
        }
        unlink($tmpfile);
        return true;
    }

}
