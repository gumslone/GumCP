#!/bin/bash
# Back up /etc and the GumCP config to a dated tarball in your home directory.
# Restore with: tar -xzf pi-backup-<date>.tar.gz
DEST="$HOME/pi-backup-$(date +%Y-%m-%d).tar.gz"
sudo tar -czf "$DEST" \
    /etc \
    /var/spool/cron 2>/dev/null
sudo chown "$USER" "$DEST"
echo "Backup written to $DEST ($(du -h "$DEST" | cut -f1))"
