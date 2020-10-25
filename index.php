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
//  ------------------------------------------------------------------------ //
require_once '../../mainfile.php';
if (file_exists(XOOPS_ROOT_PATH . '/modules/ventrilo/language/' . $xoopsConfig['language'] . '/templates.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/language/' . $xoopsConfig['language'] . '/templates.php';
} else {
    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/language/english/templates.php';
}
// Include any common code for this module.
require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilo_includes.php';
require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/config.php';

//
// This takes the $msg and $data, and puts them into the template.
// Templates used by this module have a space to display
// error messages at the top of the page.
//
function ventrilo_add_error($msg, $data)
{
    global $xoopsTpl;

    $xerror = [];

    $xerror['msg'] = $msg;

    $xerror['data'] = $data;

    $xoopsTpl->append('errors', $xerror);
}

//
// Displays the "Main" tab of the module
//
function ventrilo_main()
{
    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilostatus.php';

    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventriloinfo_ex1.php';

    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilodisplay_ex1.php';

    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilodisplay_ex2.php';

    /*
        This example PHP script came with a file called ventriloreadme.txt and should
        be read if you are having problems making these scripts function properly.

        In it's current state this script is not usable. You MUST read the
        ventriloreadme.txt file if you do not know what needs to be changed.

        The location of the 'ventrilo_status' program must be accessible from
        PHP and what ever HTTP server you are using. This can be effected by
        PHP safemode and other factors. The placement, access rights and ownership
        of the file it self is your responsibility. Change to fit your needs.
    */

    $config = ventrilo_get_config();

    //$VentriloPath = "/usr/local/apache2/htdocs/modules/ventrilo/ventrilo_status";  // Ventrilo Server Path

    $VentriloPath = $config['config_main_server'];

    $VentriloPath = ventrilo_get_config_item('config_main_server');

    $Server = ventrilo_get_config_item('config_server');

    $ExternalServer = ventrilo_get_config_item('config_main_ExternalServer');

    $ServerNum = $config['number_of_servers'];

    $labelServer1 = $config['config_server_label'];

    $labelServer2 = $config['config_main_ExternalServer_label'];

    $colorServer1 = $config['config_server_color'];

    $colorServer2 = $config['config_main_ExternalServer_color'];

    $displayinternal = $config['displayinternal'];

    $stat = new CVentriloStatus();

    $stat->m_cmdprog = $config['config_main_server'];    // Adjust accordingly.
    $stat->m_cmdcode = '2';                    // Detail mode.
    $stat->m_cmdhost = $config['config_cmdhost'];            // Assume ventrilo server on same machine.
    $stat->m_cmdport = $config['config_cmdport'];                // Port to be statused.
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

    echo "<table><center>\n";

    echo "<center><table width=\"95%\" border=\"0\">\n<tr><td>";

    if ($rc) {
        echo "CVentriloStatus->Request() failed. <strong>$stat->m_error</strong><br><br>\n";
    }

    // Create a web link for this server. Please note that the status password

    // is not the same thing as a servers global logon password. This is why the

    // example doesn't add one.

    $weblink = "ventrilo://$stat->m_cmdhost:$stat->m_cmdport/servername=$stat->m_name";

    if ('yes' == $displayinternal) {
        echo "<center><a href=\"$weblink\">Click here to connect via the internal address to the $stat->m_name Ventrilo Server.</a></center>";
    }

    $weblink = "ventrilo://$Server:$stat->m_webport/servername=$stat->m_name";

    echo "<center><a href=\"$weblink\">Click here to connect via the external address to the $stat->m_name Ventrilo Server.</a></center><br>";

    $weblink = 'http://www.ventrilo.com/download.php';

    echo "<center><a href=\"$weblink\">Click here to download the Ventrilo Client.</a></center><br>";

    // Server basic info.

    echo "<center><h2>Basic information about the <font color = '" . $colorServer1 . "'>" . $labelServer1 . ' </font>server.</center></h2><br>';

    echo "<center><table width=\"50%\" border=\"0\">\n";

    VentriloInfoEX1($stat);

    echo "</table></center>\n";

    // Server channels/users info.

    echo "<br>Channel and user info.<br><br>\n";

    echo "<br>\n";

    echo "<center><table width=\"95%\" border=\"0\">\n";

    $name = '';

    VentriloDisplayEX2($stat, $name, 0, 0);

    echo '<hr>';

    echo "</table></center>\n";

    $name = "<h3><centre><font color = '" . $colorServer1 . "'>" . $labelServer1 . ' Lobby</font></centre></h3>';

    echo "<br>\n";

    echo "<center><table width=\"95%\" border=\"0\">\n";

    VentriloDisplayEX1($stat, $name, 0, 0);

    echo "</table></center>\n";

    if ('2' == $ServerNum) {
        if ($rc2) {
            echo "CVentriloStatus->Request() failed. <strong>$stat2->m_error</strong><br><br>\n";
        }

        // Create a web link for this server. Please note that the status password

        // is not the same thing as a servers global logon password. This is why the

        // example doesn't add one.

        echo '</td><td>';

        $weblink = "ventrilo://$stat2->m_cmdhost:$stat2->m_cmdport/servername=$stat2->m_name";

        if ('yes' == $displayinternal) {
            echo "<center><a href=\"$weblink\">Click here to connect via the internal address to the $stat2->m_name Ventrilo Server.</a></center>";
        }

        $weblink = "ventrilo://$ExternalServer:$stat2->m_webport/servername=$stat2->m_name";

        echo "<center><a href=\"$weblink\">Click here to connect via the external address to the $stat2->m_name Ventrilo Server.</a></center><br>";

        $weblink = 'http://www.ventrilo.com/download.php';

        echo "<center><a href=\"$weblink\">Click here to download the Ventrilo Client.</a></center><br>";

        // Server basic info.

        echo "<center><h2>Basic information about the <font color = '" . $colorServer2 . "'>" . $labelServer2 . '</font> server.</center></h2><br>';

        echo "<center><table width=\"50%\" border=\"0\">\n";

        VentriloInfoEX1($stat2);

        echo "</table></center>\n";

        // Server channels/users info.

        echo "<br>Channel and user info.<br><br>\n";

        echo "<br>\n";

        echo "<center><table width=\"95%\" border=\"0\">\n";

        $name = '';

        VentriloDisplayEX2($stat2, $name, 0, 0);

        echo '<hr>';

        echo "</table></center>\n";

        $name = "<h3><centre><font color = '" . $colorServer2 . "'>" . $labelServer2 . ' Lobby</font></centre></h3>';

        echo "<br>\n";

        echo "<center><table width=\"95%\" border=\"0\">\n";

        VentriloDisplayEX1($stat2, $name, 0, 0);

        echo "</table></center>\n";

        echo '</td></tr>';
    } else {
        echo '</td></tr>';
    }

    echo "</table></center>\n";
}

//
// Handles data posted from any form on the main page
//
function ventrilo_main_post()
{
    global $xoopsTpl;

    global $xoopsDB;

    $xoopsTpl->assign('lang', ventrilo_get_intl());

    $xoopsTpl->assign('page_title', _MI_VENTRILO_TITLE);
}

// Get all HTTP post or get parameters into global variables that are prefixed with "param_"
import_request_variables('gp', 'param_');

// This page uses smarty templates. Set "$xoopsOption['template_main']" before including header
$mytemplate = 'ventrilo_index.html';
$GLOBALS['xoopsOption']['template_main'] = (string)$mytemplate;

require XOOPS_ROOT_PATH . '/header.php';
$xoopsTpl->assign('page_title', _AM_VENTRILO_LABEL_MAIN_TITLE);

if (!isset($param_op)) {
    $param_op = 'main';
}

switch ($param_op) {
    case 'main':
        ventrilo_main();
        break;
    case 'main_post':
        ventrilo_main_post();
        break;
    default:
        print "<h1>:Unknown method requested '$param_op' in index.php</h1>";
        exit();
}

require XOOPS_ROOT_PATH . '/footer.php';
