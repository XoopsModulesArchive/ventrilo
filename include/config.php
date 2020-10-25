<?php

require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilostatus.php';
require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventriloinfo_ex1.php';
require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilodisplay_ex1.php';
require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilodisplay_ex2.php';

$VentriloPath = '/usr/local/apache2/htdocs/modules/ventrilo/ventrilo_status';  // Ventrilo Server Path
$stat = new CVentriloStatus();
$stat->m_cmdprog = $VentriloPath;    // Adjust accordingly.
$stat->m_cmdcode = '2';                    // Detail mode.
$stat->m_cmdhost = '192.168.5.100';            // Assume ventrilo server on same machine.
$stat->m_cmdport = '3784';                // Port to be statused.
$stat->m_cmdpass = '';                    // Status password if necessary.

$rc = $stat->Request();

$Myserver = 'Pyrosoft.cable.nu';
$ExternalServer = 'Strathnet.cable.nu';
$VentriloPHPPath = '/ventrilo/';  // Must start with a forward slash, and end with a forward slash
$VentriloPHPPath2 = '/ventrilo/strathnet/';  // Must start with a forward slash, and end with a forward slash

$SiteName = 'Pyrosoft';
$ExternalSiteLink = '<a href="http://strathnet/ventrilo/pyrosoft/ventriloreloadpage.php">Strathnet VOICE SERVER</a>';
$Logo1 = 'nousers.JPG';
$Logo1Online = 'images_vent_green.JPG';
$Logo2 = 'fdheadr.jpg';
$HelpLink = 'http://strathnet.cable.nu/index.php?showtopic=371';
$weblink = "ventrilo://$Myserver:$stat->m_cmdport/servername=$stat->m_name";

// Table row Color
$background = '#99CCFF';
$RowCol1 = '#3399CC';
$RowCol2 = '#339999';

// Avatar List

$kheldarPic = 'http://pyrosoft.cable.nu/ventrilo/avatars/kheldar.JPG';
$MadMickPic = 'http://pyrosoft.cable.nu/ventrilo/avatars/spoungebob.JPG';
$OberPic = 'http://pyrosoft.cable.nu/ventrilo/avatars/KB_Icon_TS.jpg';
$GuruswarmyozPic = 'http://pyrosoft.cable.nu/ventrilo/avatars/dave.JPG';
$BigtedPic = 'http://pyrosoft.cable.nu/ventrilo/avatars/dave.JPG';
$BazPic = 'http://pyrosoft.cable.nu/ventrilo/avatars/baz.JPG';
$DefaultPic = 'http://pyrosoft.cable.nu/ventrilo/avatars/guest_avatar.JPG';
