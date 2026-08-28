#!/usr/bin/env python3
"""Read an LDR (photoresistor) on GPIO 25 using a capacitor charge circuit.

Wiring: LDR from 3.3V to GPIO 25 (pin 22), and a 1uF capacitor from
GPIO 25 to GND. gpiozero times how fast the capacitor charges - no ADC needed.
Values range 0.0 (dark) to 1.0 (bright).
"""
from gpiozero import LightSensor
from time import sleep

sensor = LightSensor(25)

for i in range(5):
    level = sensor.value
    bar = "#" * int(level * 30)
    print(f"light level: {level:.2f}  {bar}")
    sleep(1)
print("Done.")
