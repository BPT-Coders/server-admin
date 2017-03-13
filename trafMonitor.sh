#!/bin/bash
/usr/sbin/sarg-reports today
cd /home/server-admin/server-admin.bpt.loc/public_html/parser/
php index.php
mv /home/server-admin/server-admin.bpt.loc/public_html/parser/limitedIp.txt /etc/squid/limitedIp.txt
systemctl restart squid
cd /home/server-admin/server-admin.bpt.loc/public_html/parser/
rm -rf *
