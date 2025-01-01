<?php

    namespace sam808;

    class BlueBot
    {
        const URI_HOME = 'https://ap.p3.enetelus.com/en/';
        const URI_LOGIN = 'https://dashboard.bluebot.com/login';

        const API_TOKEN_POST = [
            'grant_type' => 'password',
            'username' => null,
            'password' => null,
            // 'audience' => 'https://bluebot-production.us.auth0.com/api/v2/',
            'audience' => 'https://prod.bluebot.com/',
            'client_id' => 'kyf00IZ8iCjOH8aPd0i7RUh7wsLRl1H7',
            'client_secret' => 'n732T_pxM1K0asGQqqEpkVi9dwOLr4aKZTDPzK635p6mlew4Sw0EiaV0kwqIibR-'
        ];
        const URI_API_TOKEN = 'https://bluebot-production.us.auth0.com/oauth/token';
        // dashboard authorizes both audiences, but we only need the 2nd
        // {
        //   "grant_type":"password",
        //   "username":"***",
        //   "password":"***",
        //   "audience":"https://bluebot-production.us.auth0.com/api/v2/",
        //   "client_id":"kyf00IZ8iCjOH8aPd0i7RUh7wsLRl1H7",
        //   "client_secret":"n732T_pxM1K0asGQqqEpkVi9dwOLr4aKZTDPzK635p6mlew4Sw0EiaV0kwqIibR-"
        // }
        // {
        //   "access_token": "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6Il9DOUZlUDA2TlNReE5FaWxmNlBqciJ9.eyJodHRwczovL2JsdWVib3QuY29tL2FjY291bnRfaWQiOiI0NWIxNDVhZi03ZDJiLTQ1ZDQtOWEyZS1iZTdiZWFhOGQxYWYiLCJpc3MiOiJodHRwczovL2JsdWVib3QtcHJvZHVjdGlvbi51cy5hdXRoMC5jb20vIiwic3ViIjoiYXV0aDB8NjQ4NGI3M2NlNWZiYThhNTA0ZjI5OTEyIiwiYXVkIjoiaHR0cHM6Ly9wcm9kLmJsdWVib3QuY29tLyIsImlhdCI6MTczNTY5NTM0MSwiZXhwIjoxNzM4Mjg3MzQxLCJndHkiOiJwYXNzd29yZCIsImF6cCI6Imt5ZjAwSVo4aUNqT0g4YVBkMGk3UlVoN3dzTFJsMUg3IiwicGVybWlzc2lvbnMiOlsibWFuYWdlbWVudC53cml0ZSJdfQ.LZvnKp-63R0w2n5pLKPHbgtyuoIvxyWq-lO8Z6P60G5i_Fe6JwWQjbRiv2fIeUCXOfoUCrb8gwWoiCUbaVgbFuSGj2FjQZKmO-TYPSLFqKir1WHq_rteanAwRpU0NPK6mZQgUbZd7We3dxsAKxVMJ9H3J5NmoW8G-8LqUkNeYfyZ1ZYd1TAYwOhL-TscRH9aMupQw82MeLoI_efAox4fe8g0wBrGU2beWF7J7RHT7AuqiSK9M_VZB-M8QuGno5P_PMq-xT3XKRH_6JtkbZmMaZZh-lq91IaqWEJFIZnKmPGCf80XqiiF_ZMVunF-NvrTsCF9bzFIEpax_nmwAtAIHw",
        //   "expires_in": 2592000,
        //   "token_type": "Bearer"
        // }

        const URI_API_DEVICES = 'https://prod.bluebot.com/management/v1/device';
        // [
        //   {
        //       "id": "***",
        //       "serialNumber": "***",
        //       "created": "2022-01-10T19:56:46.443Z",
        //       "updated": "2024-04-01T20:44:03.537Z",
        //       "label": "Irrigation Inflow",
        //       "deviceType": null,
        //       "commissioned": true,
        //       "lastMessageReceived": null,
        //       "installedOn": "2022-01-15T23:26:41.805Z",
        //       "installed": true,
        //       "color": null,
        //       "costPerGallon": 0.013555555555555555,
        //       "dailyBudget": 1161.2903225806451,
        //       "alertsActive": null,
        //       "kFactor": 0,
        //       "groupWatched": false,
        //       "parentWatched": false,
        //       "deviceWatched": false,
        //       "deviceTimeZone": "Pacific/Honolulu",
        //       "deviceGroupId": "***",
        //       "accountId": "***",
        //       "organizationId": null,
        //       "model": null,
        //       "resellerId": null,
        //       "silenceSystemAlerts": true,
        //       "pauseSystemAlerts": false,
        //       "distributorId": null,
        //       "boundPeriodStartDate": null,
        //       "favorite": false,
        //       "category": "EndDevice",
        //       "name": null,
        //       "macAddress": null,
        //       "status": null,
        //       "active": true,
        //       "manufacturerSerialNumber": null,
        //       "legacyId": 695,
        //       "networkUniqueIdentifier": "***",
        //       "accessPolicy": {
        //           "role": "owner"
        //       }
        //   }
        // ]

        // 'https://prod.bluebot.com/flow/v1/math/daily-tz?range_start=1727690400&range_end=1735725599&inflows=serial***';
        // used on the maind ashboard report/chart
        // [
        //   {
        //       "timestamp": "1727690400",
        //       "param": [
        //           "BB8100010815"
        //       ],
        //       "value": 0.02016772805200222,
        //       "units": "Gallons"
        //   },
        //   {
        //       "timestamp": "1727776800",
        //       "param": [
        //           "BB8100010815"
        //       ],
        //       "value": 0,
        //       "units": "Gallons"
        //   },
        //   {
        //       "timestamp": "1727863200",
        //       "param": [
        //           "BB8100010815"
        //       ],
        //       "value": 0.021055337386412222,
        //       "units": "Gallons"
        //   },
        //   ...
        // ]

        // 'https://prod.bluebot.com/high-res/data?serial_number=***&time_range=202412312349-202501010149';
        // used on the main dashboard high-res report
        // time range is in UTC YYYYMMDDHHMM-YYYYMMDDHHMM

        // [
        //   {
        //     "server_timestamp":1735686064,
        //     "raw":0.05001,
        //     "processed_gpm":0.220187362,
        //     "sq":"98"
        //   },
        //   {
        //     "server_timestamp":1735686066,
        //     "raw":0.0444,
        //     "processed_gpm":0.19548728000000004,
        //     "sq":"98"
        //   },
        //   {
        //     "server_timestamp":1735686068,
        //     "raw":0.049847,
        //     "processed_gpm":0.21946969473333336,
        //     "sq":"98"
        //   },
        //   ...
        // ]

        const URI_API_DEVICE_TOTAL = 'https://prod.bluebot.com/flow/v1/total/daily-tz/%s?include_running=true';
        // %s is serial number

        // [
        //     {
        //         "unit": "Gallon",
        //         "value": 475.05837024540114,
        //         "statName": "DailyTzTotal",
        //         "meterId": "***",
        //         "timestamp": 1735639200
        //     },
        //     {
        //         "timestamp": "1735725600",
        //         "unit": "Gallon",
        //         "meterId": "***",
        //         "statName": "RunningDailyTzTotal",
        //         "value": 113.64267582199446
        //     }
        // ]


        const URI_EXPORT_USAGE_DAILY = 'https://prod.bluebot.com/flow/v1/total/daily-tz/%s?range_start=%s&range_end=%s&format=csv';
        const URI_EXPORT_USAGE_HOURLY = 'https://prod.bluebot.com/flow/v1/total/hourly/%s?range_start=%s&range_end=%s&format=csv';
        // first parameter is serial number of the device
        // used in the export (daily/hourly)

        // date,timestamp,total_gallons
        // 2024-12-30T10:00:00.000Z,1735552800,529.62



        private static $debug;
        private static $verbose;

        private static $config;
        private $session;
        private $logger;
        
        public function __construct()
        {
            self::$config = json_decode(file_get_contents('../config/bluebot.json'), TRUE);
            self::$debug = (self::$config['debug'] === TRUE);
            self::$verbose = (self::$config['verbose'] === TRUE);
            $this->session = new \Transeo\Tools\Curl();
            $this->session->persist();
            $this->session->setTimeout(120);

            // date_default_timezone_set('UTC');

            if (!defined('ENVIRONMENT')) {
                define('ENVIRONMENT', 'production');
            }

            $this->logger = new Logger();
        }

        public function fetch()
        {
            if (self::$debug) {
                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] Logging in');
            }

            $post = self::API_TOKEN_POST;
            $post['username'] = self::$config['user_id'];
            $post['password'] = self::$config['password'];

            $this->session->URLFetch(self::URI_API_TOKEN, json_encode($post, JSON_UNESCAPED_SLASHES), [
                'content-type: application/json'
            ]);
            $json = json_decode($this->session->response, TRUE);
            $access_token = $json['access_token'];

            if (self::$debug) {
                if (self::$verbose) {
                    $info = $this->session->GetInfo();
                    $error = $this->session->GetError();
                    $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] ' . json_encode($info));

                    if (!empty($error)) {
                        $this->logger->log('error', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] ' . json_encode($error));
                    }
                }

                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] Logged in');

                print_r($json);
            }

            if (self::$debug) {
                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] Getting devices');
            }

            $this->session->URLFetch(self::URI_API_DEVICES, NULL, [
                'content-type: application/json',
                'Authorization: Bearer ' . $access_token,
            ]);
            $json = json_decode($this->session->response, TRUE);
            $devices = $json;

            if (self::$debug) {
                if (self::$verbose) {
                    $info = $this->session->GetInfo();
                    $error = $this->session->GetError();
                    $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] ' . json_encode($info));

                    if (!empty($error)) {
                        $this->logger->log('error', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] ' . json_encode($error));
                    }
                }

                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] Fetched devices URI');
                
                print_r($json);
            }

            if (self::$debug) {
                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] Getting usage data');
            }

            $this->session->URLFetch(sprintf(self::URI_EXPORT_USAGE_DAILY, $devices[0]['serialNumber'], strtotime(date('Y-m-01') . ' UTC'), strtotime('tomorrow UTC')), NULL, [
                'content-type: application/json',
                'Authorization: Bearer ' . $access_token
            ]);

            $csv = $this->session->response;
            $usage_this_month = \Transeo\Tools\Excel::csvToArray($csv);

            if (self::$debug) {
                if (self::$verbose) {
                    $info = $this->session->GetInfo();
                    $error = $this->session->GetError();
                    $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] ' . json_encode($info));

                    if (!empty($error)) {
                        $this->logger->log('error', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] ' . json_encode($error));
                    }
                }

                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] Fetched MTD usage data CSV');
                
                print_r($csv);
                print_r($usage_this_month);
            }

            $last_month = strtotime('-1 month');
            $this->session->URLFetch(sprintf(self::URI_EXPORT_USAGE_DAILY, $devices[0]['serialNumber'], strtotime(date('Y-m-01', $last_month) . ' UTC'), strtotime(date('Y-m-t', $last_month) . ' UTC')), NULL, [
                'content-type: application/json',
                'Authorization: Bearer ' . $access_token
            ]);

            $csv = $this->session->response;
            $usage_last_month = \Transeo\Tools\Excel::csvToArray($csv);

            if (self::$debug) {
                if (self::$verbose) {
                    $info = $this->session->GetInfo();
                    $error = $this->session->GetError();
                    $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] ' . json_encode($info));

                    if (!empty($error)) {
                        $this->logger->log('error', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] ' . json_encode($error));
                    }
                }

                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] Fetched last month usage data CSV');
                
                print_r($csv);
                print_r($usage_last_month);
            }

            $this->session->URLFetch(sprintf(self::URI_API_DEVICE_TOTAL, $devices[0]['serialNumber']), NULL, [
                'content-type: application/json',
                'Authorization: Bearer ' . $access_token
            ]);

            $json = $this->session->response;
            $usage_today = json_decode($json, TRUE);

            if (self::$debug) {
                if (self::$verbose) {
                    $info = $this->session->GetInfo();
                    $error = $this->session->GetError();
                    $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] ' . json_encode($info));

                    if (!empty($error)) {
                        $this->logger->log('error', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] ' . json_encode($error));
                    }
                }

                $this->logger->log('info', '[' . \Transeo\Helpers\Dates::toMySQL() . '] [bluebot] Fetched current usage data JSON');
                
                print_r($json);
                print_r($usage_today);
            }

            $total_today = array_values($usage_today)[1]['value'];
            $total_mtd = $total_today + \Transeo\Helpers\ArrayDatasets::sum($usage_this_month, 'total_gallons');
            $total_last_month = \Transeo\Helpers\ArrayDatasets::sum($usage_last_month, 'total_gallons');

            echo json_encode([
                'data' => [
                    'active'        => $devices[0]['active'],
                    'label'         => $devices[0]['label'],
                    'usage'         => [
                        'today_value'         => round($total_today, 2),
                        'mtd_value'           => round($total_mtd, 2),
                        'last_month_value'    => round($total_last_month, 2),
                    ]
                ]
            ]);
        }
    }