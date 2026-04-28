<?php

/**
 * @brief myFavs, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul contact@open-time.net
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
$this->registerModule(
    'myFavs',
    'Add favorite capabilities to all plugins',
    'Franck Paul',
    '6.3',
    [
        'date'     => '2026-04-04T15:44:11+0200',
        'requires' => [['core', '2.36']],
        'type'     => 'plugin',
        'priority' => 999_999_999,

        'details'    => 'https://open-time.net/?q=myFavs',
        'support'    => 'https://github.com/franck-paul/myFavs',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/myFavs/main/dcstore.xml',
        'license'    => 'gpl2',
    ]
);
