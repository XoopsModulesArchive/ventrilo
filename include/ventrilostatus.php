<?php

/*
    This file should not be modified. This is so that future versions can be
    dropped into place as servers are updated.

    Version 2.3.0: Supports phantoms.
    Version 2.2.1: Supports channel comments.
*/

function StrKey($src, $key, &$res)
{
    $key .= ' ';

    if (strncasecmp($src, $key, mb_strlen($key))) {
        return false;
    }

    $res = mb_substr($src, mb_strlen($key));

    return true;
}

function Strpreg_split($src, $sep, &$d1, &$d2)
{
    $pos = mb_strpos($src, $sep);

    if (false === $pos) {
        $d1 = $src;

        return;
    }

    $d1 = mb_substr($src, 0, $pos);

    $d2 = mb_substr($src, $pos + 1);
}

function StrDecode($src)
{
    $res = '';

    for ($i = 0, $iMax = mb_strlen($src); $i < $iMax;) {
        if ('%' == $src[$i]) {
            $res .= sprintf('%c', intval(mb_substr($src, $i + 1, 2), 16));

            $i += 3;

            continue;
        }

        $res .= $src[$i];

        $i += 1;
    }

    return ($res);
}

class CVentriloClient
{
    public $m_uid;            // User ID.
    public $m_admin;        // Admin flag.
    public $m_phan;        // Phantom flag.
    public $m_cid;            // Channel ID.
    public $m_ping;        // Ping.
    public $m_sec;            // Connect time in seconds.
    public $m_name;        // Login name.
    public $m_comm;        // Comment.

    public function Parse($str)
    {
        $ary = explode(',', $str);

        for ($i = 0, $iMax = count($ary); $i < $iMax; $i++) {
            Strpreg_split($ary[$i], '=', $field, $val);

            if (0 == strcasecmp($field, 'UID')) {
                $this->m_uid = $val;

                continue;
            }

            if (0 == strcasecmp($field, 'ADMIN')) {
                $this->m_admin = $val;

                continue;
            }

            if (0 == strcasecmp($field, 'CID')) {
                $this->m_cid = $val;

                continue;
            }

            if (0 == strcasecmp($field, 'PHAN')) {
                $this->m_phan = $val;

                continue;
            }

            if (0 == strcasecmp($field, 'PING')) {
                $this->m_ping = $val;

                continue;
            }

            if (0 == strcasecmp($field, 'SEC')) {
                $this->m_sec = $val;

                continue;
            }

            if (0 == strcasecmp($field, 'NAME')) {
                $this->m_name = StrDecode($val);

                continue;
            }

            if (0 == strcasecmp($field, 'COMM')) {
                $this->m_comm = StrDecode($val);

                continue;
            }
        }
    }
}

class CVentriloChannel
{
    public $m_cid;        // Channel ID.
    public $m_pid;        // Parent channel ID.
    public $m_prot;    // Password protected flag.
    public $m_name;    // Channel name.
    public $m_comm;    // Channel comment.

    public function Parse($str)
    {
        $ary = explode(',', $str);

        for ($i = 0, $iMax = count($ary); $i < $iMax; $i++) {
            Strpreg_split($ary[$i], '=', $field, $val);

            if (0 == strcasecmp($field, 'CID')) {
                $this->m_cid = $val;

                continue;
            }

            if (0 == strcasecmp($field, 'PID')) {
                $this->m_pid = $val;

                continue;
            }

            if (0 == strcasecmp($field, 'PROT')) {
                $this->m_prot = $val;

                continue;
            }

            if (0 == strcasecmp($field, 'NAME')) {
                $this->m_name = StrDecode($val);

                continue;
            }

            if (0 == strcasecmp($field, 'COMM')) {
                $this->m_comm = StrDecode($val);

                continue;
            }
        }
    }
}

class CVentriloStatus
{
    // These need to be filled in before issueing the request.

    public $m_cmdprog;        // Path and filename of external process to execute. ex: /var/www/html/ventrilo_status
    public $m_cmdcode;        // Specific status request code. 1=General, 2=Detail.
    public $m_cmdhost;        // Hostname or IP address to perform status of.
    public $m_cmdport;        // Port number of server to status.
    // These are the result variables that are filled in when the request is performed.

    public $m_error;        // If the ERROR: keyword is found then this is the reason following it.
    public $m_name;                // Server name.
    public $m_phonetic;            // Phonetic spelling of server name.
    public $m_comment;                // Server comment.
    public $m_maxclients;            // Maximum number of clients.
    public $m_voicecodec_code;        // Voice codec code.
    public $m_voicecodec_desc;        // Voice codec description.
    public $m_voiceformat_code;    // Voice format code.
    public $m_voiceformat_desc;    // Voice format description.
    public $m_uptime;                // Server uptime in seconds.
    public $m_platform;            // Platform description.
    public $m_version;                // Version string.
    public $m_channelcount;        // Number of channels as specified by the server.
    public $m_channelfields;        // Channel field names.
    public $m_channellist;            // Array of CVentriloChannel's.
    public $m_clientcount;            // Number of clients as specified by the server.
    public $m_clientfields;        // Client field names.
    public $m_clientlist;            // Array of CVentriloClient's.

    public function Parse($str)
    {
        // Remove trailing newline.

        $pos = mb_strpos($str, "\n");

        if (false === $pos) {
        } else {
            $str = mb_substr($str, 0, $pos);
        }

        // Begin parsing for keywords.

        if (StrKey($str, 'ERROR:', $val)) {
            $this->m_error = $val;

            return -1;
        }

        if (StrKey($str, 'NAME:', $val)) {
            $this->m_name = StrDecode($val);

            return 0;
        }

        if (StrKey($str, 'PHONETIC:', $val)) {
            $this->m_phonetic = StrDecode($val);

            return 0;
        }

        if (StrKey($str, 'COMMENT:', $val)) {
            $this->m_comment = StrDecode($val);

            return 0;
        }

        if (StrKey($str, 'AUTH:', $this->m_auth)) {
            return 0;
        }

        if (StrKey($str, 'MAXCLIENTS:', $this->m_maxclients)) {
            return 0;
        }

        if (StrKey($str, 'VOICECODEC:', $val)) {
            Strpreg_split($val, ',', $this->m_voicecodec_code, $desc);

            $this->m_voicecodec_desc = StrDecode($desc);

            return 0;
        }

        if (StrKey($str, 'VOICEFORMAT:', $val)) {
            Strpreg_split($val, ',', $this->m_voiceformat_code, $desc);

            $this->m_voiceformat_desc = StrDecode($desc);

            return 0;
        }

        if (StrKey($str, 'UPTIME:', $val)) {
            $this->m_uptime = $val;

            return 0;
        }

        if (StrKey($str, 'PLATFORM:', $val)) {
            $this->m_platform = StrDecode($val);

            return 0;
        }

        if (StrKey($str, 'VERSION:', $val)) {
            $this->m_version = StrDecode($val);

            return 0;
        }

        if (StrKey($str, 'CHANNELCOUNT:', $this->m_channelcount)) {
            return 0;
        }

        if (StrKey($str, 'CHANNELFIELDS:', $this->m_channelfields)) {
            return 0;
        }

        if (StrKey($str, 'CHANNEL:', $val)) {
            $chan = new CVentriloChannel();

            $chan->Parse($val);

            $this->m_channellist[count($this->m_channellist)] = $chan;

            return 0;
        }

        if (StrKey($str, 'CLIENTCOUNT:', $this->m_clientcount)) {
            return 0;
        }

        if (StrKey($str, 'CLIENTFIELDS:', $this->m_clientfields)) {
            return 0;
        }

        if (StrKey($str, 'CLIENT:', $val)) {
            $client = new CVentriloClient();

            $client->Parse($val);

            $this->m_clientlist[count($this->m_clientlist)] = $client;

            return 0;
        }

        // Unknown key word. Could be a new keyword from a newer server.

        return 1;
    }

    public function ChannelFind($cid)
    {
        for ($i = 0, $iMax = count($this->m_channellist); $i < $iMax; $i++) {
            if ($this->m_channellist[$i]->m_cid == $cid) {
                return ($this->m_channellist[$i]);
            }
        }

        return null;
    }

    public function ChannelPathName($idx)
    {
        $chan = $this->m_channellist[$idx];

        $pathname = $chan->m_name;

        for (; ;) {
            $chan = $this->ChannelFind($chan->m_pid);

            if (null === $chan) {
                break;
            }

            $pathname = $chan->m_name . '/' . $pathname;
        }

        return ($pathname);
    }

    public function Request()
    {
        $cmdline = $this->m_cmdprog;

        $cmdline .= ' -c' . $this->m_cmdcode;

        $cmdline .= ' -t' . $this->m_cmdhost;

        if (mb_strlen($this->m_cmdport)) {
            $cmdline .= ':' . $this->m_cmdport;

            // For password to work you MUST provide a port number.

            if (mb_strlen($this->m_cmdpass)) {
                $cmdline .= ':' . $this->m_cmdpass;
            }
        }

        // Just in case.

        $cmdline = escapeshellcmd($cmdline);

        // Execute the external command.

        $pipe = popen($cmdline, 'r');

        if (false === $pipe) {
            $this->m_error = 'PHP Unable to spawn shell.';

            return -10;
        }

        // Process the results coming back from the shell.

        $cnt = 0;

        while (!feof($pipe)) {
            $s = fgets($pipe, 1024);

            if (0 == mb_strlen($s)) {
                continue;
            }

            $rc = $this->Parse($s);

            if ($rc < 0) {
                pclose($pipe);

                return ($rc);
            }

            $cnt += 1;
        }

        pclose($pipe);

        if (0 == $cnt) {
            // This is possible since the shell might not be able to find

            // the specified process but the shell did spawn. More likely to

            // occur then the -10 above.

            $this->m_error = 'PHP Unable to start external status process.';

            return -11;
        }

        return 0;
    }
}

