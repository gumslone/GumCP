#!/usr/bin/env python3
"""Read a DHT11 / DHT22 temperature & humidity sensor on GPIO 4.

Wiring: data -> GPIO 4 (pin 7) with a 10k pull-up to 3.3V, V+ -> 3.3V, GND.
Needs the CircuitPython DHT library (one-time install):
    sudo pip3 install adafruit-circuitpython-dht
"""
import time

try:
    import board
    import adafruit_dht
except ImportError:
    print("Library missing - install it once with:")
    print("    sudo pip3 install adafruit-circuitpython-dht")
    raise SystemExit(1)

SENSOR = adafruit_dht.DHT22   # change to adafruit_dht.DHT11 for a DHT11
dht = SENSOR(board.D4)

# DHT sensors are timing-sensitive and often fail a read or two - retry.
for attempt in range(5):
    try:
        t = dht.temperature
        h = dht.humidity
        if t is not None and h is not None:
            print(f"Temperature: {t:.1f} C   Humidity: {h:.1f} %")
            break
    except RuntimeError as e:
        print(f"read {attempt + 1}/5 failed ({e.args[0]}), retrying...")
    time.sleep(2)
else:
    print("No reading after 5 attempts - check wiring and the sensor type.")
dht.exit()
