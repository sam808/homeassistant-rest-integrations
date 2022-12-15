# homeassistant-rest-integrations
Rando endpoints to be used as HA RESTful sensors because there isn't HA support for them


1. git clone to somewhere you can run this
2. composer install (will require php-curl and php-intl)
3. set up a sensor integration in HA (see instructions at https://www.home-assistant.io/integrations/sensor.rest/ or https://www.home-assistant.io/integrations/rest/ or copy the example below)
4. configure the services you'll be using in config/ with the template .jsons
5. use the source you want
5a. /api/tabuchi
5b. /api/bluebot
5c. api/intelesspv

# Tabuchi .yaml example
```
  - platform: rest
    name: tabuchi_solar_sensors
    json_attributes:
      - data
    value_template: "{{ value_json.data.status }}"
    resource: " http://localhost:8081/homeassistant-rest-integrations/api/tabuchi.php
  - platform: template
    sensors:
      tabuchi_solar_battery:
        value_template: "{{ state_attr('sensor.tabuchi_solar_sensors', 'data')['battery']['value'] }}"
        friendly_name: "Battery Life"
        entity_id: sensor.tabuchi_solar_battery_life
        unit_of_measurement: "%"
      tabuchi_solar_generation_lifetime:
        value_template: "{{ state_attr('sensor.tabuchi_solar_sensors', 'data')['generation']['lifetime']['value'] }}"
        friendly_name: "Lifetime Power Generation"
        entity_id: sensor.tabuchi_solar_power_generation_lifetime
        unit_of_measurement: "kWh"
      tabuchi_solar_generation_24h:
        value_template: "{{ state_attr('sensor.tabuchi_solar_sensors', 'data')['generation']['24h']['value'] }}"
        friendly_name: "24h Power Generation"
        entity_id: sensor.tabuchi_solar_power_generation_24h
        unit_of_measurement: "kWh"
      tabuchi_solar_generation_live:
        value_template: "{{ state_attr('sensor.tabuchi_solar_sensors', 'data')['generation']['live']['value'] }}"
        friendly_name: "Current Power Generation"
        entity_id: sensor.tabuchi_solar_power_generation_live
        unit_of_measurement: "kW"
      tabuchi_solar_usage_live_total:
        value_template: "{{ state_attr('sensor.tabuchi_solar_sensors', 'data')['usage']['live']['total_value'] }}"
        friendly_name: "Current Total Power Usage"
        entity_id: sensor.tabuchi_solar_power_usage_live_total
        unit_of_measurement: "kW"
      tabuchi_solar_usage_live_battery:
        value_template: "{{ state_attr('sensor.tabuchi_solar_sensors', 'data')['usage']['live']['battery_value'] }"
        friendly_name: "Current Battery Power Usage"
        entity_id: sensor.tabuchi_solar_power_usage_live_battery
        unit_of_measurement: "kW"
      tabuchi_solar_usage_live_grid:
        value_template: "{{ state_attr('sensor.tabuchi_solar_sensors', 'data')['usage']['live']['grid_value'] }}"
        friendly_name: "Current Grid Power Usage"
        entity_id: sensor.tabuchi_solar_power_usage_grid_total
        unit_of_measurement: "kW"
```