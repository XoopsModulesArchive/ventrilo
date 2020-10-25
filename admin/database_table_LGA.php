<?php
// -------------------------------------------------------------------------
//	AceWeb
//		Copyright 2004, Andrew Johns & Micheal Wilkes
// 		strathnet.cable.nu
//	Template
//		Copyright 2004 Thomas Hill
//		<a href="http://www.worldware.com">worldware.com</a>
// -------------------------------------------------------------------------
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
// ------------------------------------------------------------------------- //

require_once dirname(__DIR__, 3) . '/include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/modules/aceweb/include/aceweb_includes.php';

if (file_exists('../language/' . $xoopsConfig['language'] . '/modinfo.php')) {
    require_once '../language/' . $xoopsConfig['language'] . '/modinfo.php';
} else {
    require_once '../language/english/modinfo.php';
}
require_once XOOPS_ROOT_PATH . '/modules/aceweb/admin/menu.php';

// Get HTTP post/get parameters.
import_request_variables('gp', 'param_');

//
// Writes out the form to get all config parameters.
//
function aceweb_table_one_edit_form()
{
    aceweb_table_one_form(true, _AM_ACEWEB_LABEL_ACE_ONE_EDIT);

    aceweb_table_one_del_form();
}

function aceweb_table_one_add_form()
{
    aceweb_table_one_form(false, _AM_ACEWEB_LABEL_ACE_ONE_ADD);
}

//
// Writes out the form used for adding a row, and editing a row
// $edit === true writes out a form to edit an existing row
// $edit === false writes out a form to add a new row
// returns nothing
//
function aceweb_table_one_form($editing, $heading)
{
    global $param_table_one_key;

    global $xoopsDB;

    if ($editing) {
        [$result, $error] = aceweb_get_table_one_result($param_table_one_key);

        if ($error) {
            printf(_AM_ACEWEB_FMT_ERROR, $error['msg'], $error['data']);

            return;
        }

        $values = $xoopsDB->fetchArray($result);
    }

    print "
    <form action='database_table_LGA.php' method='POST' enctype='application/x-www-form-urlencoded'>\n
    <table border='1' cellpadding='0' cellspacing='0' width='100%'>\n
        <tr><th>$heading</th></tr>\n
        <tr>\n
        <td class='bg2'>\n
            <table width='100%' border='0' cellpadding='4' cellspacing='1'>\n";

    $field_list = aceweb_get_LGA_fields();

    foreach ($field_list as $field => $prompt) {
        $pname = 'param_' . $field;

        if ($editing or ('table_one_key' != $field)) {
            print "
					<tr nowrap='nowrap'>\n
					<td class ='head'>" . $prompt . "</td>\n
	                <td class='even'>\n";

            if ('table_one_key' == $field) {
                print $values[$field];

                print "<input type='hidden' name='table_one_key' value='" . $values[$field] . "'>\n";
            } else {
                print "<input type='text' name='$field' size='32' maxlength='256' value =\"";

                if ($editing) {
                    //							$clean_string = str_replace("\"", "'", $values[$field]);

                    $clean_string = htmlentities($values[$field], ENT_QUOTES | ENT_HTML5);

                    print $clean_string;
                }

                print "\">\n";
            }

            print "</td>\n";

            print "</tr>\n";
        }
    }

    print "<tr>
                <td class='head'>&nbsp;</td>\n
                <td class='even'>\n";

    print "<input type='hidden' name='op' value='edit_post'>\n
                <input type='hidden' name='window' value='config'>\n
                <input type='submit' value='" . _AM_ACEWEB_BUT_SAVE . "'>\n
                </td></tr>\n
            </table>\n
        </td></tr>\n
    </table>\n
    </form>\n";
}

//
// Writes out the form used for deleting
// returns nothing
//
function aceweb_table_one_del_form()
{
    global $param_table_one_key;

    $heading = _AM_ACEWEB_LABEL_ACE_ONE_DEL;

    print "
    <form action='database_table_LGA.php' method='POST' enctype='application/x-www-form-urlencoded'>\n
    <table border='1' cellpadding='0' cellspacing='0' width='100%'>\n
        <tr><th>$heading</th></tr>\n
        <tr>\n
        <td class='bg2'>\n
            <table width='100%' border='0' cellpadding='4' cellspacing='1'>\n";

    print "<tr>
                <td class='head'>$heading</td>\n
                <td class='even'>\n
                    <input type='hidden' name='op' value='del_post'>\n
                    <input type='hidden' name='table_one_key' value='$param_table_one_key'>\n
                    <input type='submit' value='" . _AM_ACEWEB_BUT_DELETE . "'>\n
                </td></tr>\n
            </table>\n
        </td></tr>\n
    </table>\n
    </form>\n";
}

//
// Gets a the category that is currently stored in the database.
// returns array($result, $errormessage)
// if no error, $errormessage is null
//
function aceweb_get_table_one_result($table_one_key = null)
{
    global $xoopsDB;

    $bci = aceweb_get_LGA_fields();

    $sql = 'select ' . aceweb_to_string($bci) . ' from ' . $xoopsDB->prefix('aceweb_LGA');

    if (null != $LGA_key) {
        // Make sure $table_one_key is valid, since it comes from the user.

        // A cracker could set it to some sql string

        if (!is_numeric($table_one_key)) {
            $error = ['msg' => _AM_ACEWEB_ERR_table_one_BAD_KEY, 'data' => $sql];

            return [null, $error];
        }

        $sql .= " where LGA_key = $LGA_key";
    }

    $result = $xoopsDB->query($sql);

    if (!$result) {
        $error = ['msg' => $xoopsDB->error(), 'data' => $sql];

        return [null, $error];
    }

    return [$result, null];
}

//
// Writes out the form used for selecting a row to edit
// returns nothing
//
function aceweb_table_one_main_select()
{
    $method = 'POST'; // POST, except when debugging

    global $xoopsDB;

    [$result, $error] = aceweb_get_table_one_result();

    if ($error) {
        printf(_AM_ACEWEB_FMT_ERROR, $error['msg'], $error['data']);

        return;
    }

    print "<table border='1' cellpadding='0' cellspacing='0' width='100%'>\n";

    print "<tr>\n";

    print "<td class='bg2'>\n";

    print "<table width='100%' border='0' cellpadding='4' cellspacing='1'>\n";

    print '<tr>';

    $field_list = aceweb_get_LGA_fields();

    foreach ($field_list as $field => $prompt) {
        print "<th>$prompt</th>\n";
    }

    print '<th>' . _AM_ACEWEB_LABEL_ACE_ONE_EDIT2 . "</th>\n";

    print "</tr>\n";

    $are_there_any = false;

    while (false !== ($values = $xoopsDB->fetchArray($result))) {
        $are_there_any = true;

        print "<tr nowrap='nowrap'>\n";

        $limit = 64;

        foreach ($values as $field => $value) {
            print "<td class='even' valign = 'top' >\n";

            $value = htmlentities($value, ENT_QUOTES | ENT_HTML5);

            if (mb_strlen($value) > $limit) {
                $value = mb_substr($value, 0, $limit) . '...';
            }

            print $value;

            print "</td>\n";
        }

        print "<td class='even' valign = 'top'>\n";

        print "<form action='database_table_LGA.php' method='$method' enctype='application/x-www-form-urlencoded'>\n";

        print "<input type='hidden' name='table_one_key' value='" . $values['table_one_key'] . "'>\n";

        print "<input type='hidden' name='op' value='select_post'>\n";

        print "<input type='submit' value='" . _AM_ACEWEB_BUT_EDIT . "'>\n";

        print "</form>\n";

        print "</td>\n";

        print "</tr>\n";
    }

    if (!$are_there_any) {
        print "<tr><td class = 'even' colspan = '" . (count($field_list) + 1) . "'>" . _AM_ACEWEB_ERR_ACE_ONE_NONE . '</td></tr>';
    }

    print "</table>\n";

    print "</td></tr>\n";

    print "</table>\n";
}

//
// Displays the main admin interface
//
function aceweb_main()
{
    $p_title = _AM_ACEWEB_ACE_ONE_TITLE;

    xoops_cp_header();

    print "<h4 style='text-align:left;'>$p_title</h4>";

    aceweb_admin_hmenu();

    aceweb_table_one_add_form();

    aceweb_table_one_main_select();

    xoops_cp_footer();

    exit();
}

//
// Edit one row from table_one
//
function aceweb_table_one_main_select_post()
{
    xoops_cp_header();

    $p_title = _AM_ACEWEB_ACE_ONE_TITLE;

    print "<h4 style='text-align:left;'>$p_title</h4>";

    aceweb_admin_hmenu();

    aceweb_table_one_edit_form();

    xoops_cp_footer();

    exit();
}

//
// Delete one row from table_one
//
function aceweb_table_one_delete()
{
    global $xoopsDB;

    global $param_table_one_key;

    $sql = 'delete from ' . $xoopsDB->prefix('aceweb_LGA') . ' where LGA_key = ' . "'" . $GLOBALS['xoopsDB']->escape($param_table_one_key) . "'";

    if (!$xoopsDB->query($sql)) {
        $error = $xoopsDB->error();

        xoops_cp_header();

        aceweb_show_sql_error(_AM_ACEWEB_ERR_DELETE_FAILED, $error, $sql);

        xoops_cp_footer();
    } else {
        redirect_header('database_table_LGA.php', 1, _AM_ACEWEB_OK_DB);
    }

    exit();
}

// Processes the configuration update request, by
// getting the HTTP parameters, and putting them into the database.
function aceweb_table_one_update()
{
    global $xoopsDB;

    $field_list = aceweb_get_LGA_fields();

    foreach ($field_list as $field => $prompt) {
        $param = 'param_' . $field;

        global $$param;
    }

    $sql = 'REPLACE INTO  ' . $xoopsDB->prefix('aceweb_LGA') . ' (' . aceweb_to_string($field_list) . ') VALUES (';

    $first = true;

    foreach ($field_list as $field => $prompt) {
        $param = 'param_' . $field;

        $param_value = $$param;

        if (function_exists('get_magic_quotes_gpc') && @get_magic_quotes_gpc()) {
            $param_value = stripslashes($param_value);
        }

        if (!$first) {
            $sql .= ', ';
        }

        $param_value = get_magic_quotes_gpc() ? stripslashes($$param) : $$param;

        $sql .= "'" . $GLOBALS['xoopsDB']->escape($param_value) . "'";

        $first = false;
    }

    $sql .= ' )';

    if (!$xoopsDB->query($sql)) {
        $error = $xoopsDB->error();

        xoops_cp_header();

        aceweb_show_sql_error(_AM_ACEWEB_ERR_REPLACE_FAILED, $error, $sql);

        xoops_cp_footer();
    } else {
        redirect_header('database_table_LGA.php', 1, _AM_ACEWEB_OK_DB);
    }

    exit();
}

if (!isset($param_op)) {
    $param_op = 'main';
}

switch ($param_op) {
    case 'main':
        aceweb_main();
        break;
    case 'select_post':
        aceweb_table_one_main_select_post();
        break;
    case 'edit_post':
        aceweb_table_one_update();
        break;
    case 'add_post':
        aceweb_table_one_add();
        break;
    case 'del_post':
        aceweb_table_one_delete();
        break;
    default:
        xoops_cp_header();
        print "<h1>Unknown method requested '$param_op'</h1>";
        xoops_cp_footer();
}
