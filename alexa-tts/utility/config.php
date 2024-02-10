<?php

    class Config {

        private array $config = [];

        public function __construct()
        {
            $secrets_directory = getenv("ALEXA_TTS_SECRETS") ? getenv("ALEXA_TTS_SECRETS") : "/var/data/secrets/alexa-tts";
            $secrets_file = $secrets_directory . "/secrets.json";
            $parsedConfig = json_decode(file_get_contents($secrets_file), true);

            if ($parsedConfig === null) {
                throw new Exception("Could not load or parse the config file.");
            }

            $this->config = $parsedConfig;
        }

        public function getValue(array $keys): string
        {
            $value = $this->config;

            foreach ($keys as $key) {
                $value = $value[$key] ?? null;
            }

            if ($value === null) {
                throw new Exception("The config file is missing the following property: " . implode('->', $keys));
            }

            return $value;
        }

    }
