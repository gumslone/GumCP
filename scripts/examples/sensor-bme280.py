#!/usr/bin/env python3
"""Read a BME280 temperature / humidity / pressure sensor over I2C.

Wiring: SDA -> GPIO 2 (pin 3), SCL -> GPIO 3 (pin 5), V+ -> 3.3V, GND.
Enable I2C once: sudo raspi-config -> Interface Options -> I2C.
Needs (one-time install):
    sudo pip3 install RPi.bme280 smbus2
Find the address first with the i2c-scan example (0x76 or 0x77).
"""
try:
    import smbus2
    import bme280
except ImportError:
    print("Libraries missing - install them once with:")
    print("    sudo pip3 install RPi.bme280 smbus2")
    raise SystemExit(1)

ADDRESS = 0x76        # change to 0x77 if the scan shows 77

bus = smbus2.SMBus(1)
calibration = bme280.load_calibration_params(bus, ADDRESS)
data = bme280.sample(bus, ADDRESS, calibration)

print(f"Temperature: {data.temperature:.1f} C")
print(f"Humidity:    {data.humidity:.1f} %")
print(f"Pressure:    {data.pressure:.1f} hPa")
