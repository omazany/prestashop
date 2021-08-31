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

function upgrade_module_2_1_4($object) {

	return (
		$object->unregisterHook('displayFooter') &&
		$object->unregisterHook('displayBeforeCarrier'));
}
