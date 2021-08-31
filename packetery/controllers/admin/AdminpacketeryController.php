<?php
/**
 * @author    Packeta www.packeta.com <business@packeta.com>
 * @copyright 2021 Packeta Ltd.
 * @license   MIT
 */

class AdminpacketeryController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->bootstrap = true;
        $this->html = '';
        $this->display = 'view';
        $this->meta_title = $this->l('Packeta', 'adminpacketerycontroller');
        $context = Context::getContext();

        if (isset($context->employee) && ($context->employee->id > 0)) {
            $id_employee = $context->employee->id;
            $token = self::getAdminToken($id_employee);
            Tools::redirectAdmin("index.php?controller=AdminModules&token=$token&configure=packetery");
        } else {
            die();
        }
    }

    public function renderView()
    {
        $context = Context::getContext();

        if (isset($context->employee) && ($context->employee->id > 0)) {
            $id_employee = $context->employee->id;
            $token = self::getAdminToken($id_employee);
            Tools::redirectAdmin("index.php?controller=AdminModules&token=$token&configure=packetery");
        } else {
            die();
        }
    }

    public static function getAdminToken($id_employee)
    {
        $tab = 'AdminModules';
        return Tools::getAdminToken($tab.(int)Tab::getIdFromClassName($tab).(int)$id_employee);
    }
}
