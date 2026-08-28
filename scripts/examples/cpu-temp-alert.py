#!/usr/bin/env python3
"""Read the CPU temperature and warn when it is running hot.

Pair it with a cron job (System -> Cron) to check periodically.
"""
WARN_AT = 70.0  # degrees Celsius

with open("/sys/class/thermal/thermal_zone0/temp") as f:
    temp = int(f.read().strip()) / 1000.0

print(f"CPU temperature: {temp:.1f} C")
if temp >= WARN_AT:
    print(f"WARNING: above {WARN_AT:.0f} C - check cooling and throttling "
          "(vcgencmd get_throttled)")
else:
    print("Temperature is fine.")
