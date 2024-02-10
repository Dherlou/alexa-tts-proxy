<?php
    require_once(__DIR__.'/utility/alexa-skill-api.php');
    require_once(__DIR__.'/utility/config.php');

    abstract class Endpoint {

        private Config $config;

        public function __construct()
        {
            $this->config = new Config();           
        }

        // general

        private function authenticate(): void
        {
            $password = $_SERVER['HTTP_X_WEBHOOK_SECRET'] ?? '';
            $hash = $this->config->getValue(['webhook', 'hash']);

            if (password_verify($password, $hash) === false) {
                header('HTTP/1.1 403 Forbidden');
                exit;
            }
        }

        public function execute(): void
        {
            if ($this->requiresAuthentication()) {
                $this->authenticate();
            }

            $text = $this->assembleText();

            (new AlexaSkillApi())->sendText($text);
        }

        // specific (overwrite this in the concrete endpoints)

        protected function requiresAuthentication(): bool
        {
            return true;
        }

        protected abstract function assembleText(): string;

    }