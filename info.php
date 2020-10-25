<?php
phpinfo();
if (mssql_connect('win2003', 'sa', 'noway')) {
    echo 'Connection made to ' . $aceserver;
} else {
    echo 'Connection Failed';
}
