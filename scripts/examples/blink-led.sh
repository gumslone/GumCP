#!/bin/bash
# Blink the green activity LED 5 times, then hand it back to the system.
# Works on most models; the LED name varies (led0 on older ones).
LED=/sys/class/leds/ACT
[ -d "$LED" ] || LED=/sys/class/leds/led0
[ -d "$LED" ] || { echo "No activity LED found"; exit 1; }

TRIGGER=$(cat "$LED/trigger" | grep -o '\[.*\]' | tr -d '[]')
for i in 1 2 3 4 5; do
    echo 1 | sudo tee "$LED/brightness" >/dev/null; sleep 0.4
    echo 0 | sudo tee "$LED/brightness" >/dev/null; sleep 0.4
done
echo "$TRIGGER" | sudo tee "$LED/trigger" >/dev/null
echo "Blinked 5 times (LED: $LED, restored trigger: $TRIGGER)"
