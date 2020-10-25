<?php
// -------------------------------------------------------------------------
//	Ventrilo
//		Copyright 2004, Kheldar
// 		pyrosoft.cable.nu
//	Template
//		Copyright 2004 Thomas Hill
//		<a href="http://www.worldware.com">worldware.com</a>
// -------------------------------------------------------------------------
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

// Include any constants used for internationalizing templates.
if (file_exists(XOOPS_ROOT_PATH . '/modules/ventrilo/language/' . $xoopsConfig['language'] . '/templates.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/language/' . $xoopsConfig['language'] . '/templates.php';
} else {
    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/language/english/templates.php';
}
// Include any common code for this module.
require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilo_includes.php';

function b_ventrilo_do_db_block()
{
    global $xoopsDB;

    // You can get values from xoops_version.php

    // For example, if xoops_version.php has this line (and this is block 1)

    //	$modversion['blocks'][1]['options']	= 1 | "two";

    // Then uncomment the next line

    // $option_value = ($options) ? $options[0] : 128;

    // To retrieve the value 1, (or a default of 128, if not set.)

    $block = [];

    $whereClause = ventrilo_get_config_item('config_block_config_main_server');

    $limit = '1';

    $queryString = 'SELECT table_one_char, table_one_text FROM ' . $xoopsDB->prefix('ventrilo_table_one') . " $whereClause";

    $error = null;

    $result = $xoopsDB->query($queryString);

    if (!$result) {
        $msg = $xoopsDB->error();

        if (!$msg) {
            $msg = 'An error occurred';
        }

        $error = ['msg' => $msg, 'data' => $queryString];
    }

    while (!$error and ($link = $xoopsDB->fetchArray($result))) {
        $block[] = $link;
    }

    $all = [
        'data' => $block,
        'lang' => ventrilo_get_intl(),
        'error' => $error,
    ];

    return $all;
}
