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
if (!defined('DC_RC_PATH')) {
    return;
}

$this->registerModule(
    'myFavs',                                   // Name
    'Add favorite capabilities to all plugins', // Description
    'Franck Paul',                              // Author
    '1.0',
    [
        'requires' => [['core', '2.24']], // Dependencies
        'type'     => 'plugin',  // Type
        'priority' => 999999999, // Priority

        'details'    => 'https://open-time.net/?q=myFavs',       // Details URL
        'support'    => 'https://github.com/franck-paul/myFavs', // Support URL
        'repository' => 'https://raw.githubusercontent.com/franck-paul/myFavs/master/dcstore.xml',
    ]
);
