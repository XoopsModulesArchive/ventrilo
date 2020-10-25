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

require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/modules/profile/include/functions.php';

if (file_exists(XOOPS_ROOT_PATH . '/modules/ventrilo/language/' . $xoopsConfig['language'] . '/templates.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/language/' . $xoopsConfig['language'] . '/templates.php';
} else {
    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/language/english/templates.php';
}
// Include any common code for this module.
require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilo_includes.php';
require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/config.php';
//$config = ventrilo_get_config();
function ventrilo_status()
{
    global $xoopsTpl;

    global $xoopsDB;

    global $xoopsConfig, $xoopsModule, $xoopsUser, $HTTP_SERVER_VAR;

    if (file_exists(XOOPS_ROOT_PATH . '/modules/ventrilo/language/' . $xoopsConfig['language'] . '/templates.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/ventrilo/language/' . $xoopsConfig['language'] . '/templates.php';
    } else {
        require_once XOOPS_ROOT_PATH . '/modules/ventrilo/language/english/templates.php';
    }

    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilo_includes.php';

    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilostatus.php';

    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventriloinfo_ex1.php';

    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilodisplay_ex1.php';

    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilodisplay_ex2.php';

    //$query = "SELECT * FROM ".$xoopsDB->prefix("users");

    //$result = $GLOBALS['xoopsDB']->queryF( $query );

    //	for ($i = 0; $i < $GLOBALS['xoopsDB']->getRowsNum( $result ); ++$i)

    //	{

    //		$avatars = array_fill($i+1,,mysql_result($result,$i,"name"));

    $block = [];

    $link = [];

    global $xoopsDB;

    $config = ventrilo_get_config();

    //$VentriloPath = "/usr/local/apache2/htdocs/modules/ventrilo/ventrilo_status";  // Ventrilo Server Path

    $VentriloPath = ventrilo_get_config_item('config_main_server');

    $Server = ventrilo_get_config_item('config_server');

    $ExternalServer = ventrilo_get_config_item('config_main_ExternalServer');

    $ServerNum = $config['number_of_servers'];

    $labelServer1 = $config['config_server_label'];

    $labelServer2 = $config['config_main_ExternalServer_label'];

    $colorServer1 = $config['config_server_color'];

    $colorServer2 = $config['config_main_ExternalServer_color'];

    $stat = new CVentriloStatus();

    $stat->m_cmdprog = $config['config_main_server'];    // Adjust accordingly.
    $stat->m_cmdhost = $config['config_cmdhost'];    // ventrilo server .
    $stat->m_cmdcode = '2';

    $stat->m_cmdport = $config['config_cmdport'];                // Port to be statused.
    $stat->m_webport = $config['config_webport'];                // web Port to be statused.
    $stat->m_cmdpass = $config['config_cmdpass'];                // Status password if necessary.
    $stat2 = new CVentriloStatus();

    $stat2->m_cmdprog = $config['config_main_server'];    // Adjust accordingly.

    $stat2->m_cmdcode = '2';

    $stat2->m_cmdport = $config['config_cmdport2'];                // Port to be statused.
    $stat2->m_webport = $config['config_webport2'];                // Port to be statused.
    $stat2->m_cmdpass = $config['config_cmdpass2'];                // Status password if necessary.
    $stat2->m_cmdhost = $config['config_cmdhost2'];                // Second Ventrilo server.

    $rc = $stat->Request();

    $rc2 = $stat2->Request();

    if ($rc) {
        $block['serverstat'] = "Sorry, '$SiteName' Ventrilo voice Server does not seem to be online. Please try again later. The error returned is  <strong>$stat->m_error</strong><br><br>\n";
    } else {
        $weblink = "ventrilo://$Server:$stat->m_webport/servername=$stat->m_name";

        $block['serverstat'] = "<center><a href=\"$weblink\"> $stat->m_name ventrilo server.</a></center>";

        $weblink = "ventrilo://$ExternalServer:$stat->m_cmdport/servername=$ExternalServer";
    }

    if ('2' == $ServerNum) {
        if ($rc2) {
            $block['serverother'] = "Sorry, '$ExternalServer' Ventrilo voice Server does not seem to be online. Please try again later. The error returned is  <strong>$stat2->m_error</strong><br><br>\n";
        } else {
            $weblink = "ventrilo://$ExternalServer:$stat2->m_webport/servername=$stat2->m_name";

            $block['serverother'] = "<center><a href=\"$weblink\"> $stat2->m_name ventrilo server.</a></center>";

            $weblink = "ventrilo://$ExternalServer:$stat2->m_cmdport/servername=$ExternalServer";
        }

        //  $block['serverother'] = "<center><a href=\"$weblink\"> $ExternalServer ventrilo server.</a></center>";
    }

    for ($i = 0, $iMax = count($stat->m_clientlist); $i < $iMax; $i++) {
        $client = $stat->m_clientlist[$i];

        $query = 'SELECT * FROM ' . $xoopsDB->prefix('users') . " where uname = '" . $client->m_name . "'";

        $result = $GLOBALS['xoopsDB']->queryF($query);

        if (!mysql_result($result, 0, 'uname')) {
            // echo " <img src='".XOOPS_URL."/uploads/".$xoopsUser->getVar('user_avatar').">";

            //    echo $xoopsUser->getVar('user_avatar');

            $link['name'] = "<font color = '" . $colorServer1 . "'>" . $client->m_name . '</font> no matching member found,ventrilo username must match login';

            $link['url'] = XOOPS_URL . '/modules/ventrilo/images/avatars/guest_avatar.JPG';

            $link['ping'] = $client->m_ping;

            $block['links'][] = $link;
        } else {
            $link['name'] = "<font color = '" . $colorServer1 . "'>" . mysql_result($result, $k, 'uname') . '</font> ' . $labelServer1;

            $link['url'] = XOOPS_URL . '/uploads/' . mysql_result($result, $k, 'user_avatar');

            $link['ping'] = $client->m_ping;

            $block['links'][] = $link;
        }
    }

    if ('2' == $ServerNum) {
        for ($i = 0, $iMax = count($stat2->m_clientlist); $i < $iMax; $i++) {
            $client = $stat2->m_clientlist[$i];

            $query = 'SELECT * FROM ' . $xoopsDB->prefix('users') . " where uname = '" . $client->m_name . "'";

            $result = $GLOBALS['xoopsDB']->queryF($query);

            if (!mysql_result($result, 0, 'uname')) {
                // echo " <img src='".XOOPS_URL."/uploads/".$xoopsUser->getVar('user_avatar').">";

                //    echo $xoopsUser->getVar('user_avatar');

                $link['name'] = "<font color = '" . $colorServer2 . "'>" . $client->m_name . '</font> no matching member found,ventrilo username must match login';

                $link['url'] = XOOPS_URL . '/modules/ventrilo/images/avatars/guest_avatar.JPG';

                $link['ping'] = $client->m_ping;

                $block['links'][] = $link;
            } else {
                $link['name'] = "<font color = '" . $colorServer2 . "'>" . mysql_result($result, $k, 'uname') . '</font> ' . $labelServer2;

                $link['url'] = XOOPS_URL . '/uploads/' . mysql_result($result, $k, 'user_avatar');

                $link['ping'] = $client->m_ping;

                $block['links'][] = $link;
            }
        }
    }

    $block['lang'] = ventrilo_get_intl();

    return $block;
}
