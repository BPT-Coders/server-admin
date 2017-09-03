#!/bin/bash
# Очистить старую статистику
cd /home/server-admin/server-admin.bpt.loc/public_html/sarg/Daily/
rm -rf *
# Сгенерировать новую статистику
/usr/sbin/sarg-reports today
cd /home/server-admin/server-admin.bpt.loc/public_html/parser/
# Сгенерировать новый список адресов, превысивших лимит
php index.php
# Сравнить новый и старый списки
if cmp -s limitedIp.txt newLimitedIp.txt 
then
        echo "Равны"
		date >> /home/server-admin/server-admin.bpt.loc/public_html/forInstall/logs/squid
		echo "Нет необходимости" >> /home/server-admin/server-admin.bpt.loc/public_html/forInstall/logs/squid
		echo "" >> /home/server-admin/server-admin.bpt.loc/public_html/forInstall/logs/squid
else
        echo "Не равны"
		# Считать новый список основным
		cp newLimitedIp.txt limitedIp.txt
		echo "" > newLimitedIp.txt
		# Скопировать список в каталог squid
		cp limitedIp.txt /etc/squid/
		# Перезагрузить squid
		systemctl restart squid
		# Сделать запись в журнал
		date >> /home/server-admin/server-admin.bpt.loc/public_html/forInstall/logs/squid
		echo "Перезагрузился\n" >> /home/server-admin/server-admin.bpt.loc/public_html/forInstall/logs/squid
		echo "" >> /home/server-admin/server-admin.bpt.loc/public_html/forInstall/logs/squid
fi




