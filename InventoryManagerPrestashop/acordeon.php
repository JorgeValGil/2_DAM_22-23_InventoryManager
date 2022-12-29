<?php

/**
 * 
 */
class acordeon {

    /**
     * 
     * @param type $modulePath
     */
    function __construct($modulePath) {
        $this->context = Context::getContext();
        $this->_path = $modulePath;
        $this->addCSS('acordeon.css');
        $this->addJS('acordeon.js');
    }

    /**
     * 
     * @param type $titulo
     * @param type $contenido
     * @param type $id
     * @return string
     */
    function renderAcordeon($titulo, $contenido, $id = '') {
        $html = '';
        $html = '<dl id="' . $id . '" class="acordeon">';
        $html .= '<dt>' . $titulo . '</dt>';
        $html .= '<dd>';
        $html .= $contenido;
        $html .= '</dd>';
        $html .= '</dl>';
        return $html;
    }

    /**
     * 
     * @param type $css
     * @return type
     */
    private function addCSS($css) {
        $tab = Tools::getValue('tab', 0);
        if (!$tab || ($tab && $tab != 'AdminSelfUpgrade')) {
            if ($this->context->controller instanceof stdClass) {
                $this->context->controller = new AdminModulesController();
            }
            $this->context->controller->addCss($this->_path . 'acordeon/' . $css, 'all');
        }
        return;
    }

    /**
     * 
     * @param type $js
     * @return type
     */
    private function addJS($js) {
        $tab = Tools::getValue('tab', 0);
        if (!$tab || ($tab && $tab != 'AdminSelfUpgrade')) {
            if ($this->context->controller instanceof stdClass) {
                $this->context->controller = new AdminModulesController();
            }
            $this->context->controller->addJs($this->_path . 'acordeon/' . $js);
        }
        return;
    }

}
