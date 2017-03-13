#!/bin/bash
php /home/server-admin/server-admin.bpt.loc/public_html/ban-service/daemon/dhcp-conf-gen.php
echo 'ok';
# Копировать конфиг и перезапустить dhcp