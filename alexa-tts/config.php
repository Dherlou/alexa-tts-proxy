<?php
	$secrets_directory = getenv("ALEXA_TTS_SECRETS") ? getenv("ALEXA_TTS_SECRETS") : "/var/data/secrets/alexa-tts";
    $config = json_decode(file_get_contents($secrets_directory."/secrets.json"), true);

    define("SKILL_ROUTINE_TRIGGER_ID", $config["skills"]["routine_trigger"]["id"]);
    define("SKILL_ROUTINE_TRIGGER_HASH", $config["skills"]["routine_trigger"]["hash"]);
    define("SKILL_TEXT_VORLESEN_ID", $config["skills"]["text_vorlesen"]["id"]);
    define("SKILL_TEXT_VORLESEN_HASH", $config["skills"]["text_vorlesen"]["hash"]);
    define("WEBHOOK_HASH", $config["webhook"]["hash"]);

    // check credentials
    $secret = $_SERVER['HTTP_X_WEBHOOK_SECRET'] ?? null;
    if (password_verify($secret, WEBHOOK_HASH) === false) {
        header('HTTP/1.1 403 Forbidden');
        exit;
    }
?>