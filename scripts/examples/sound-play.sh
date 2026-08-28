#!/bin/bash
# Play a sound through the Pi's audio output (3.5mm jack or HDMI).
# Pick the output first if needed:  sudo raspi-config -> System -> Audio.
# Pair it with a button or cron job for alerts, doorbells or reminders.

# Set volume to 80% (device name varies by model - try both, ignore failures).
amixer sset Master 80% >/dev/null 2>&1
amixer sset PCM 80%    >/dev/null 2>&1

WAV="/usr/share/sounds/alsa/Front_Center.wav"   # replace with your own .wav
if [ -f "$WAV" ]; then
    echo "Playing $WAV"
    aplay -q "$WAV"
elif command -v speaker-test >/dev/null; then
    echo "No wav found - playing a 2 s test tone instead"
    timeout 2 speaker-test -t sine -f 800 >/dev/null 2>&1
    true
else
    echo "Install ALSA utilities first: sudo apt-get install alsa-utils"
    exit 1
fi
echo "Done. Tip: 'espeak \"hello\"' speaks text (sudo apt-get install espeak)."
