#!/usr/bin/env python3
"""Read an HC-SR04 ultrasonic distance sensor five times.

Wiring: TRIG -> GPIO 5 (pin 29), ECHO -> GPIO 6 (pin 31) through a voltage
divider (ECHO is 5V; divide down to 3.3V with e.g. 1k/2k), VCC -> 5V, GND.
"""
from gpiozero import DistanceSensor
from time import sleep

sensor = DistanceSensor(echo=6, trigger=5, max_distance=4)

for i in range(5):
    print(f"distance: {sensor.distance * 100:.1f} cm")
    sleep(1)

print("Done.")
