#!/usr/bin/env python3
"""Sweep a hobby servo on GPIO 18: min -> mid -> max and back.

Wiring: servo signal -> GPIO 18 (pin 12), V+ -> 5V, GND -> GND.
Power hungry servos need their own supply — share only GND with the Pi.
"""
from gpiozero import Servo
from time import sleep

servo = Servo(18)      # BCM numbering (GPIO 18 = physical pin 12, PWM capable)

for name, pos in [("min", -1), ("mid", 0), ("max", 1), ("mid", 0), ("min", -1)]:
    print(f"-> {name}")
    servo.value = pos
    sleep(1)

servo.detach()         # stop sending pulses so the servo relaxes
print("Done.")
