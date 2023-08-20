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
    '3.2.3',
    [
        'requires' => [['core', '2.27'], ['php', '8.1']],
        'type'     => 'plugin',
        'priority' => 999_999_999,

        'details'    => 'https://open-time.net/?q=myFavs',
        'support'    => 'https://github.com/franck-paul/myFavs',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/myFavs/master/dcstore.xml',
    ]
);
