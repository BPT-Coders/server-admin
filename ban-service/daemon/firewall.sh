#!/bin/bash
###################################################
# Переменные
###################################################
#указываем внешний ip сервера и внешн. сетевой интерфейс
INET_IP1=192.168.1.111
INET_IFACE1=eth1
# указываем внутренний ip сервера и внутр. сетевой интерфейс
LAN_IP=192.168.137.254
LAN_IFACE=eth0
# внутренняя сеть
LAN_RANGE=192.168.137.0/24
# сетевой интерфейс петли и ip
LO_IFACE=lo
LO_IP=127.0.0.1
ip=iptables

whiteIp=( $(cat "/home/server-admin/server-admin.bpt.loc/public_html/ban-service/txt/whiteIP.txt") ) 

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
$ip -P INPUT DROP
$ip -P OUTPUT DROP
$ip -P FORWARD DROP
###################################################
# Включаем NAT для возможности выхода в интернет из локалки
###################################################
# "!" = адреса назначения все, кроме $LAN_RANGE
$ip -t nat -A POSTROUTING -o $INET_IFACE1 -s $LAN_RANGE ! -d $LAN_RANGE -j SNAT --to-source $INET_IP1 
###################################################
# Отбрасываем все пакеты, которые не могут быть
# идентифицированы и поэтому не могут иметь
# определенного статуса.
###################################################
$ip -A INPUT   -m state --state INVALID -j DROP
$ip -A FORWARD -m state --state INVALID -j DROP
###################################################
# Разрешаем трафик через петлю
###################################################
$ip -A INPUT -p all -i $LO_IFACE -j ACCEPT
$ip -A OUTPUT -p all -o $LO_IFACE -j ACCEPT
###################################################
# Разрешаем трафик через внутренний сет. адаптер
###################################################
$ip -A INPUT -p all -i $LAN_IFACE -s $LAN_RANGE --match state --state NEW,ESTABLISHED -j ACCEPT
$ip -A OUTPUT -p all -o $LAN_IFACE -d $LAN_RANGE --match state --state NEW,ESTABLISHED -j ACCEPT
###################################################
# Разрешаем входящие новые и установившиеся
# tcp-соединения с внешней сети к серверу и
# установившиеся и инициированные ими соединения
# с сервера в внешнюю сеть на порты 80(http) 
# 22(ssh)
###################################################
# из внешней сети можно будет подключиться к серверу по ssh,
# а с сервера к другому в интернете нельзя, так как в эту сторону новые  подключения блокируются
$ip -A INPUT -p tcp -i $INET_IFACE1 -m multiport --dports 80,22,25,110 --match state --state NEW,ESTABLISHED -j ACCEPT
$ip -A OUTPUT -p tcp -o $INET_IFACE1 -m multiport --sports 80,22,25,110 --match state --state ESTABLISHED,RELATED -j ACCEPT
###################################################
# Разрешаем при необходимости непосредственно с
# сервера выход в внешнюю сеть на определенные
# порты, например dns,http,https
###################################################
$ip -A INPUT -i $INET_IFACE1 -p tcp -m multiport --sports 80,53,443 -j ACCEPT
$ip -A OUTPUT -o $INET_IFACE1 -p tcp -m multiport --dports 80,53,443 -j ACCEPT
$ip -A INPUT -i $INET_IFACE1 -p udp -m multiport --sports 53 -j ACCEPT
$ip -A OUTPUT -o $INET_IFACE1 -p udp -m multiport --dports 53 -j ACCEPT
###################################################
# даём интернет разрешённым ip
####################################################
i=0
for i in "${whiteIp[@]}"
do
$ip -A FORWARD -s $i ! -d $LAN_RANGE -j ACCEPT
$ip -A FORWARD -d $i ! -s $LAN_RANGE -j ACCEPT
done

###################################################
# Разрешаем c сервера ping наружу, а сервер с
# внешней сети пинговать запрещаем
###################################################
$ip -A INPUT -p icmp -m icmp -i $INET_IFACE1 --icmp-type echo-reply -j ACCEPT
$ip -A OUTPUT -p icmp -m icmp -o $INET_IFACE1 --icmp-type echo-request -j ACCEPT
