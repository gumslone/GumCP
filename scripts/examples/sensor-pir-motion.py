#!/usr/bin/env python3
"""Watch a PIR motion sensor on GPIO 22 for 15 seconds.

Wiring: OUT -> GPIO 22 (pin 15), VCC -> 5V, GND -> GND.
Most PIR modules (HC-SR501) output 3.3V, safe for the Pi.
"""
from gpiozero import MotionSensor
from time import time

pir = MotionSensor(22)
print("Watching for motion on GPIO 22 for 15 s...")

end = time() + 15
events = 0
while time() < end:
    if pir.wait_for_motion(timeout=max(0.1, end - time())):
        events += 1
        print(f"Motion detected ({events})")
        pir.wait_for_no_motion(timeout=max(0.1, end - time()))

print(f"Done - {events} motion event(s).")
