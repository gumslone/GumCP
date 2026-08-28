#!/usr/bin/env python3
"""Blink an LED on GPIO 17 ten times.

Wiring: LED anode -> 330 ohm resistor -> GPIO 17 (pin 11), cathode -> GND.
Uses gpiozero, which is preinstalled on Raspberry Pi OS.
"""
from gpiozero import LED
from time import sleep

led = LED(17)          # BCM numbering (GPIO 17 = physical pin 11)

for i in range(10):
    led.on()
    sleep(0.3)
    led.off()
    sleep(0.3)
    print(f"blink {i + 1}/10")

print("Done.")
