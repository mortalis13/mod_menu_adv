<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$document = JFactory::getDocument();
$direction = $document->direction == 'rtl' ? 'pull-right' : '';

// require JModuleHelper::getLayoutPath('mod_menu_adv', $enabled ? 'default_enabled' : 'default_disabled');
// $menu->renderMenu('menu_adv', $enabled ? 'nav ' . $direction : 'nav disabled ' . $direction);

require JModuleHelper::getLayoutPath('mod_menu_adv', 'default_enabled');
$menu->renderMenu('menu_adv', 'nav ' . $direction);
