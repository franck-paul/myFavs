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

// Public and Admin mode

if (!defined('DC_CONTEXT_ADMIN')) {
    return false;
}

// dead but useful code, in order to have translations
__('myFavs') . __('Add favorite capabilities to all plugins');

// Admin mode only

class adminMyFavs
{
    public static function adminDashboardFavorites($favs)
    {
        // Get all activated plugins
        $mf_plugins = dcCore::app()->plugins->getModules();
        if (!empty($mf_plugins)) {
            foreach ($mf_plugins as $mf_id => $mf_plugin) {
                if ($mf_id != 'myFavs') {
                    // Only other plugins
                    $mf_root = dcCore::app()->plugins->moduleRoot($mf_id);
                    // Looks for index.php, mandatory to create a fav on dashboard
                    if (file_exists($mf_root . '/index.php')) {
                        $mf_found = false;
                        // Looks for _admin.php, mandatory to register fav's behaviours (may be, but should not be, in _prepend.php!)
                        if (file_exists($mf_root . DIRECTORY_SEPARATOR . dcModules::MODULE_FILE_ADMIN)) {
                            // Looks for 'adminDashboardFavs' string in PHP code of _admin.php
                            $mf_content = file_get_contents($mf_root . DIRECTORY_SEPARATOR . dcModules::MODULE_FILE_ADMIN);
                            if (strpos($mf_content, "'adminDashboardFavs'") || (strpos($mf_content, "'adminDashboardFavorites'"))) {
                                $mf_found = true;
                            }
                        }
                        if (!$mf_found) {
                            if (file_exists($mf_root . '/icon.svg')) {
                                // Use SVG version(s) if exist
                                $icon_light = $icon_dark = urldecode(dcPage::getPF($mf_id . '/icon.svg'));
                                if (file_exists($mf_root . '/icon-dark.svg')) {
                                    $icon_dark = urldecode(dcPage::getPF($mf_id . '/icon-dark.svg'));
                                }
                                $icon = $icon_big = [$icon_light, $icon_dark];
                            } else {
                                // Use PNG version(s) if exist else use fallback
                                $fallback = [
                                    urldecode(dcPage::getPF('myFavs/icon.svg')),
                                    urldecode(dcPage::getPF('myFavs/icon-dark.svg')), ];
                                $icon = file_exists($mf_root . '/icon.png') ?
                                    urldecode(dcPage::getPF($mf_id . '/icon.png')) :
                                    $fallback;
                                $icon_big = file_exists($mf_root . '/icon-big.png') ?
                                    urldecode(dcPage::getPF($mf_id . '/icon-big.png')) :
                                    $fallback;
                            }
                            // Add a fav for this plugin
                            $favs->register($mf_id, [
                                'title'       => __(dcCore::app()->plugins->moduleInfo($mf_id, 'name')),
                                'url'         => 'plugin.php?p=' . $mf_id,
                                'small-icon'  => $icon,
                                'large-icon'  => $icon_big,
                                'permissions' => dcCore::app()->plugins->moduleInfo($mf_id, 'permissions'),
                            ]);
                        }
                    }
                }
            }
        }
    }
}

/* Register favorite */
dcCore::app()->addBehavior('adminDashboardFavoritesV2', [adminMyFavs::class, 'adminDashboardFavorites']);
