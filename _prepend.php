<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
# This file is part of myFavs, a plugin for Dotclear 2.
#
# Copyright (c) Franck Paul and contributors
# carnet.franck.paul@gmail.com
#
# Licensed under the GPL version 2.0 license.
# A copy of this license is available in LICENSE file or at
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
# -- END LICENSE BLOCK ------------------------------------

if (!defined('DC_RC_PATH')) { return; }

// Public and Admin mode

if (!defined('DC_CONTEXT_ADMIN')) { return false; }

// dead but useful code, in order to have translations
__('myFavs').__('Add favorite capabilities to all plugins');

// Admin mode only

/* Register favorite */
$core->addBehavior('adminDashboardFavorites',array('adminMyFavs','adminDashboardFavorites'));

class adminMyFavs
{
	public static function adminDashboardFavorites($core,$favs)
{
	// Get all activated plugins
	$mf_plugins = $core->plugins->getModules();
	if (!empty($mf_plugins)) {
		foreach ($mf_plugins as $mf_id => $mf_plugin) {
			if ($mf_id != 'myFavs') {
				// Only other plugins
				$mf_root = $core->plugins->moduleRoot($mf_id);
				// Looks for index.php, mandatory to create a fav on dashboard
				if (file_exists($mf_root.'/index.php')) {
					$mf_found = false;
					// Looks for _admin.php, mandatory to register fav's behaviours (may be, but should not be, in _prepend.php!)
					if (file_exists($mf_root.'/_admin.php')) {
						// Looks for 'adminDashboardFavs' string in PHP code of _admin.php
						$mf_content = file_get_contents($mf_root.'/_admin.php');
							if (strpos($mf_content,"'adminDashboardFavs'") || (strpos($mf_content,"'adminDashboardFavorites'"))) {
							$mf_found = true;
						}
					}
					if (!$mf_found) {
							$icon = file_exists($mf_root.'/icon.png') ? 'index.php?pf='.$mf_id.'/icon.png' : 'index.php?pf=myFavs/icon.png';
							$icon_big = file_exists($mf_root.'/icon-big.png') ? 'index.php?pf='.$mf_id.'/icon-big.png' : 'index.php?pf=myFavs/icon-big.png';
						// Add a fav for this plugin
							$favs->register($mf_id, array(
								'title' => __($core->plugins->moduleInfo($mf_id,'name')),
								'url' => 'plugin.php?p='.$mf_id,
								'small-icon' => $icon,
								'large-icon' => $icon_big,
								'permissions' => $core->plugins->moduleInfo($mf_id,'permissions')
							));
						}
					}
				}
			}
		}
	}
}
