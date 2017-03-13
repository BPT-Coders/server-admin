#!/bin/bash
echo "Перехожу в режим готовности к проверке..."

###################################################
# Переменные
###################################################
#указываем внешний ip сервера и внешн. сетевой интерфейс
#INET_IP1=192.168.1.111
#INET_IFACE1=eth1
# указываем внутренний ip сервера и внутр. сетевой интерфейс
#LAN_IP=192.168.137.254
#LAN_IFACE=eth0
# внутренняя сеть
#LAN_RANGE=192.168.137.0/24
# сетевой интерфейс петли и ip
#LO_IFACE=lo
#LO_IP=127.0.0.1
ip=iptables


###################################################
# Сброс настроек iptables (Очистка таблиц)
###################################################
$ip -F -t filter
$ip -F -t nat
$ip -F -t mangle
$ip -F
###################################################
# Политики по умолчанию: все блокировать что явно не разрешено ниже  =)
###################################################
$ip -P INPUT ACCEPT
$ip -P OUTPUT ACCEPT
$ip -P FORWARD ACCEPT
# На случай проверки
iptables -t nat -A POSTROUTING -o eth1 -j MASQUERADE
iptables -t nat -A PREROUTING -p tcp -m tcp -s 192.168.137.0/24 --dport 443 -j REDIRECT --to-ports 3129
iptables -t nat -A PREROUTING -p tcp -m tcp -s 192.168.137.0/24 --dport 80 -j REDIRECT --to-ports 3128

echo "..."
echo "Переключился в режим готовности к проверки"
