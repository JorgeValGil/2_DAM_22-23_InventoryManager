<?php

class AdmininventorymanagerController extends ModuleAdminController {

    public function __construct() {
        global $cookie;
        $token = md5(pSQL(_COOKIE_KEY_ . 'AdminModules' . (int) Tab::getIdFromClassName('AdminModules') . (int) $cookie->id_employee));
        header('Location: index.php?configure=inventorymanager&tab_module=administration&module_name=inventorymanager&controller=AdminModules&token=' . $token);
        exit;
    }

    public function initContent() {
        global $cookie;
        $token = md5(pSQL(_COOKIE_KEY_ . 'AdminModules' . (int) Tab::getIdFromClassName('AdminModules') . (int) $cookie->id_employee));
        header('Location: index.php?configure=inventorymanager&tab_module=administration&module_name=inventorymanager&controller=AdminModules&token=' . $token);
        exit;
    }

}
