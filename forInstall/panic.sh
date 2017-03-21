#!/bin/bash
echo "Перехожу в режим готовности к проверке..."

###################################################
# Сброс настроек iptables (Очистка таблиц)
###################################################
iptables -F -t filter
iptables -F -t nat
iptables -F -t mangle
iptables -F
###################################################
# Политики по умолчанию: все блокировать что явно не разрешено ниже  =)
###################################################
iptables -P INPUT ACCEPT
iptables -P OUTPUT ACCEPT
iptables -P FORWARD DROP
# На случай проверки
iptables -t nat -A POSTROUTING -o eth1 -j MASQUERADE
# Заворачиваем на squid http https
iptables -t nat -A PREROUTING -p tcp -m tcp -s 192.168.137.0/24 ! -d 192.168.137.0/24 --dport 443 -j REDIRECT --to-ports 3129
iptables -t nat -A PREROUTING -p tcp -m tcp -s 192.168.137.0/24 ! -d 192.168.137.0/24 --dport 80 -j REDIRECT --to-ports 3128
# Разрешаем ssh
iptables -A FORWARD  -s 192.168.137.0/24 ! -d 192.168.137.0/24 -p tcp -m tcp --dport 22 -j ACCEPT
# Разрешаем IMAP
iptables -A FORWARD  -s 192.168.137.0/24 ! -d 192.168.137.0/24 -p tcp -m tcp --dport 993 -j ACCEPT
#iptables -A FORWARD  -s 192.168.137.0/24 ! -d 192.168.137.0/24 -p tcp -m tcp --dport 20 -j ACCEPT

# Разрешаем обратные подключения
iptables -A FORWARD  -d 192.168.137.0/24 ! -s 192.168.137.0/24 -j ACCEPT
echo "..."
echo "Переключился в режим готовности к проверки"
