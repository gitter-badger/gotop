<?php
	/*
	 * G4HDU Goto Top plugin
	 *
	 * Copyright (C) 2008-2016 Barry Keal G4HDU http://e107.keal.me.uk
	 * blankd under the terms and conditions of the
	 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
	 *
	 * @author Barry Keal e107@keal.me.uk>
	 * @copyright Copyright (C) 2008-2016 Barry Keal G4HDU
	 * @license GPL
	 * @version 1.0.0
	 *
	 *
	*/

	require_once("../../class2.php");
	if (!getperms("P")) {
		e107::redirect('admin');
		exit;
	}
	require_once('colorcodes.php');
	/**
	 * This is class plugingotop_admin
	 * 
	 * @author Barry Keal G4HDU
	 * 
	 * @version 1.0.0
	 * @since 1.0.0
	 */
	class plugingotop_admin extends e_admin_dispatcher {
		/**
		* Format: 'MODE' => array('controller' =>'CONTROLLER_CLASS'[, 'index' => 'list', 'path' => 'CONTROLLER SCRIPT PATH', 'ui' => 'UI CLASS NAME child of e_admin_ui', 'uipath' => 'UI SCRIPT PATH']);
		* Note - default mode/action is autodetected in this order:
		* - $defaultMode/$defaultAction (owned by dispatcher - see below)
		* - $adminMenu (first key if admin menu array is not empty)
		* - $modes (first key == mode, corresponding 'index' key == action)
		*
		* @var array
		*/
		protected $modes = array(
			'main' => array('controller' => 'plugingotop_admin_ui',
				'path' => null,
				'ui' => 'plugingotop_admin_form_ui', 'uipath' => null)
			);

		/**
		* Format: 'MODE/ACTION' => array('caption' => 'Menu link title'[, 'url' => '{e_PLUGIN}blank/admin_config.php', 'perm' => '0']);
		* Additionally, any valid e107::getNav()->admin() key-value pair could be added to the above array
		*
		* @var array
		*/
		protected $adminMenu = array(
			'main/prefs' => array('caption' => 'Settings', 'perm' => '0'),
			);

		/**
		* Optional, mode/action aliases, related with 'selected' menu CSS class
		* Format: 'MODE/ACTION' => 'MODE ALIAS/ACTION ALIAS';
		* This will mark active main/list menu item, when current page is main/edit
		*
		* @var array
		*/
		protected $adminMenuAliases = array(
			'main/edit' => 'main/list'
			);

		/**
		* Navigation menu title
		*
		* @var string
		* @since 1.0.0
		*/
		protected $menuTitle = LAN_PLUGIN__GOTOP_ADMIN_MENU;
	}
	/**
	 * This is class plugingotop_admin_ui
	 *
	 */
	class plugingotop_admin_ui extends e_admin_ui {
		/**
		 * $pluginTitle
		 *
		 * @var string  name of plugin - Goto Top
		 * @since 1.0.0
		 */
		protected $pluginTitle = LAN_PLUGIN__GOTOP_NAME;

		/**
		* The name of the plugin - gotop
		* 
		* @var string
		* @since 1.0.0
		*/
		protected $pluginName = 'gotop';
		/**
		* Array containing a list of tabs to be displayed on the page
		*
		* @var array of strings
		* @since 1.0.0 
		*
		*/
		protected $preftabs = array(
			0 => LAN_PLUGIN__GOTOP_ADMIN_TAB0,
			1 => LAN_PLUGIN__GOTOP_ADMIN_TAB1,
			2 => LAN_PLUGIN__GOTOP_ADMIN_TAB2);
		/**
		 * Plugin Preferences
		 *
		 * @var mixed array of plugin preferences
		 * @since 1.0.0
		 *
		 */        
		protected $prefs;

		/**
		 * plugingotop_admin_ui::setPrefs()
		 *
		 * @return void
		 * @version 1.0.0
		 * @since 1.0.0
		 */
		private function setPrefs()
		{
			include('colorcodes.php'); // separate file with all the colours and their hex equivalent

			$this->prefs = array(
				'gotop_Active' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_ACTIVE,
						'help'=> LAN_PLUGIN__GOTOP_ADMIN_ACTIVE_HELP,
						'type' => 'boolean',
						'data' => 'integer',
						'validate' => false,
						'tab' => 0
						),
					
					'gotop_Admin' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_ADMIN,
						'help'=>LAN_PLUGIN__GOTOP_ADMIN_ADMIN_HELP,
						'type' => 'boolean',
						'data' => 'integer',
						'validate' => false,
						'tab' => 0
						),

					'gotop_size' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_SIZE,
						'help'  => LAN_PLUGIN__GOTOP_ADMIN_SIZE_HELP ,
						'type' => 'dropdown',
						'data' => 'str',
						'tab' => 0,
						'validate' => false,
						
						'writeParms' => array(
							'optArray' => array(
								'24' => "24 px",
								'36' => "36 px",
								'48' => "48 px",
								'60' => "60 px",
								'72' => "72 px",
								'84' => "84 px",
								'96' => "96 px",
								)
							)),
					
					'gotop_location' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_LOCATION,
						'type' => 'dropdown',
						'help' => LAN_PLUGIN__GOTOP_ADMIN_LOCATION_HELP,
						'data' => 'str',
						'tab' => 0,
						'validate' => false,
						
						'writeParms' => array(
							'optArray' => array(
								'tl' => LAN_PLUGIN__GOTOP_ADMIN_LOCATION_TL,
								'tr' =>LAN_PLUGIN__GOTOP_ADMIN_LOCATION_TR,
								'bl' =>LAN_PLUGIN__GOTOP_ADMIN_LOCATION_BL,
								'br' => LAN_PLUGIN__GOTOP_ADMIN_LOCATION_BR,
								)
							)),
					
					'gotop_HOffset' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_HORIZONTAL,
						'help' => LAN_PLUGIN__GOTOP_ADMIN_HORIZONTAL_HELP,
						'type' => 'number',
						'data' => 'int',
						'tab' => 0,
						'validate' => false,
						
						'writeParms' => array(
							'max' => 50,
							'min' => 10
							)
						),
					
					'gotop_VOffset' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_VERTICAL,
						'help' => LAN_PLUGIN__GOTOP_ADMIN_VERTICAL_HELP,
						'type' => 'number',
						'data' => 'int',
						'tab' => 0,
						'validate' => false,
						
						'writeParms' => array(
							'max' => 50,
							'min' => 10
							)
						),

					'gotop_iconColour' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_COLOUR,
						'help' => LAN_PLUGIN__GOTOP_ADMIN_COLOUR_HELP,
						'type' => 'dropdown',
						'data' => 'string',
						'validate' => false,
						'tab' => 1,

						'writeParms' => array(
							'optArray' => $colourCodes,
							'class' => 'colorpicker')
						),
					'gotop_iconHover' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_HOVER,
						'help' => LAN_PLUGIN__GOTOP_ADMIN_HOVER_HELP,
						'type' => 'dropdown',
						'data' => 'string',
						'validate' => false,
						'tab' => 1,

						'writeParms' => array(
							'optArray' => $colourCodes,
							'class' => 'colorpicker')
						),

					'gotop_backgroundColour' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_BACKGROUND,
						'help' => LAN_PLUGIN__GOTOP_ADMIN_BACKGROUND_HELP,
						'type' => 'dropdown',
						'data' => 'string',
						'validate' => false,
						'tab' => 1,
						
						'writeParms' => array(
							'optArray' => $colourCodes,
							'class' => 'colorpicker')
						),
					
					'gotop_backgroundHover' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_BACKGROUNDHOVER,
						'help' =>LAN_PLUGIN__GOTOP_ADMIN_BACKGROUNDHOVER_HELP,
						'type' => 'dropdown',
						'data' => 'string',
						'validate' => false,
						'tab' => 1,

						'writeParms' => array(
							'optArray' => $colourCodes,
							'class' => 'colorpicker')
						),
					
					'gotop_Text' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_TOP,
						'help'  => LAN_PLUGIN__GOTOP_ADMIN_TOP_HELP,
						'type'  => 'boolean',
						'data'  => 'integer',
						'validate' => false,
						'tab'   => 1
						),

					'gotop_borderWidth' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_BORDERWIDTH,
						'help' => LAN_PLUGIN__GOTOP_ADMIN_BORDERWIDTH_HELP,
						'type' => 'number',
						'data' => 'int',
						'tab' => 2,
						'validate' => false,
						
						'writeParms' => array(
							'max' => 5,
							'min' => 1
							)
						),
					
					'gotop_borderShown' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_BORDERSHOWN,
						'help' => LAN_PLUGIN__GOTOP_ADMIN_BORDERSHOWN_HELP,
						'type' => 'boolean',
						'data' => 'integer',
						'validate' => false,
						'tab' => 2,),
					
					'gotop_borderColour' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_BORDERCOLOUR,
						'help' => LAN_PLUGIN__GOTOP_ADMIN_BORDERCOLOUR_HELP,
						'type' => 'dropdown',
						'data' => 'string',
						'validate' => false,
						'tab' => 2,

						'writeParms' => array(
							'optArray' => $colourCodes,
							'class' => 'colorpicker',
							)
						),
					
					'gotop_borderHover' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_BORDERHOVER,
						'help' => LAN_PLUGIN__GOTOP_ADMIN_BORDERHOVER_HELP,
						'type' => 'dropdown',
						'data' => 'string',
						'validate' => false,
						'tab' => 2,

						'writeParms' => array(
							'optArray' => $colourCodes,
							'class' => 'colorpicker')
						),
					
					'gotop_corners' => array(
						'title' => LAN_PLUGIN__GOTOP_ADMIN_CORNER,
						'help' => LAN_PLUGIN__GOTOP_ADMIN_CORNER_HELP,
						'type' => 'dropdown',
						'data' => 'integer',
						'validate' => false,
						'tab' => 2,

						'writeParms' => array(
							'optArray' => array(
								'0' => "Square",
								'1' => "Rounded",
								'2' => "Circular"
								)
							)),
					) ;
		}
		/**
		 * Called when class created
		 *
		 * @return void
		 *
		 * @version 1.0.0
		 * @since 1.0.0
		 */
		public function init()
		{
			$this->setPrefs();
		}
	}

	class plugingotop_admin_form_ui extends e_admin_form_ui {
		function blank_type($curVal, $mode) // not really necessary since we can use 'dropdown' - but just an example of a custom function.
		{
			$frm = e107::getForm();

			$types = array('type_1' => "Type 1", 'type_2' => 'Type 2');

			if ($mode == 'read') {
				return vartrue($types[$curVal]) . ' (custom!)';
			}

			if ($mode == 'batch') { // Custom Batch List for blank_type
				return $types;
			}

			if ($mode == 'filter') { // Custom Filter List for blank_type
				return $types;
			}

			return $frm->select('blank_type', $types, $curVal);
		}
	}

	/*
	 * After initialization we'll be able to call dispatcher via e107::getAdminUI()
	 * so this is the first we should do on admin page.
	 * Global instance variable is not needed.
	 * NOTE: class is auto-loaded - see class2.php __autoload()
	 */
	/* $dispatcher = */

	new plugingotop_admin();

	/*
	 * Uncomment the below only if you disable the auto observing above
	 * Example: $dispatcher = new plugingotop_admin(null, null, false);
	 */
	// $dispatcher->runObservers(true);
	require_once(e_ADMIN . "auth.php");

	/*
	 * Send page content
	 */
	e107::getAdminUI()->runPage();

	require_once(e_ADMIN . "footer.php");

?>