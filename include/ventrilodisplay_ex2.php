<?php

function VentriloDisplayEX2_Stripe($perc, $val, $bgidx)
{
    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilo_includes.php';

    $config = ventrilo_get_config();

    $fgcol = ventrilo_get_config_item('colorlobbyuser');

    if ($bgidx < 0) {
        $fgcol = ventrilo_get_config_item('colorlobby');

        $bgcol = ventrilo_get_config_item('colorlobbyhead');
    } else {
        if ($bgidx % 2) {
            $bgcol = ventrilo_get_config_item('colorrow1');
        } else {
            $bgcol = ventrilo_get_config_item('colorrow2');
        }
    }

    echo "    <td width=\"$perc\" bgcolor=\"$bgcol\"><font color=\"$fgcol\">$val</font></td>\n";
}

function VentriloDisplayEX2($stat, $name, $cid, $bgidx)
{
    global $xoopsTpl;

    global $xoopsDB;

    global $xoopsConfig, $xoopsModule, $xoopsUser, $HTTP_SERVER_VAR;

    // Display the table headers.

    echo "  <tr>\n";

    VentriloDisplayEX2_Stripe('5%', 'Flags', -1);

    VentriloDisplayEX2_Stripe('5%', 'UID', -1);

    VentriloDisplayEX2_Stripe('5%', 'CID', -1);

    VentriloDisplayEX2_Stripe('10%', 'Sec', -1);

    VentriloDisplayEX2_Stripe('10%', 'Ping', -1);

    VentriloDisplayEX2_Stripe('20%', 'Name', -1);

    VentriloDisplayEX2_Stripe('45%', 'Avatar', -1);

    echo "  </tr>\n";

    // Display all clients.

    for ($i = 0, $iMax = count($stat->m_clientlist); $i < $iMax; $i++) {
        echo "  <tr>\n";

        $client = $stat->m_clientlist[$i];

        $flags = '';

        if ($client->m_admin) {
            $flags .= 'A';
        }

        if ($client->m_phan) {
            $flags .= 'P';
        }

        $client = $stat->m_clientlist[$i];

        $query = 'SELECT * FROM ' . $xoopsDB->prefix('users') . " where uname = '" . $client->m_name . "'";

        $result = $GLOBALS['xoopsDB']->queryF($query);

        if (!mysql_result($result, 0, 'uname')) {
            VentriloDisplayEX2_Stripe('5%', $flags, $bgidx);

            VentriloDisplayEX2_Stripe('5%', $client->m_uid, $bgidx);

            VentriloDisplayEX2_Stripe('5%', $client->m_cid, $bgidx);

            VentriloDisplayEX2_Stripe('10%', $client->m_sec, $bgidx);

            VentriloDisplayEX2_Stripe('10%', $client->m_ping, $bgidx);

            VentriloDisplayEX2_Stripe('20%', $client->m_name, $bgidx);

            VentriloDisplayEX2_Stripe(
                '45%',
                "<img src='" . XOOPS_URL . "/modules/ventrilo/images/avatars/guest_avatar.JPG'
>" . ' no matching member found,ventrilo username must match login' . $client->m_comment,
                $bgidx
            );

            echo "  </tr>\n";
        } else {
            VentriloDisplayEX2_Stripe('5%', $flags, $bgidx);

            VentriloDisplayEX2_Stripe('5%', $client->m_uid, $bgidx);

            VentriloDisplayEX2_Stripe('5%', $client->m_cid, $bgidx);

            VentriloDisplayEX2_Stripe('10%', $client->m_sec, $bgidx);

            VentriloDisplayEX2_Stripe('10%', $client->m_ping, $bgidx);

            VentriloDisplayEX2_Stripe('20%', $client->m_name, $bgidx);

            VentriloDisplayEX2_Stripe(
                '45%',
                "<img src='" . XOOPS_URL . '/uploads/' . mysql_result($result, $k, 'user_avatar') . "'
> " . $client->m_comment,
                $bgidx
            );

            echo "  </tr>\n";
        }

        $bgidx += 1;
    }
}
