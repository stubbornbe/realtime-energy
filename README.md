# Realtime Energy smart meter | slimme meter

Ga naar de [Nederlandse readme](https://github.com/stubbornbe/realtime-energy/blob/main/README.nl.md)

Webapp to show real time energy consumption based on live readings from electricity meter P1-port and SMA Solar inverter

![mockup-small](https://github.com/user-attachments/assets/fb0771be-82e6-452d-bec4-2a595e65fb29)

## Description
Most people with a digital meter face the same problem: How do we pull usefull data from it on the fly? Energy companies provide you with historical data, but always with a big delay. When you're living f.e. in Belgium and suppliers decide to overcharge you when your energy consumpion is above a certain value, it is obvious that you need to know what your current consumption is. That's exactly what this little web app takes care of!

Every 2 seconds the current consumption is calculated based on what you pull from the net and what your solar panels are delivering.
Based on that value, you can decide if you're willing to start another "big user" such as a washing machine or a vacuum cleaner.
You can set up a warning treshold as well.

Data obtained opens doors for further interactions with home automation (domotica) and historical logging.

This project doesn't only cover the end product website, but all steps taken to read out a P1 port and SMA web API.

## Features

- Display yield solar panels
- Display current consumption
- Display demand/injection from/to the net
- Alert when consumption above treshold
- Show current monthly peak
- Show average consumption last 15 minutes

## Prerequisites

- Linux based OS
- An electricity meter with connected P1 port via serial or USB convertor
- A SMA based solar invertor available via LAN
- Apache webserver
- Php
- Python
- Some time, this project has no installer

### OPTIONAL

- Cacti for rrd logging

## Installation & Configuration

All installation & configuration steps can be found in the Wiki:

- Reading out values from meter to json file
- Reading out values from solar panels to json file
- Setting up services to automate above
- Debug tricks
- Link json files to php project and start using

### OPTIONAL

- Confige Cacti to store historical data based on the json files

## Thanks to
- [jensdepuydt](https://github.com/jensdepuydt/belgian_digitalmeter_p1): For providing a Python based script to read out P1 telegrams
