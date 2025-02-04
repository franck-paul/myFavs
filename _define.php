<?php

/**
 * @brief myFavs, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
$this->registerModule(
    'myFavs',
    'Add favorite capabilities to all plugins',
    'Franck Paul',
    '5.2.1',
    [
        'date'     => '2003-08-13T13:42:00+0100',
        'requires' => [['core', '2.28']],
        'type'     => 'plugin',
        'priority' => 999_999_999,

        'details'    => 'https://open-time.net/?q=myFavs',
        'support'    => 'https://github.com/franck-paul/myFavs',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/myFavs/main/dcstore.xml',
    ]
);
