#!/usr/bin/env python3
"""Drive a DC motor through an H-bridge (L298N / L293D / DRV8833).

Wiring: H-bridge IN1 -> GPIO 23 (pin 16), IN2 -> GPIO 24 (pin 18).
The motor gets its own supply through the H-bridge; share GND with the Pi.
"""
from gpiozero import Motor
from time import sleep

motor = Motor(forward=23, backward=24)   # BCM numbering

print("forward, half speed");  motor.forward(0.5);  sleep(2)
print("forward, full speed");  motor.forward(1.0);  sleep(2)
print("stop");                 motor.stop();        sleep(1)
print("backward, half speed"); motor.backward(0.5); sleep(2)
print("stop");                 motor.stop()
print("Done.")
