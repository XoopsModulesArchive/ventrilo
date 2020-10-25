<html>
<head>
    <title>Pyrosoft Ventrilo Status</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<p>
    <br>
    <?php

    include 'ventrilostatus.php';

    include 'ventriloinfo_ex1.php';
    include 'ventrilodisplay_ex1.php';
    include 'ventrilodisplay_ex2.php';

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

    $stat = new CVentriloStatus();
    $stat->m_cmdprog = 'f:/ventrilo_srv/ventrilo_status';    // Adjust accordingly.
    $stat->m_cmdcode = '2';                    // Detail mode.
    $stat->m_cmdhost = '127.0.0.1';            // Assume ventrilo server on same machine.
    $stat->m_cmdport = '3784';                // Port to be statused.
    $stat->m_cmdpass = '';                    // Status password if necessary.

    $rc = $stat->Request();
    if ($rc) {
        echo "CVentriloStatus->Request() failed. <strong>$stat->m_error</strong><br><br>\n";
    }

    // Create a web link for this server. Please note that the status password
    // is not the same thing as a servers global logon password. This is why the
    // example doesn't add one.

    echo "Building a ventrilo:// web link from the supplied information. \n";
    echo "Please note that if the retrieved server name has spaces in it then anything following them \n";
    echo "will not show up in the client. This is a client side issue. You might use _'s in server names ";
    echo "instead until the problem is fixed.<br><br>\n";

    $weblink = "ventrilo://$stat->m_name:3784/servername=$stat->m_name";
    echo "<center><a href=\"$weblink\">Click here to connect to the following server.</a></center><br><br>\n";

    // Server basic info.

    echo "Basic information about the server using VentriloInfoEX1.<br><br>\n";

    echo "<center><table width=\"50%\" border=\"0\">\n";
    VentriloInfoEX1($stat);
    echo "</table></center>\n";

    // Server channels/users info.

    echo "<br>Channel and user info using VentriloDisplayEX2.<br><br>\n";

    echo "<br>\n";
    echo "<center><table width=\"95%\" border=\"0\">\n";

    $name = '';
    VentriloDisplayEX2($stat, $name, 0, 0);

    echo "</table></center>\n";

    echo "<br>Channel and user info using VentriloDisplayEX1.<br><br>\n";

    /* Use this if you prefer the first channel name to look more
       like a ventrilo client display where the first entry is the
       server name followed by it's comment.

    $name = $stat->m_name;
    if ( strlen( $stat->m_comment ) )
        $name .= " ($stat->m_comment)";
    */
    $name = 'Lobby';

    echo "<br>\n";
    echo "<center><table width=\"95%\" border=\"0\">\n";
    VentriloDisplayEX1($stat, $name, 0, 0);
    echo "</table></center>\n";
    ?>
</p>
</body>
</html>
