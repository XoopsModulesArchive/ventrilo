<?php

function VentriloDisplayEX1(&$stat, $name, $cid, $bgidx)
{
    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilo_includes.php';

    $config = ventrilo_get_config();

    $chan = $stat->ChannelFind($cid);

    if ($bgidx % 2) {
        $bg = ventrilo_get_config_item('colorrow1');
    } else {
        $bg = ventrilo_get_config_item('colorrow2');
    }

    /*
      if ( $chan->m_prot )
        $fg = "#FF0000";
      else
        $fg = "#FFFFFF";
    */

    $fg = '#FFFFFF';

    if ($chan->m_prot) {
        if ($bgidx % 2) {
            $bg = ventrilo_get_config_item('colorrow1');
        } else {
            $bg = ventrilo_get_config_item('colorrow2');
        }
    }

    echo "  <tr>\n";

    echo "    <td bgcolor=\"$bg\"><font color=\"$fg\"><strong>";

    echo $name;

    echo "</strong></font>\n";

    echo "      <table width=\"95%\" border=\"0\" align=\"right\">\n";

    // Display Client for this channel.

    for ($i = 0, $iMax = count($stat->m_clientlist); $i < $iMax; $i++) {
        $client = $stat->m_clientlist[$i];

        if ($client->m_cid != $cid) {
            continue;
        }

        echo "      <tr>\n";

        echo '        <td bgcolor="#FFFFFF">';

        $flags = '';

        if ($client->m_admin) {
            $flags .= 'A';
        }

        if ($client->m_phan) {
            $flags .= 'P';
        }

        if (mb_strlen($flags)) {
            echo "\"$flags\" ";
        }

        echo $client->m_name;

        if ($client->m_comm) {
            echo " ($client->m_comm)";
        }

        echo "  </td>\n";

        echo "      </tr>\n";
    }

    // Display sub-channels for this channel.

    for ($i = 0, $iMax = count($stat->m_channellist); $i < $iMax; $i++) {
        if ($stat->m_channellist[$i]->m_pid == $cid) {
            $cn = $stat->m_channellist[$i]->m_name;

            if (mb_strlen($stat->m_channellist[$i]->m_comm)) {
                $cn .= ' (';

                $cn .= $stat->m_channellist[$i]->m_comm;

                $cn .= ')';
            }

            VentriloDisplayEX1($stat, $cn, $stat->m_channellist[$i]->m_cid, $bgidx + 1);
        }
    }

    echo "      </table>\n";

    echo "    </td>\n";

    echo "  </tr>\n";
}
