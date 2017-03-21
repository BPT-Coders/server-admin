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
		date >> /root/squidReboot.log
		echo "Нет необходимости" >> /root/squidReboot.log
		echo "" >> /root/squidReboot.log
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
		date >> /root/squidReboot.log
		echo "Перезагрузился\n" >> /root/squidReboot.log
		echo "" >> /root/squidReboot.log
fi




