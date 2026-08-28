#!/bin/bash
# List nearby WiFi networks with signal strength, strongest first.
IFACE=$(iw dev 2>/dev/null | awk '/Interface/{print $2; exit}')
IFACE=${IFACE:-wlan0}
sudo iw dev "$IFACE" scan 2>/dev/null \
    | awk '/^BSS/{mac=$2} /signal:/{sig=$2} /SSID:/{sub(/^\tSSID: /,""); printf "%6s dBm  %s\n", sig, $0}' \
    | sort -n -r
[ ${PIPESTATUS[0]} -eq 0 ] || echo "Scan failed — is $IFACE a wireless interface?"
