#!/bin/bash
cd /home/server-admin/server-admin.bpt.loc/public_html/sarg/Daily/
rm -rf *
/usr/sbin/sarg-reports today
cd /home/server-admin/server-admin.bpt.loc/public_html/parser/
php index.php
mv /home/server-admin/server-admin.bpt.loc/public_html/parser/limitedIp.txt /etc/squid/limitedIp.txt
systemctl restart squid


