<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * @param Packetery $module
 * @return bool
 */
function upgrade_module_2_1_12($module)
{
    $result = (
        Configuration::updateValue('PACKETERY_ADDRESS_VALIDATION', 'none') &&
        Configuration::updateValue('PACKETERY_ORDERS_PER_PAGE', 50) &&
        $module->registerHook('actionValidateStepComplete')
    );
    if ($result === false) {
        return false;
    }

    return Db::getInstance()->execute('
        ALTER TABLE `' . _DB_PREFIX_ . 'packetery_order`
        ADD `country` varchar(2) NULL,
        ADD `county` varchar(255) NULL AFTER `country`,
        ADD `zip` varchar(255) NULL AFTER `county`,
        ADD `city` varchar(255) NULL AFTER `zip`,
        ADD `street` varchar(255) NULL AFTER `city`,
        ADD `house_number` varchar(255) NULL AFTER `street`,
        ADD `latitude` varchar(255) NULL AFTER `house_number`,
        ADD `longitude` varchar(255) NULL AFTER `latitude`;
    ');
}
