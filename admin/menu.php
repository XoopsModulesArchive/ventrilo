<?php
// -------------------------------------------------------------------------
//	Ventrilo
//		Copyright 2004, Kheldar
// 		pyrosoft.cable.nu
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

$adminmenu[0]['title'] = _MI_VENTRILO_MENU_MAIN;
$adminmenu[0]['link'] = 'admin/index.php';
$adminmenu[0]['desc'] = _MI_VENTRILO_MENU_MAIN_DESC;

$adminmenu[1]['title'] = _MI_VENTRILO_MENU_CONFIG;
$adminmenu[1]['link'] = 'admin/config.php';
$adminmenu[1]['desc'] = _MI_VENTRILO_MENU_CONFIG_DESC;

$adminmenu[2]['title'] = _MI_VENTRILO_MENU_EDIT;
$adminmenu[2]['link'] = 'admin/database_table.php';
$adminmenu[2]['desc'] = _MI_VENTRILO_MENU_EDIT_DESC;

$adminmenu[3]['title'] = _MI_VENTRILO_MENU_HELP;
$adminmenu[3]['link'] = 'docs/ventrilo_admin.html';
$adminmenu[3]['desc'] = _MI_VENTRILO_MENU_HELP_DESC;
$adminmenu[3]['target'] = '_blank';