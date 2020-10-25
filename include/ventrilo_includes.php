<?php
// ------------------------------------------------------------------------- //
// Copyright 2004, Thomas Hill,                                              //
// <a href="http://www.worldware.com">worldware.com</a>                      //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

// Get the definitions for the strings used in the user interface.
if (file_exists(XOOPS_ROOT_PATH . '/modules/ventrilo/language/english/admin.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/language/english/admin.php';
} else {
    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/language/english/admin.php';
}

//
// Formats an array as a comma delimited string
//
function ventrilo_to_string($assoc_array)
{
    $str = '';

    foreach ($assoc_array as $key => $value) {
        if (0 != mb_strlen($str)) {
            $str .= ', ';
        }

        $str .= $key;
    }

    return $str;
}

//
// Shows the error message and query for a failed database access
//
function ventrilo_show_sql_error($title, $error, $sql)
{
    print "<table>\n" . "<TR><TH colspan = '2'>$title</TH></TR>\n" . "<TR><TD class='head' valign = 'top'>" . _AM_VENTRILO_ERR_ERROR . "</TD><TD class='even'>$error</TD></TR>\n" . "<TR><TD class='head' valign = 'top'>" . _AM_VENTRILO_ERR_QUERY . "</TD><TD class='even'>$sql</TD></TR>\n" . "</table>\n";
}

//
// Formats and returns a horizontal menu
//
function ventrilo_hmenu($menu_def)
{
    $str = '<P>';

    $first = true;

    foreach ($menu_def as $menu_title => $menu_link) {
        if ($first) {
            $first = false;
        } else {
            $str .= '| ';
        }

        $str .= "<a href='" . $menu_link . "'>" . $menu_title . '</a> ';
    }

    $str .= '</p>';

    return $str;
}

//
// Displays the horizontal menu for Ventrilo administration
//
function ventrilo_admin_hmenu()
{
    // ZZZFix this. Clean up menu sharing.

    global $adminmenu;

    print '<table><tr>';

    $first = true;

    foreach ($adminmenu as $menu_item) {
        print "<td>\n";

        $link = $menu_item['link'];

        $link = '../' . $link;

        if ($first) {
            $first = false;
        } else {
            print '| ';
        }

        print "<a href='" . $link . "'";

        if (isset($menu_item['target'])) {
            print " target='" . $menu_item['target'] . "'";
        }

        print '>' . $menu_item['title'] . '</a>';

        print "</td>\n";
    }

    print '</tr></table><BR>';
}

//
// Loads the strings used for internationalizing the templates into the current template
//
function ventrilo_add_intl()
{
    global $xoopsTpl;

    $intl = ventrilo_get_intl();

    $xoopsTpl->assign('lang', $intl);
}

//
// Returns an associative array, with the constants used for internationalizing the templates
// This allows a module to run in multiple languages at a time (each user can choose a language)
//
function ventrilo_get_intl()
{
    $intl = [
        'block_title' => _AM_VENTRILO_LANG_BLOCK_TITLE,
        'block_title1' => _AM_VENTRILO_LANG_BLOCK_TITLE1,
        'error' => _AM_VENTRILO_LANG_ERROR,
        'sample' => _AM_VENTRILO_LANG_SAMPLE,
        'welcome' => _AM_VENTRILO_LANG_WELCOME,
    ];

    return $intl;
}

//
// Gets the configuration that is currently stored in the database.
// $param is the name of the field we want to retrieve
// $config is the configuration record from the database.
//			If you are querying multiple values, you can reuse the config object
//			instead of querying the database for each field.
//	$default_value The default value for the parameter
//
function ventrilo_get_config_item($param, $config = null, $default_value = 7)
{
    if (!$config) {
        $config = ventrilo_get_config();
    }

    $config_item = $config[$param];

    if ($config_item < 0) {
        $config_item = $default_value;
    }

    return $config_item;
}

//
// Gets the configuration that is currently stored in the database.
//
function ventrilo_get_config()
{
    global $xoopsDB;

    $bci = ventrilo_get_config_fields();

    $sql = 'select ' . ventrilo_to_string($bci) . ' from ' . $xoopsDB->prefix('ventrilo_config');

    $result = $xoopsDB->query($sql);

    if (!$result) {
        $error = $xoopsDB->error();

        ventrilo_show_sql_error(_AM_VENTRILO_ERR_QUERY_FAILED, $error, $sql);

        return null;
    }

    $values = $xoopsDB->fetchArray($result);

    return $values;
}

//
// Gets a list of the fields in the configuration database
//
function ventrilo_get_config_fields()
{
    // ZZZ We need to generate this from the database schema

    $config_info = [
        // Database field			// Name used in web user interface.
        'config_id' => 'X ERROR X',
        'config_main_server' => _AM_VENTRILO_LABEL_CONFIG_MAIN_SERVER,
        'config_server' => _AM_VENTRILO_LABEL_CONFIG_SERVER,
        'config_server_label' => _AM_VENTRILO_LABEL_CONFIG_SERVER_label,
        'config_server_color' => _AM_VENTRILO_LABEL_CONFIG_SERVER_color,
        'config_main_ExternalServer' => _AM_VENTRILO_LABEL_CONFIG_MAIN_ExternalServer,
        'config_main_ExternalServer_label' => _AM_VENTRILO_LABEL_CONFIG_MAIN_ExternalServer_label,
        'config_main_ExternalServer_color' => _AM_VENTRILO_LABEL_CONFIG_MAIN_ExternalServer_color,
        'config_cmdhost' => _AM_VENTRILO_LABEL_CONFIG_CMDHOST,
        'config_cmdport' => _AM_VENTRILO_LABEL_CONFIG_CMDPORT,
        'config_webport' => _AM_VENTRILO_LABEL_CONFIG_webPORT,
        'config_cmdpass' => _AM_VENTRILO_LABEL_CONFIG_CMDPASS,
        'config_cmdhost2' => _AM_VENTRILO_LABEL_CONFIG_CMDHOST2,
        'config_cmdport2' => _AM_VENTRILO_LABEL_CONFIG_CMDPORT2,
        'config_webport2' => _AM_VENTRILO_LABEL_CONFIG_webPORT2,
        'config_cmdpass2' => _AM_VENTRILO_LABEL_CONFIG_CMDPASS2,
        'number_of_servers' => _AM_VENTRILO_LABEL_number_of_servers,
        'colorrow1' => _AM_VENTRILO_LABEL_CONFIG_SERVER_colorrow1,
        'colorrow2' => _AM_VENTRILO_LABEL_CONFIG_SERVER_colorrow2,
        'colorlobby' => _AM_VENTRILO_LABEL_CONFIG_SERVER_colorlobby,
        'colorlobbyhead' => _AM_VENTRILO_LABEL_CONFIG_SERVER_colorlobbyhead,
        'colorlobbyuser' => _AM_VENTRILO_LABEL_CONFIG_SERVER_colorlobbyuser,
        'colorrowserver1' => _AM_VENTRILO_LABEL_CONFIG_SERVER_colorrowserver1,
        'colorrowserver2' => _AM_VENTRILO_LABEL_CONFIG_SERVER_colorrowserver2,
        'colortitleserver1' => _AM_VENTRILO_LABEL_CONFIG_SERVER_colortitleserver1,
        'colortitleserver2' => _AM_VENTRILO_LABEL_CONFIG_SERVER_colortitleserver2,
        'displayinternal' => _AM_VENTRILO_LABEL_CONFIG_SERVER_displayinternal,
    ];

    return $config_info;
}

//
// Gets the value as a string. If the value is an array, it concatenates the elements, separated by spaces.
//
function ventrilo_get_value($v)
{
    if (!is_array($v)) {
        return $v;
    }

    $str = '';

    $first = true;

    foreach ($v as $i) {
        if (!$first) {
            $str .= ', ';
        }

        $str .= $i;

        $first = false;
    }

    return $str;
}

//
// Returns a list of all the fields in table_one
//
function ventrilo_get_table_one_fields()
{
    // ZZZ We need to generate this from actual database field list.

    return [
        // Field										   Prompt
        'table_one_key' => 'table_one_key',
        'table_one_char' => 'table_one_char',
        'table_one_text' => 'table_one_text',
    ];
}
