<?php
	/**
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

if (!defined('e107_INIT')) {
    exit;
}
// error_reporting(E_ALL);
gotop::gotop();

/**
* gotop
*
* @package
* @author Barry
* @copyright Copyright (c) 2016
* @version $Id$
* @access public
*/
class gotop {
    private static $gotopPrefs; // all the preferences for the plugin
    private static $size; // size of the goto top in px
    private static $Active; // activate the plugin
    private static $Admin; // show on admin pages
    private static $HOffset; // horizontal offset in px
    private static $VOffset; // vertical offset in px
    private static $Position; // Which corner of the screen TL TR BL or BR(default)
    private static $width; // width of gotop
    private static $height; // height of gotop
    private static $padding; // padding around the
    private static $showText; // show or hide the word Top in the icon
    private static $topFontSize; //
    private static $background; // background colour
    private static $backgroundColour; // background colour
    private static $backgroundHover; // background colour when hovering
    private static $borderWidth; // width of border in px
    private static $borderColour; // border colour
    private static $borderHover; // border colour when hovering
    private static $borderShown; // show or hide the border
    private static $borderRadius; // border radius (if any)
    private static $borderCorner; // size of radius
    private static $iconSize; // size of the arrow
    private static $iconColour; // colour of the arrow
    private static $iconHover; // colour of the arrow when hovering
    /**
    * gotop::__construct()
    */
    function __construct()
    {
    }
    /**
    * gotop::gotop()
    * 
	* @param void
	* @return void
	* @version 1.0.0
	* @since 1.0.0
	* @author Barry Keal G4HDU
	* 
    */
    public static function gotop()
    {
        self::$gotopPrefs = e107::getPlugConfig('gotop', true);
        self::$Active = self::$gotopPrefs->getPref('gotop_Active', 1);

        if (self::$Active) {
        	self::$Admin = self::$gotopPrefs->getPref('gotop_Admin', 0);
            if (self::$Admin || USER_AREA) {
                self::$size = self::$gotopPrefs->getPref('gotop_size', 1);
                self::$HOffset = self::$gotopPrefs->getPref('gotop_HOffset', 30);
                self::$VOffset = self::$gotopPrefs->getPref('gotop_VOffset', 30);
                self::$showText = self::$gotopPrefs->getPref('gotop_Text', 1);

                self::$iconColour = self::resolveColour('gotop_iconColour');
                self::$iconHover = self::resolveColour('gotop_iconHover');

                self::$backgroundColour = self::resolveColour('gotop_backgroundColour');
                self::$backgroundHover = self::resolveColour('gotop_backgroundHover');

                self::$borderShown = self::$gotopPrefs->getPref('gotop_borderShown', 0);
                self::$borderWidth = self::$gotopPrefs->getPref('gotop_borderWidth', 1);
                self::$borderCorner = self::$gotopPrefs->getPref('gotop_corners', 0);
                self::$borderColour = self::resolveColour('gotop_borderColour');
                self::$borderHover = self::resolveColour('gotop_borderHover');

                $Location = self::$gotopPrefs->getPref('gotop_location', 'br');
                switch ($Location) {
                    case 'tl':
                        self::$Position = "
			top:" . self::$VOffset . "px;
            left:" . self::$HOffset . "px;";
                        break;
                    case 'tr':
                        self::$Position = "
			top:" . self::$VOffset . "px;
            right:" . self::$HOffset . "px;";
                        break;
                    case 'bl':
                        self::$Position = "
			bottom:" . self::$VOffset . "px;
            left:" . self::$HOffset . "px;";
                        break;
                    case 'br':
                    default:
                        self::$Position = "
			bottom:" . self::$VOffset . "px;
            right:" . self::$HOffset . "px;";
                } // switch
                if (self::$showText) {
                    switch (self::$size) {
                        case 24:
                            self::$background = 24;
                            self::$width = 24;
                            self::$height = 24;
                            self::$padding = 2; ;
                            self::$iconSize = 10;
                            self::$topFontSize = 8;
                            break;
                        case 36:
                            self::$background = 36;
                            self::$width = 36;
                            self::$height = 36;
                            self::$padding = 2; ;
                            self::$iconSize = 15;
                            self::$topFontSize = 11;
                            break;
                        case 48:
                        default:
                            self::$background = 48;
                            self::$width = 48;
                            self::$height = 48;
                            self::$padding = 2;
                            self::$iconSize = 26;
                            self::$topFontSize = 13;
                            break; ;
                        case 60:
                            self::$background = 60;
                            self::$width = 60;
                            self::$height = 60;
                            self::$padding = 2; ;
                            self::$iconSize = 33;
                            self::$topFontSize = 16;
                            break;
                        case 72:
                            self::$background = 72;
                            self::$width = 72;
                            self::$height = 72;
                            self::$padding = 2; ;
                            self::$iconSize = 38;
                            self::$topFontSize = 19;
                            break;
                        case 84:
                            self::$background = 84;
                            self::$width = 84;
                            self::$height = 84;
                            self::$padding = 2; ;
                            self::$iconSize = 46;
                            self::$topFontSize = 22;
                            break;
                        case 96:
                            self::$background = 96;
                            self::$width = 96;
                            self::$height = 96;
                            self::$padding = 0;
                            self::$iconSize = 52;
                            self::$topFontSize = 26;
                            break;
                    } // switch
                } else {
                    switch (self::$size) {
                        case 24:
                            self::$background = 24;
                            self::$width = 24;
                            self::$height = 24;
                            self::$padding = 2; ;
                            self::$iconSize = 12; ;
                            break;
                        case 36:
                            self::$background = 36;
                            self::$width = 36;
                            self::$height = 36;
                            self::$padding = 2; ;
                            self::$iconSize = 18;
                            break;
                        case 48:
                        default:
                            self::$background = 48;
                            self::$width = 48;
                            self::$height = 48;
                            self::$padding = 2;
                            self::$iconSize = 24; ;
                            break; ;
                        case 60:
                            self::$background = 60;
                            self::$width = 60;
                            self::$height = 60;
                            self::$padding = 2; ;
                            self::$iconSize = 31;
                            break;
                        case 72:
                            self::$background = 72;
                            self::$width = 72;
                            self::$height = 72;
                            self::$padding = 2; ;
                            self::$iconSize = 37;
                            break;
                        case 84:
                            self::$background = 84;
                            self::$width = 84;
                            self::$height = 84;
                            self::$padding = 2; ;
                            self::$iconSize = 42;
                            self::$topFontSize = 18;
                            break;
                        case 96:
                            self::$background = 96;
                            self::$width = 96;
                            self::$height = 96;
                            self::$padding = 2;
                            self::$iconSize = 66;
                            self::$topFontSize = 18;
                            break;
                    } // switch
                }
                switch (self::$borderCorner) {
                    case 2:
                        self::$borderRadius = self::$height / 2;
                        break;
                    case 1:
                        self::$borderRadius = self::$height * .3;
                        break;
                    case 0:
                    default:
                        self::$borderRadius = 0;
                        break;
                }
            }
            self::outputJS();  // output the javascript
            self::outputCSS();  // output the css
        }
    }
	
		/**
		* gotop::resolveColour()
		* 
		* @param void
		* @return void
		* @version 1.0.0
		* @since 1.0.0
		* @author Barry Keal G4HDU
			* 
		*/

    protected static function resolveColour($thePref)
    {
        $tempColour = self::$gotopPrefs->getPref($thePref, 'trans');
        return ($tempColour == 'trans'?'transparent':'#' . $tempColour);
    }
	
		/**
		* gotop::resolveColour()
		* 
		* @param void
		* @return void
		* @version 1.0.0
		* @since 1.0.0
		* @author Barry Keal G4HDU
		* 
		*/
    function outputJS()
    {
        e107::js('inline', 'var gotopText=' . self::$showText . ';', 'jquery'); // loads e107_plugins/gotop/js/gotop.js
        e107::js('gotop', 'js/gotop.js', 'jquery'); // loads e107_plugins/gotop/js/gotop.js
    }
		/**
		* gotop::resolveColour()
		* 
		* @param void
		* @return void
		* @version 1.0.0
		* @since 1.0.0
		* @author Barry Keal G4HDU
		* 
		*/
    function outputCSS()    {
        e107::css('inline', '
	/* Goto Top */
	#gotopContainer{
		width:' . self::$width . 'px;
		height:' . self::$height . 'px;
		padding:' . self::$padding . 'px;
		border:' . self::$borderWidth . 'px solid;
		border-color: ' . self::$borderColour . ';
		color: ' . self::$iconColour . ';
		text-decoration: none;
		position:fixed;
		' . self::$Position . '
		display:none;
		background-color:' . self::$backgroundColour . ';
		border-radius:' . self::$borderRadius . 'px;
		z-index: 99;
	}
	#gotopInner{
		display:flex;
		flex-direction: column;
		height:100%;
		width:100%;
	}
	#gotopIcon{
		text-align:center;
		font-weight: bold;
		font-size:' . self::$iconSize . 'px;
		line-height:0.9em;
	}
	#gotopWord{
		font-size:' . self::$topFontSize . 'px;
		font-weight:normal;
		line-height:0.99em;
	}
	.scrollToTop:hover{
		text-decoration:none;
		background-color:' . self::$backgroundHover . ' !important;
		color: ' . self::$iconHover . ';
		border-color: ' . self::$borderHover . ' !important;
		border:' . self::$borderWidth . 'px solid;
		}
	'); // end of e107::css
    } // end outputCSS
} // end class

?>