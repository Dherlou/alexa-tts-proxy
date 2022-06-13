<?php
    define('__ROOT__', dirname(dirname(__FILE__)));
    require_once(__ROOT__.'/config.php');
    require_once(__ROOT__.'/alexa-skill-api.php');

    function getOutputJob(string $jobType): string {
        switch ($jobType) {
            case 'build':
                return 'Der Bauvorgang';
            default:
                return 'Die Veröffentlichung';
        }
    }
    function getOutputResult(string $jobResult): string {
        switch ($jobResult) {
            case 'success':
                return 'erfolgreich abgeschlossen';
            default:
                return 'fehlgeschlagen';
        }
    }

    $stream = file_get_contents('php://input');
    $body = json_decode($stream, true);

    $project = $body['project'];
    $job = getOutputJob($body['job']);
    $result = getOutputResult($body['result']);

    $text = "$project: $job ist $result.";

    AlexaSkillApi::sendText($text);
?>