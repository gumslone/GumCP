#!/usr/bin/env python3
"""Wait up to 10 seconds for a button press on GPIO 27.

Wiring: button between GPIO 27 (pin 13) and GND — gpiozero enables the
internal pull-up, so pressing the button pulls the pin low.
"""
from gpiozero import Button

button = Button(27)    # BCM numbering (GPIO 27 = physical pin 13)

print("Press the button on GPIO 27 (waiting up to 10 s)...")
if button.wait_for_press(timeout=10):
    print("Pressed!")
else:
    print("No press detected — check the wiring.")
