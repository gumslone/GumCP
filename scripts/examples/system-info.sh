#!/bin/bash
# System overview: model, temperature, throttling, memory, disk.
echo "=== Model ==="
cat /proc/device-tree/model 2>/dev/null; echo

echo "=== CPU temperature ==="
if command -v vcgencmd >/dev/null; then
    vcgencmd measure_temp
    echo "Throttling: $(vcgencmd get_throttled)"
else
    awk '{printf "temp=%.1f'"'"'C\n", $1/1000}' /sys/class/thermal/thermal_zone0/temp
fi

echo "=== Memory ==="
free -h

echo "=== Disk ==="
df -h / /boot 2>/dev/null

echo "=== Uptime ==="
uptime
