<?php

    namespace sam808;

    class Logger
    {
        public function log($severity, $message)
        {
            echo '[' . gethostname() . '] [' . getmypid() . '] [' . $severity . ']  ' . $message . PHP_EOL;
        }
    }