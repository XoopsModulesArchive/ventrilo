<?php

function VentriloInfoEX1_Stripe(&$bgidx, $name, $val)
{
    require_once XOOPS_ROOT_PATH . '/modules/ventrilo/include/ventrilo_includes.php';

    $config = ventrilo_get_config();

    $servetitle1 = ventrilo_get_config_item('colortitleserver1');

    $servetitle2 = ventrilo_get_config_item('colortitleserver2');

    if ($bgidx % 2) {
        $bgcolname = ventrilo_get_config_item('colorrowserver1');
    } else {
        $bgcolname = ventrilo_get_config_item('colorrowserver2');
    }

    if ($bgidx % 2) {
        $bgcolval = ventrilo_get_config_item('colorrowserver1');
    } else {
        $bgcolval = ventrilo_get_config_item('colorrowserver2');
    }

    echo "  <tr>\n";

    echo "    <td width=\"35%\" bgcolor=\"$bgcolname\"><font color=\"$servetitle1\">";

    echo '<strong>';

    echo $name;

    echo '</strong>';

    echo "</font></td>\n";

    echo "    <td width=\"65%\" bgcolor=\"$bgcolval\"><font color=\"$servetitle1\">";

    echo '<div align="center">';

    echo $val;

    echo '</div';

    echo "</font></td>\n";

    echo "  </tr>\n";

    $bgidx += 1;
}

function VentriloInfoEX1($stat)
{
    $bgidx = 0;

    VentriloInfoEX1_Stripe($bgidx, 'Name', $stat->m_name);

    VentriloInfoEX1_Stripe($bgidx, 'Phonetic', $stat->m_phonetic);

    VentriloInfoEX1_Stripe($bgidx, 'Comment', $stat->m_comment);

    VentriloInfoEX1_Stripe($bgidx, 'Auth', $stat->m_auth);

    VentriloInfoEX1_Stripe($bgidx, 'Max Clients', $stat->m_maxclients);

    VentriloInfoEX1_Stripe($bgidx, 'Voice Codec', $stat->m_voicecodec_desc);

    VentriloInfoEX1_Stripe($bgidx, 'Voice Format', $stat->m_voiceformat_desc);

    VentriloInfoEX1_Stripe($bgidx, 'Uptime', $stat->m_uptime);

    VentriloInfoEX1_Stripe($bgidx, 'Platform', $stat->m_platform);

    VentriloInfoEX1_Stripe($bgidx, 'Version', $stat->m_version);

    VentriloInfoEX1_Stripe($bgidx, 'Channel Count', $stat->m_channelcount);

    VentriloInfoEX1_Stripe($bgidx, 'Client Count', $stat->m_clientcount);
}
