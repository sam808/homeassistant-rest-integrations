<?php

    namespace sam808;

    class Solark
    {
        const URI_HOME = 'https://www.mysolark.com/';
        const URI_LOGIN = 'https://www.solarkcloud.com/oauth/token';
        const URI_FLOW_DATA = 'https://www.solarkcloud.com/api/v1/plant/energy/%s/flow?date=%s';
        const URI_USAGE_DATA = 'https://pv.inteless.com/plants/overview/%s/2';

        private static $debug;

        private static $config;
        private $session;
        private $logger;
        
        public function __construct()
        {
            self::$config = json_decode(file_get_contents('../config/solark.json'), TRUE);
            self::$debug = (self::$config['debug'] === TRUE);
            $this->session = new \Transeo\Tools\Curl();
            $this->session->persist();
            $this->session->setTimeout(120);

            if (!defined('ENVIRONMENT')) {
                define('ENVIRONMENT', 'production');
            }

            $this->logger = new \Transeo\Loggers\EchoLogger();
        }

        private static function format_power_number($number)
        {

            if (empty(preg_replace('/[^0-9]/', '', $number))) {
                return 0.00;
            }

            $number = preg_replace('/[^0-9\.]/', '', $number);

            return round($number, 2);

        }

        public function fetch()
        {
            if (self::$debug) {
                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [intelesspv] Logging in');
            }

            $this->session->URLFetch(
                self::URI_LOGIN,
                json_encode([
                    'username'      => self::$config['user_id'],
                    'password'      => self::$config['password'],
                    'grant_type'    => 'password',
                    'client_id'     => 'csp-web'
                ]),
                [
                    'Accept: application/json',
                    'Content-Type: application/json;charset=UTF-8',
                    'Origin: ' . self::URI_HOME,
                ],
                self::$debug
            );

            if (self::$debug) {
                $info = $this->session->GetInfo();
                $error = $this->session->GetError();

                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [' . get_class(self) . '] Logged in');
                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [' . get_class(self) . '] ' . json_encode($info));
            }
            
            if (self::$debug) {
                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [' . get_class(self) . '] Getting data');
            }

            $token = json_decode($this->session->response, TRUE)['data']['access_token'];

            $this->session->URLFetch(
                sprintf(self::URI_FLOW_DATA, self::$config['plant_id'], date('Y-m-d')),
                NULL,
                [
                    'Accept: application/json',
                    'Authorization: Bearer ' . $token,
                    'Origin: ' . self::URI_HOME,
                ],
                self::$debug
            );

            $json = json_decode($this->session->response, TRUE);

            if (self::$debug) {
                $info = $this->session->GetInfo();
                $error = $this->session->GetError();

                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [' . get_class(self) . '] Fetched data URI');
                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [' . get_class(self) . '] ' . json_encode($this->session->response));
                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [' . get_class(self) . '] ' . json_encode($info));
                
                print_r($json);
            }


            echo json_encode([
                'data' => [
                    'battery'       => [
                        'live_supply'   => [
                            'value'         => ($json['data']['batTo']) ? self::format_power_number($json['data']['battPower']) : 0,
                            'uom'           => '%'
                        ],
                        'live_soc'      => [
                            'value'         => $json['data']['soc'],
                            'uom'           => '%'
                        ],
                    ],
                    'generation'    => [
                        'live'          => [
                            'value'         => self::format_power_number($json['data']['pvPower']),
                            'uom'           => 'W',
                        ],
                    ],
                    'usage'         => [
                        'live'          => [
                            'battery_demand_value'  => ($json['data']['toBat']) ? self::format_power_number($json['data']['battPower']) : 0,
                            'grid_supply_value'     => ($json['data']['gridTo']) ? self::format_power_number($json['data']['gridOrMeterPower']) : 0,
                            'demand_value'          => self::format_power_number($json['data']['loadOrEpsPower']),
                            'uom'                   => 'W',
                        ]        
                    ],
                ]
            ]);
        }
    }

/* there's a simpler use json too
we could probably use this instead

https://www.solarkcloud.com/api/v1/plant/energy/118900/generation/use

{
    "code": 0,
    "msg": "Success",
    "data": {
        "load": 10.70,
        "pv": 33.80,
        "batteryCharge": 22.80,
        "gridSell": 0.30
    },
    "success": true
}

 */

    /* SAMPLE JSON RESPONSE FOR FLOW DATA

 {
  "code": 0,
  "msg": "Success",
  "data": {
    "custCode": 29,
    "meterCode": 0,
    "pvPower": 0,
    "battPower": 4478,
    "gridOrMeterPower": 1,
    "loadOrEpsPower": 4232,
    "genPower": 0,
    "minPower": 0,
    "soc": 49,
    "pvTo": false,
    "toLoad": true,
    "toGrid": false,
    "toBat": false,
    "batTo": true,
    "gridTo": true,
    "genTo": false,
    "minTo": false,
    "existsGen": false,
    "existsMin": false,
    "genOn": false,
    "microOn": false,
    "existsMeter": false,
    "bmsCommFaultFlag": false
  },
  "success": true
}

    */