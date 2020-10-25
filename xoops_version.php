<?php
// -------------------------------------------------------------------------
//	Ventrilo
//		Copyright 2004, Kheldar
// 		pyrosoft.cable.nu
//	Template
//		Copyright 2004 Thomas Hill
//		<a href="http://www.worldware.com">worldware.com</a>
// -------------------------------------------------------------------------
//  ------------------------------------------------------------------------ //
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

$modversion['name'] = _MI_VENTRILO_NAME;
$modversion['version'] = 0.69;
$modversion['description'] = _MI_VENTRILO_DESC;
$modversion['credits'] = 'Thomas Hill http://www.worldware.com';
$modversion['author'] = 'Kheldar';
$modversion['help'] = 'docs/ventrilo_admin.html';
$modversion['license'] = 'GPL';
$modversion['official'] = 0;
$modversion['image'] = 'images/ventrilo.png';
$modversion['dirname'] = 'ventrilo';

// SQL file
// This is preprocessed by xoops. The format must be constistant with
// output produced by PHPMYADMIN
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql (without prefix!)
$modversion['tables'][] = 'ventrilo_table_one';
$modversion['tables'][] = 'ventrilo_table_two';
$modversion['tables'][] = 'ventrilo_config';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

// Main contents
$modversion['hasMain'] = 1;

// Templates
$modversion['templates'][0]['file'] = 'ventrilo_index.html';
$modversion['templates'][0]['description'] = 'Ventrilo Template Page';

// Blocks (Start indexes with 1, not 0!)
// This is a simple block that just displays a fixed list.
$modversion['blocks'][1]['file'] = 'blocks.php';
$modversion['blocks'][1]['name'] = _MI_VENTRILO_BLOCK_ONE_TITLE;
$modversion['blocks'][1]['description'] = _MI_VENTRILO_BLOCK_ONE_DESC;
$modversion['blocks'][1]['show_func'] = 'b_ventrilo_do_block';
$modversion['blocks'][1]['template'] = 'ventrilo_block_one.html';
$modversion['blocks'][1]['options'] = 1 | 'two';

// This block displays a selection from the database, controlled by the configuration, which is set in
// module admin administration for Ventrilo
//$modversion['blocks'][2]['file'] = "blocks_db.php";
//$modversion['blocks'][2]['name'] = _MI_VENTRILO_BLOCK_TWO_TITLE;
//$modversion['blocks'][2]['description'] = _MI_VENTRILO_BLOCK_TWO_DESC;
//$modversion['blocks'][2]['show_func'] = "b_ventrilo_do_db_block";
//$modversion['blocks'][2]['template'] = 'ventrilo_block_two.html';
//$modversion['blocks'][2]['options']	= 1 | "two";

// Blocks (Start indexes with 1, not 0!)
// This displays users on ventrilo.
$modversion['blocks'][2]['file'] = 'blocks_ventrilo.php';
$modversion['blocks'][2]['name'] = _MI_VENTRILO_BLOCK_THREE_TITLE;
$modversion['blocks'][2]['description'] = _MI_VENTRILO_BLOCK_THREE_DESC;
$modversion['blocks'][2]['show_func'] = 'ventrilo_status';
$modversion['blocks'][2]['template'] = 'ventrilo_block_three.html';
$modversion['blocks'][2]['options'] = 1 | 'two';
