#!/bin/bash
# Reclaim disk space: apt caches, old packages, old journal entries.
echo "Before:"; df -h / | tail -1
sudo apt-get -y autoremove --purge
sudo apt-get -y autoclean
sudo apt-get clean
sudo journalctl --vacuum-time=7d 2>/dev/null
echo "After:"; df -h / | tail -1
