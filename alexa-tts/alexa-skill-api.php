<?php

class AlexaSkillApi {
    public static function sendText(string $text): void {
        if (empty($text) === true) {
            return;
        }
        
        $encodedText = urlencode($text);
        self::saveText($encodedText);
        self::triggerRead();
    }

    private static function saveText(string $text): void {
        self::sendRequest(
            "https://esp8266-server.de/alexa/TextVorlesen/get/"
            . "?id=" . SKILL_TEXT_VORLESEN_ID
            . "&hash=" . SKILL_TEXT_VORLESEN_HASH
            . "&SendeText=" . $text
        );
    }

    private static function triggerRead(): void {
        self::sendRequest(
            "https://trigger.esp8266-server.de/api/"
            . "?id=" . SKILL_ROUTINE_TRIGGER_ID
            . "&hash=" . SKILL_ROUTINE_TRIGGER_HASH
        );
    }

    private static function sendRequest(string $url): void {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        
        curl_close ($ch);

        if ($response === false) {
            throw new Exception(
                "Curl Request failed: " . curl_error($ch)
            );
        }
    }
}

?>