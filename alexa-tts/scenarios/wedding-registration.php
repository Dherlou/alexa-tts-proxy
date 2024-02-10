<?php
    require_once(dirname(__DIR__).'/endpoint.php');

    class WeddingRegistrationEndpoint extends Endpoint {

        protected function requiresAuthentication(): bool
        {
            return false;
        }

        protected function assembleText(): string
        {
            file_put_contents('debug.log', json_encode($_SERVER) . "\r\n" . json_encode($_REQUEST) . "\r\n----\r\n", FILE_APPEND);
            return 'test';
        }

    }

    (new WeddingRegistrationEndpoint())->execute();
