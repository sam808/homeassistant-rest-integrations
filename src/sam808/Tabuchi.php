<?php

    namespace sam808;

    class Tabuchi
    {
        const URI_HOME = 'https://ap.p3.enetelus.com/en/';
        const URI_LOGIN = 'https://ap.p3.enetelus.com/Thingworx/Server/*/action-login/';
        const URI_SIGNAGE_DATA = 'https://ap.p3.enetelus.com/Thingworx/Things/Thg_DigitalSignageController/Services/GetDigitalSignageDataFromFacilityId';

        private static $debug;

        private static $config;
        private $session;
        private $logger;
        
        public function __construct()
        {
            self::$config = json_decode(file_get_contents('../config/tabuchi.json'), TRUE);
            self::$debug = (self::$config['debug'] === TRUE);
            $this->session = new \Transeo\Tools\Curl();
            $this->session->persist();
            $this->session->setTimeout(120);

            if (!defined('ENVIRONMENT')) {
                define('ENVIRONMENT', 'production');
            }

            $this->logger = new \Transeo\Loggers\EchoLogger();
        }

        public function fetch()
        {
            if (self::$debug) {
                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [tabuchi] Logging in');
            }

            $this->session->URLFetch(self::URI_LOGIN, [
                'thingworx-form-userid'     => self::$config['user_id'],
                'thingworx-form-password'   => self::$config['password'],
                'x-thingworx-session'       => TRUE,
                'redirectUri'               => '/Thingworx/Runtime/index.html#mashup=MashLogin'
            ], NULL, self::$debug);

            if (self::$debug) {
                $info = $this->session->GetInfo();
                $error = $this->session->GetError();

                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [tabuchi] Logged in');
                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [tabuchi] ' . json_encode($info));
            }
            
            if (self::$debug) {
                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [tabuchi] Getting data');
            }

            $this->session->URLFetch(
                self::URI_SIGNAGE_DATA,
                json_encode([
                    'inFacilityId'  => self::$config['facility_id'],
                ]),
                [
                    'Accept: application/json, text/javascript, */*; q=0.01',
                    'Content-Type: application/json',
                    'Origin: https://ap.p3.enetelus.com'
                ],
                self::$debug
            );

            $json = json_decode($this->session->response, TRUE);

            if (self::$debug) {
                $info = $this->session->GetInfo();
                $error = $this->session->GetError();

                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [tabuchi] Fetched data URI');
                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [tabuchi] ' . json_encode($this->session->response));
                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [tabuchi] ' . json_encode($info));
                
                print_r($json);
            }


            echo json_encode([
                'data' => [
                    'status'        => $json['data']['facility'][0]['Status']['valuestring'],
                    'capacity'      => $json['data']['facility'][0]['FacilityCapacity'],
                    'datetime'      => $json['data']['facility'][0]['TimeStamp']['value'],
                    'battery'       => [
                        'value'         => $json['data']['facility'][0]['gw'][0]['remocon'][0]['Soc']['value'],
                        'uom'           => $json['data']['facility'][0]['gw'][0]['remocon'][0]['Soc']['unit'],
                    ],
                    'generation'    => [
                        '24h'           => [
                            'value'         => $json['data']['facility'][0]['TodayElectricEnergy']['value'],
                            'uom'           => $json['data']['facility'][0]['TodayElectricEnergy']['unit'],
                        ],
                        'lifetime'  => [
                            'value'         => $json['data']['facility'][0]['TotalElectricEnergy']['value'],
                            'uom'           => $json['data']['facility'][0]['TotalElectricEnergy']['unit'],
                        ],
                        'live'          => [
                            'value'         => $json['data']['facility'][0]['TodayPower']['value'],
                            'uom'           => $json['data']['facility'][0]['TodayPower']['unit'],
                        ],
                    ],
                    'usage'         => [
                        'live'          => [
                            'battery_value' => $json['data']['facility'][0]['gw'][0]['remocon'][0]['Battery'],
                            'grid_value'    => $json['data']['facility'][0]['gw'][0]['remocon'][0]['BuyPower'],
                            'total_value'   => $json['data']['facility'][0]['gw'][0]['remocon'][0]['UsePower'],
                            'uom'           => $json['data']['facility'][0]['gw'][0]['remocon'][0]['Power']['unit'],
                        ]        
                    ],
                ]
            ]);
        }
    }

    /* SAMPLE JSON RESPONSE

 {
    "data": {
      "facility_count": 1,
      "facility": [
        {
          "Status": {
            "valuestring": "Running",
            "name": "状態",
            "value": 112
          },
          "gw_count": 1,
          "TodayTemperature": {
            "unit": "&deg;F",
            "name": "気温",
            "value": "---"
          },
          "TotalElectricEnergy": {
            "unit": "kWh",
            "name": "積算電力量",
            "value": "13,237"
          },
          "DeviceTypeCode": "6",
          "TodayPower": {
            "unit": "kW",
            "name": "発電電力",
            "value": "---"
          },
          "TodaySolarRadiation": {
            "unit": "W/m&sup2",
            "name": "日射強度",
            "value": "---"
          },
          "FacilityCapacity": 7.32,
          "FacilityName": "CRAIG-KING",
          "TimeStamp": {
            "name": "データ更新日時",
            "value": "2022-01-17 19:12"
          },
          "ThermometerFlg": false,
          "gw": [
            {
              "GWNumber": "01",
              "GPS": "",
              "remocon_count": 1,
              "remocon": [
                {
                  "Status": {
                    "name": "状態",
                    "value": "---"
                  },
                  "VisibleFlg": true,
                  "BuyPower": "2.67",
                  "RCNumber": {
                    "name": "リモコン局番",
                    "value": "01"
                  },
                  "GenMode": {
                    "valuestr": "Economy",
                    "name": "運転モード"
                  },
                  "GWNumber": "01",
                  "Soc": {
                    "valueStr": 100,
                    "unit": "%",
                    "name": "残容量",
                    "value": 100
                  },
                  "Battery": "0.00",
                  "UsePower": "2.67",
                  "SellPower": "0.00",
                  "Power": {
                    "unit": "kW",
                    "name": "電力",
                    "value": "0.00"
                  },
                  "Discharge": "0.00"
                }
              ]
            }
          ],
          "FacilityId": "FB99110000003177",
          "AddedDate": "20220117",
          "TodayElectricEnergy": {
            "unit": "kWh",
            "name": "本日の電力量",
            "value": "16.0"
          },
          "PyranometerFlg": false
        }
      ]
    }
  }
    */