#!/bin/bash
# Scan I2C bus 1 for connected devices (BME280, ADS1115, OLED displays, ...).
# Enable I2C once: sudo raspi-config -> Interface Options -> I2C.
if ! command -v i2cdetect >/dev/null; then
    echo "i2cdetect missing - install it with: sudo apt-get install i2c-tools"
    exit 1
fi
echo "Devices on I2C bus 1 (numbers are hex addresses):"
sudo i2cdetect -y 1
