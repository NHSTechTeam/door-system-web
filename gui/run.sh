#!/bin/bash

set -e

apt update

DEBIAN_FRONTEND=noninteractive apt install -y \
    chromium \
    openbox \
    x11-xserver-utils

# Disable screen blanking/screensaver
xset s off
xset -dpms
xset s noblank

# Start lightweight window manager
openbox &

sleep 2

# Launch Chromium in kiosk mode
chromium \
    --no-sandbox \
    --disable-gpu \
    --kiosk \
    http://localhost:3004/kiosk/