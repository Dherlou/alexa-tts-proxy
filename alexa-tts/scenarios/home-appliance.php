<?php
    define('__ROOT__', dirname(dirname(__FILE__)));
    require_once(__ROOT__.'/config.php');
    require_once(__ROOT__.'/alexa-skill-api.php');

    function getOutputAppliance(string $jobAppliance): string {
        switch ($jobAppliance) {
            case 'dishwasher':
                return 'der Geschirrspülgang';
            case 'hob':
                return 'der Kochvorgang';
            default:
                return 'unbekanntes Gerät';
        }
    }
    function getOutputStatus(string $jobStatus): string {
        switch ($jobStatus) {
            case 'started':
                return 'gestartet';
            case 'done':
                return 'fertig';
            default:
                return 'in einem unbekannten Zustand';
        }
    }

    $appliance = getOutputAppliance($_POST['appliance']);
    $status = getOutputStatus($_POST['status']);

    $text = "Haushalt: $appliance ist $status.";

    AlexaSkillApi::sendText($text);
?>