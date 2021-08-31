<?php
/**
 * @author    Packeta www.packeta.com <business@packeta.com>
 * @copyright 2021 Packeta Ltd.
 * @license   MIT
 */

// https://devdocs.prestashop.com/1.7/modules/creation/module-file-structure/#external-libraries
spl_autoload_register(
    static function ($class) {
        $filePath = dirname(__FILE__) . '/libs/' . str_replace(['\\', 'Packetery'], ['/', ''], $class) . '.php';
        if (is_file($filePath)) {
            require_once $filePath;
        }
    }
);
