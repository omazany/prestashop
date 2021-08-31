<?php
/**
 * Upgrades module to version 2.1.7
 *
 *  @author    RTsoft s.r.o
 *  @copyright 2019 RTsoft s.r.o
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * @param Packetery $module
 * @return bool
 */
function upgrade_module_2_2_0($module)
{
    return (
        $module->registerHook('displayBeforeCarrier') &&
        Configuration::updateValue('PACKETERY_WIDGET_AUTOOPEN', 0)
    );
}
