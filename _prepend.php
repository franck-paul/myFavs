<?php
# -- BEGIN LICENSE BLOCK ---------------------------------------
#
# This file is part of Dotclear 2.
#
# Copyright (c) 2003-2011 Franck Paul
# Licensed under the GPL version 2.0 license.
# See LICENSE file or
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
#
# -- END LICENSE BLOCK -----------------------------------------

// Public and Admin mode

if (!defined('DC_CONTEXT_ADMIN')) { return; }

// Admin mode only

$core->addBehavior('adminDashboardFavs','myFavsDashboardFavs');

function myFavsDashboardFavs($core,$favs)
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
					// Looks for _admin.php, mandatory to register fav's behaviours (may be but should not be in _prepend.php!)
					if (file_exists($mf_root.'/_admin.php')) {
						// Looks for 'adminDashboardFavs' string in PHP code of _admin.php
						$mf_content = file_get_contents($mf_root.'/_admin.php');
						if (strpos($mf_content,"'adminDashboardFavs'")) {
							$mf_found = true;
						}
					}
					if (!$mf_found) {
						// Add a fav for this plugin
						$favs[$mf_id] = new ArrayObject(array(
							$mf_id,
							$core->plugins->moduleInfo($mf_id,'name'),
							'plugin.php?p='.$mf_id,
							'index.php?pf=myFavs/icon.png',
							'index.php?pf=myFavs/icon-big.png',
							$core->plugins->moduleInfo($mf_id,'permissions'),
							null,
							null));
					}
				}
			}
		}
	}	
}
?>