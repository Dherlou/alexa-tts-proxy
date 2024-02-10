<?php

    class AlexaSkillApi {

        private Config $config;

        public function __construct()
        {
            $this->config = new Config();
        }

        public function sendText(string $text): void {
            if (empty($text) === true) {
                return;
            }
            
            self::saveText($text);
            self::triggerRead();
        }

        private function saveText(string $text): void {
            self::sendRequest(
                "https://esp8266-server.de/alexa/TextVorlesen/get/"
                . "?id=" . $this->config->getValue(['skills', 'text_vorlesen', 'id'])
                . "&hash=" . $this->config->getValue(['skills', 'text_vorlesen', 'hash'])
                . "&SendeText=" . urlencode($text)
            );
        }

        private function triggerRead(): void {
            $this->sendRequest(
                "https://trigger.esp8266-server.de/api/"
                . "?id=" . $this->config->getValue(['skills', 'routine_trigger', 'id'])
                . "&hash=" . $this->config->getValue(['skills', 'routine_trigger', 'hash'])
            );
        }

        private function sendRequest(string $url): void {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            if (getenv('DEVELOPMENT_MODE') !== false) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            }

            $response = curl_exec($ch);
            
            curl_close ($ch);

            if ($response === false) {
                throw new Exception(
                    "Curl Request failed: " . curl_error($ch)
                );
            }
        }
        
    }
