#!/bin/bash

# Disable screen blanking/screensaver
xset s off
xset -dpms
xset s noblank

# Start lightweight window manager
openbox &
sleep 2
chromium  --no-sandbox --disable-gpu --kiosk http://nhstt-door-system-web/kiosk/