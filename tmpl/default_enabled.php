<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/* @var $menu JAdminCSSMenu */

$document = JFactory::getDocument();
$document->addStyleSheet('modules/mod_menu_adv/css/custom.css');
$document->addScript('modules/mod_menu_adv/js/custom.js');

$shownew = (boolean) $params->get('shownew', 1);
$showhelp = $params->get('showhelp', 1);
$user = JFactory::getUser();
$lang = JFactory::getLanguage();


/*
 * Site Submenu
 */
$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_SYSTEM'), '#'), true);
$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_CONTROL_PANEL'), 'index.php', 'class:cpanel'));

if ($user->authorise('core.admin'))
{
	$menu->addSeparator();
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_CONFIGURATION'), 'index.php?option=com_config', 'class:config'),true);

	$components = ConfigHelperConfig::getComponentsWithConfig();
	ConfigHelperConfig::loadLanguageForComponents($components);

	foreach ($components as $component) {
		$menu->addChild(new JMenuNode(JText::_($component), 'index.php?option=com_config&view=component&component='.$component));
	}

	$menu->getParent();
}

if ($user->authorise('core.manage', 'com_checkin'))
{
	$menu->addSeparator();
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_GLOBAL_CHECKIN'), 'index.php?option=com_checkin', 'class:checkin'));
}

if ($user->authorise('core.manage', 'com_cache'))
{
	$menu->addSeparator();
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_CLEAR_CACHE'), 'index.php?option=com_cache', 'class:clear'));
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_PURGE_EXPIRED_CACHE'), 'index.php?option=com_cache&view=purge', 'class:purge'));
}

if ($user->authorise('core.admin'))
{
	$menu->addSeparator();
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_SYSTEM_INFORMATION'), 'index.php?option=com_admin&view=sysinfo', 'class:info'));
}

$menu->getParent();

/*
 * Users Submenu
 */
if ($user->authorise('core.manage', 'com_users'))
{
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_COM_USERS_USERS'), '#'), true);
	$createUser = $shownew && $user->authorise('core.create', 'com_users');
	$createGrp  = $user->authorise('core.admin', 'com_users');

	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_COM_USERS_USER_MANAGER'), 'index.php?option=com_users&view=users', 'class:user'), $createUser);

	if ($createUser)
	{
		$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_COM_USERS_ADD_USER'), 'index.php?option=com_users&task=user.add', 'class:newarticle'));
		$menu->getParent();
	}

	if ($createGrp)
	{
		$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_COM_USERS_GROUPS'), 'index.php?option=com_users&view=groups', 'class:groups'), $createUser);

		if ($createUser)
		{
			$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_COM_USERS_ADD_GROUP'), 'index.php?option=com_users&task=group.add', 'class:newarticle'));
			$menu->getParent();
		}

		$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_COM_USERS_LEVELS'), 'index.php?option=com_users&view=levels', 'class:levels'), $createUser);

		if ($createUser)
		{
			$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_COM_USERS_ADD_LEVEL'), 'index.php?option=com_users&task=level.add', 'class:newarticle'));
			$menu->getParent();
		}
	}

	$menu->addSeparator();
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_COM_USERS_NOTES'), 'index.php?option=com_users&view=notes', 'class:user-note'), $createUser);

	if ($createUser)
	{
		$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_COM_USERS_ADD_NOTE'), 'index.php?option=com_users&task=note.add', 'class:newarticle'));
		$menu->getParent();
	}

	$menu->addChild(
		new JMenuNode(
			JText::_('MOD_MENU_ADV_COM_USERS_NOTE_CATEGORIES'), 'index.php?option=com_categories&view=categories&extension=com_users', 'class:category'),
		$createUser
	);

	if ($createUser)
	{
		$menu->addChild(
			new JMenuNode(
				JText::_('MOD_MENU_ADV_COM_CONTENT_NEW_CATEGORY'), 'index.php?option=com_categories&task=category.add&extension=com_users',
				'class:newarticle'
			)
		);
		$menu->getParent();
	}

	$menu->addSeparator();
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_MASS_MAIL_USERS'), 'index.php?option=com_users&view=mail', 'class:massmail'));

	$menu->getParent();
}

/*
 * Menus Submenu
 */
if ($user->authorise('core.manage', 'com_menus'))
{
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_MENUS'), '#'), true);
	$createMenu = $shownew && $user->authorise('core.create', 'com_menus');

	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_MENU_MANAGER'), 'index.php?option=com_menus&view=menus', 'class:menumgr'), $createMenu);

	if ($createMenu)
	{
		$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_MENU_MANAGER_NEW_MENU'), 'index.php?option=com_menus&view=menu&layout=edit', 'class:newarticle'));
		$menu->getParent();
	}

	$menu->addSeparator();

	// Menu Types
	foreach (ModMenuAdvHelper::getMenus() as $menuType)
	{
		$alt = '*' . $menuType->sef . '*';

		if ($menuType->home == 0)
		{
			$titleicon = '';
		}
		elseif ($menuType->home == 1 && $menuType->language == '*')
		{
			$titleicon = ' <i class="icon-home"></i>';
		}
		elseif ($menuType->home > 1)
		{
			$titleicon = ' <span>'
				. JHtml::_('image', 'mod_languages/icon-16-language.png', $menuType->home, array('title' => JText::_('MOD_MENU_ADV_HOME_MULTIPLE')), true)
				. '</span>';
		}
		else
		{
			$image = JHtml::_('image', 'mod_languages/' . $menuType->image . '.gif', null, null, true, true);

			if (!$image)
			{
				$image = JHtml::_('image', 'mod_languages/icon-16-language.png', $alt, array('title' => $menuType->title_native), true);
			}
			else
			{
				$image = JHtml::_('image', 'mod_languages/' . $menuType->image . '.gif', $alt, array('title' => $menuType->title_native), true);
			}

			$titleicon = ' <span>' . $image . '</span>';
		}

		$menu->addChild(
			new JMenuNode(
				$menuType->title, 'index.php?option=com_menus&view=items&menutype=' . $menuType->menutype, 'class:menu', null, null, $titleicon
			),
			$createMenu
		);

		if ($createMenu)
		{
			$menu->addChild(
				new JMenuNode(
					JText::_('MOD_MENU_ADV_MENU_MANAGER_NEW_MENU_ITEM'), 'index.php?option=com_menus&view=item&layout=edit&menutype=' . $menuType->menutype,
					'class:newarticle')
			);
		}

		$menuItems=ModMenuAdvHelper::getMenuItems($menuType->menutype);
		if($menuItems)
			$menu->addSeparator();
		foreach ($menuItems as $item) {
			$title=$item->title;
			$class="";
			if($item->published!=1){
				$class="disabled-item-custom";
			}
			$menu->addChild(new JMenuNode($title, 'index.php?option=com_menus&task=item.edit&id='.$item->id,$class));
		}

		$menu->getParent();
	}

	$menu->getParent();
}

/*
 * Content Submenu
 */
if ($user->authorise('core.manage', 'com_content'))
{
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_COM_CONTENT'), '#'), true);
	$createContent = $shownew && $user->authorise('core.create', 'com_content');
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_COM_CONTENT_ARTICLE_MANAGER'), 'index.php?option=com_content', 'class:article'), $createContent);

	if ($createContent)
	{
		$menu->addChild(
			new JMenuNode(JText::_('MOD_MENU_ADV_COM_CONTENT_NEW_ARTICLE'), 'index.php?option=com_content&task=article.add', 'class:newarticle')
		);
		$menu->getParent();
	}

	$menu->addChild(
		new JMenuNode(
			JText::_('MOD_MENU_ADV_COM_CONTENT_CATEGORY_MANAGER'), 'index.php?option=com_categories&extension=com_content', 'class:category'),
		$createContent
	);

	if ($createContent)
	{
		$menu->addChild(
			new JMenuNode(JText::_('MOD_MENU_ADV_COM_CONTENT_NEW_CATEGORY'), 'index.php?option=com_categories&task=category.add&extension=com_content', 'class:newarticle')
		);
		$menu->getParent();
	}

	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_COM_CONTENT_FEATURED'), 'index.php?option=com_content&view=featured', 'class:featured'));

	if ($user->authorise('core.manage', 'com_media'))
	{
		$menu->addSeparator();
		$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_MEDIA_MANAGER'), 'index.php?option=com_media', 'class:media'));
	}

	$menu->getParent();
}

/*
 * Components Submenu
 */

// Get the authorised components and sub-menus.
$components = ModMenuAdvHelper::getComponents(true);

// Check if there are any components, otherwise, don't render the menu
if ($components)
{
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_COMPONENTS'), '#'), true);

	foreach ($components as &$component)
	{
		if (!empty($component->submenu))
		{
			// This component has a db driven submenu.
			$menu->addChild(new JMenuNode($component->text, $component->link, $component->img), true);

			foreach ($component->submenu as $sub)
			{
				$menu->addChild(new JMenuNode($sub->text, $sub->link, $sub->img));
			}

			$menu->getParent();
		}
		else
		{
			$menu->addChild(new JMenuNode($component->text, $component->link, $component->img));
		}
	}

	$menu->getParent();
}

/*
 * Extensions Submenu
 */
$im = $user->authorise('core.manage', 'com_installer');
$mm = $user->authorise('core.manage', 'com_modules');
$pm = $user->authorise('core.manage', 'com_plugins');
$tm = $user->authorise('core.manage', 'com_templates');
$lm = $user->authorise('core.manage', 'com_languages');

if ($im || $mm || $pm || $tm || $lm)
{
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_EXTENSIONS_EXTENSIONS'), '#'), true);

	if ($im)
	{
		$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_EXTENSIONS_EXTENSION_MANAGER'), 'index.php?option=com_installer', 'class:install'),true);
		$menu->addChild(new JMenuNode(JText::_("MOD_MENU_ADV_EXTENSIONS_EXTENSION_MANAGER_MANAGE"), 'index.php?option=com_installer&view=manage'));
		$menu->addChild(new JMenuNode(JText::_("MOD_MENU_ADV_EXTENSIONS_EXTENSION_MANAGER_DISCOVER"), 'index.php?option=com_installer&view=discover'));
		$menu->getParent();
	}

	if ($im && ($mm || $pm || $tm || $lm))
	{
		$menu->addSeparator();
	}

	if ($mm)
	{
		$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_EXTENSIONS_MODULE_MANAGER'), 'index.php?option=com_modules', 'class:module'),true);

		$menu->addChild(new JMenuNode(JText::_("MOD_MENU_ADV_EXTENSIONS_MODULE_MANAGER_SITE"), 'index.php?option=com_modules&filter_client_id=0',"new-module"),true);

		$modulesList=ModMenuAdvHelper::getModules();

		foreach ($modulesList as $m) {
			$lang->load($m->element . '.sys', JPATH_SITE, null, false, true);
			$menu->addChild(new JMenuNode(JText::_($m->element), 'index.php?option=com_modules&task=module.add&eid='.$m->extension_id));
		}
		$menu->getParent();


		$menu->addChild(new JMenuNode(JText::_("MOD_MENU_ADV_EXTENSIONS_MODULE_MANAGER_ADMIN"), 'index.php?option=com_modules&filter_client_id=1',"new-module-admin"),true);

		$modulesList=ModMenuAdvHelper::getModules(1);
		$lang = JFactory::getLanguage();

		foreach ($modulesList as $m) {
			$lang->load($m->element . '.sys', JPATH_ADMINISTRATOR, null, false, true);
			$menu->addChild(new JMenuNode(JText::_($m->name), 'index.php?option=com_modules&task=module.add&eid='.$m->extension_id));
		}
		$menu->getParent();

		$menu->getParent();
	}

	if ($pm)
	{
		$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_EXTENSIONS_PLUGIN_MANAGER'), 'index.php?option=com_plugins', 'class:plugin'),true);

		$pluginTypes=ModMenuAdvHelper::getPluginTypes();
		foreach ($pluginTypes as $type) {
			$menu->addChild(new JMenuNode($type->folder, 'index.php?option=com_plugins', 'plugins-'.$type->folder),true);

			$plugins=ModMenuAdvHelper::getPlugins($type->folder);
			foreach ($plugins as $plugin) {
				$lang->load(strtolower($plugin->name) . '.sys', JPATH_SITE) || 
				$lang->load(strtolower($plugin->name) . '.sys', JPATH_ADMINISTRATOR) ||
				$lang->load(strtolower($plugin->name).'.sys',JPATH_SITE.'/plugins/'.$plugin->folder.'/'.$plugin->element);

				$class='enabled-plugin-custom';
				if($plugin->enabled!=1){
					$class="disabled-plugin-custom";
				}

				$menu->addChild(new JMenuNode(JText::_($plugin->name), 'index.php?option=com_plugins&task=plugin.edit&extension_id='.$plugin->extension_id,$class));
			}

			$menu->getParent();	
		}

		$menu->getParent();	
	}

	if ($tm)
	{
		$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_EXTENSIONS_TEMPLATE_MANAGER'), 'index.php?option=com_templates', 'class:themes'),true);
		// $menu->addChild(new JMenuNode(JText::_("MOD_MENU_ADV_EXTENSIONS_TEMPLATE_MANAGER_STYLES"), 'index.php?option=com_templates','list-styles'));

		$menu->addChild(new JMenuNode(JText::_("MOD_MENU_ADV_EXTENSIONS_TEMPLATE_MANAGER_STYLES"), 'index.php?option=com_templates','list-styles'),true);
		$styles=ModMenuAdvHelper::getStyles();
		foreach ($styles as $style) {
			$menuTitle=$style->title;
			if($style->client_id==1)
				$menuTitle.=" [admin]";
			$menu->addChild(new JMenuNode($menuTitle, 'index.php?option=com_templates&task=style.edit&id='.$style->id));
		}
		$menu->getParent();	

		$menu->addChild(new JMenuNode(JText::_("MOD_MENU_ADV_EXTENSIONS_TEMPLATE_MANAGER_TEMPLATES"), 'index.php?option=com_templates&view=templates','list-templates'),true);
		$templates=ModMenuAdvHelper::getTemplates();
		foreach ($templates as $tmpl) {
			$menuTitle=$tmpl->name;
			if($tmpl->client_id==1)
				$menuTitle.=" [admin]";
			$menu->addChild(new JMenuNode($menuTitle, 'index.php?option=com_templates&view=template&id='.$tmpl->extension_id));
		}
		$menu->getParent();	
		
		$menu->getParent();	
	}

	if ($lm)
	{
		$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_EXTENSIONS_LANGUAGE_MANAGER'), 'index.php?option=com_languages', 'class:language'));
	}

	$menu->getParent();
}

/*
 * Help Submenu
 */
if ($showhelp == 1)
{
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_HELP'), '#'), true);
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_HELP_JOOMLA'), 'index.php?option=com_admin&view=help', 'class:help'));
	$menu->addSeparator();

	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_HELP_SUPPORT_OFFICIAL_FORUM'), 'http://forum.joomla.org', 'class:help-forum', false, '_blank'));

	if ($forum_url = $params->get('forum_url'))
	{
		$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_HELP_SUPPORT_CUSTOM_FORUM'), $forum_url, 'class:help-forum', false, '_blank'));
	}

	$debug = $lang->setDebug(false);

	if ($lang->hasKey('MOD_MENU_ADV_HELP_SUPPORT_OFFICIAL_LANGUAGE_FORUM_VALUE') && JText::_('MOD_MENU_ADV_HELP_SUPPORT_OFFICIAL_LANGUAGE_FORUM_VALUE') != '')
	{
		$forum_url = 'http://forum.joomla.org/viewforum.php?f=' . (int) JText::_('MOD_MENU_ADV_HELP_SUPPORT_OFFICIAL_LANGUAGE_FORUM_VALUE');
		$lang->setDebug($debug);
		$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_HELP_SUPPORT_OFFICIAL_LANGUAGE_FORUM'), $forum_url, 'class:help-forum', false, '_blank'));
	}

	$lang->setDebug($debug);
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_HELP_DOCUMENTATION'), 'http://docs.joomla.org', 'class:help-docs', false, '_blank'));
	$menu->addSeparator();

	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_HELP_EXTENSIONS'), 'http://extensions.joomla.org', 'class:help-jed', false, '_blank'));
	$menu->addChild(
		new JMenuNode(JText::_('MOD_MENU_ADV_HELP_TRANSLATIONS'), 'http://community.joomla.org/translations.html', 'class:help-trans', false, '_blank')
	);
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_HELP_RESOURCES'), 'http://resources.joomla.org', 'class:help-jrd', false, '_blank'));
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_HELP_COMMUNITY'), 'http://community.joomla.org', 'class:help-community', false, '_blank'));
	$menu->addChild(
		new JMenuNode(JText::_('MOD_MENU_ADV_HELP_SECURITY'), 'http://developer.joomla.org/security.html', 'class:help-security', false, '_blank')
	);
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_HELP_DEVELOPER'), 'http://developer.joomla.org', 'class:help-dev', false, '_blank'));
	$menu->addChild(new JMenuNode(JText::_('MOD_MENU_ADV_HELP_SHOP'), 'http://shop.joomla.org', 'class:help-shop', false, '_blank'));
	$menu->getParent();
}
