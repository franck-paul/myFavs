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
declare(strict_types=1);

namespace Dotclear\Plugin\myFavs;

use Autoloader;
use dcCore;
use dcFavorites;
use dcModuleDefine;
use dcModules;
use dcPage;
use Exception;

class BackendBehaviors
{
    public static function adminDashboardFavorites(dcFavorites $favs)
    {
        // Get all activated plugins
        $mf_plugins = dcCore::app()->plugins->getDefines(['state' => dcModuleDefine::STATE_ENABLED], true);
        if (!empty($mf_plugins)) {
            foreach (array_keys($mf_plugins) as $module_id) {
                if ($module_id != 'myFavs') {
                    // Ignore non active plugins (due to lack of dependencies)
                    $define = dcCore::app()->plugins->getDefine($module_id);
                    // Note this test below will not more be necessary with 2.27
                    if (!empty($define->getMissing())) {
                        continue;
                    }

                    // Only other plugins
                    $module_root  = dcCore::app()->plugins->moduleInfo($module_id, 'root');
                    $module_admin = '';
                    $content      = '';

                    // Old school plugins
                    // Looks for index.php, mandatory to create a fav on dashboard
                    if (file_exists($module_root . '/index.php')) {
                        // Looks for _admin.php, mandatory to register fav's behaviours (may be, but should not be, in _prepend.php!)
                        if (file_exists($module_root . DIRECTORY_SEPARATOR . dcModules::MODULE_FILE_ADMIN)) {
                            $module_admin = dcModules::MODULE_FILE_ADMIN;
                        }
                    } else {
                        // New school plugins
                        // Looks for Admin.php, mandatory to register fav's behaviours (may be, but should not be, in Prepend.php!)
                        $module_ns = dcCore::app()->plugins->moduleInfo($module_id, 'namespace');
                        if (!empty($module_ns) && class_exists($module_ns . Autoloader::NS_SEP . dcModules::MODULE_CLASS_ADMIN)) {
                            $module_admin = dcModules::MODULE_CLASS_DIR . DIRECTORY_SEPARATOR . dcModules::MODULE_CLASS_ADMIN . '.php';
                        }
                    }
                    if ($module_admin !== '') {
                        // Check for fav registration before proposing an alternate one
                        $content = file_get_contents($module_root . DIRECTORY_SEPARATOR . $module_admin);
                        if (!strpos($content, "'adminDashboardFavs'") && !strpos($content, "'adminDashboardFavorites'")) {
                            // Looks for SVG or PNG icon(s) to use with favorite
                            if (file_exists($module_root . '/icon.svg')) {
                                // Use SVG version(s) if exist
                                $icon_light = $icon_dark = urldecode(dcPage::getPF($module_id . '/icon.svg'));
                                if (file_exists($module_root . '/icon-dark.svg')) {
                                    $icon_dark = urldecode(dcPage::getPF($module_id . '/icon-dark.svg'));
                                }
                                $icon = $icon_big = [$icon_light, $icon_dark];
                            } else {
                                // Use PNG version(s) if exist else use fallback
                                $fallback = My::icons();
                                $icon     = file_exists($module_root . '/icon.png') ?
                                    urldecode(dcPage::getPF($module_id . '/icon.png')) :
                                    $fallback;
                                $icon_big = file_exists($module_root . '/icon-big.png') ?
                                    urldecode(dcPage::getPF($module_id . '/icon-big.png')) :
                                    $fallback;
                            }

                            // Add a fav for this plugin
                            try {
                                $favs->register($module_id, [
                                    'title'       => __(dcCore::app()->plugins->moduleInfo($module_id, 'name')),
                                    'url'         => dcCore::app()->adminurl->get('admin.plugin.' . $module_id),
                                    'small-icon'  => $icon,
                                    'large-icon'  => $icon_big,
                                    'permissions' => dcCore::app()->plugins->moduleInfo($module_id, 'permissions'),
                                ]);
                            } catch (Exception $e) {
                                ; // Ignore exception
                            }
                        }
                    }
                }
            }
        }
    }
}
