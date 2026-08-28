#!/usr/bin/env python3
"""Read a DS18B20 1-Wire temperature sensor - no extra libraries needed.

Wiring: data -> GPIO 4 (pin 7) with a 4.7k pull-up to 3.3V, V+ -> 3.3V, GND.
Enable the interface once:  sudo raspi-config -> Interface Options -> 1-Wire
(or add "dtoverlay=w1-gpio" to the boot config), then reboot.
"""
import glob

devices = glob.glob("/sys/bus/w1/devices/28-*/w1_slave")
if not devices:
    print("No DS18B20 found - is 1-Wire enabled and the sensor wired to GPIO 4?")
    raise SystemExit(1)

for dev in devices:
    with open(dev) as f:
        raw = f.read()
    if "YES" not in raw:
        print(f"{dev}: CRC check failed, try again")
        continue
    millideg = int(raw.split("t=")[-1])
    sensor_id = dev.split("/")[-2]
    print(f"{sensor_id}: {millideg / 1000:.2f} C")
