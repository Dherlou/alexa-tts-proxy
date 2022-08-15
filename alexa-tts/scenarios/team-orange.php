<?php
    define('__ROOT__', dirname(dirname(__FILE__)));
    require_once(__ROOT__.'/config.php');
    require_once(__ROOT__.'/alexa-skill-api.php');

    function getArticle(string $garbageType): string {
        switch ($garbageType) {
            case 'Gelbe Tonne':
                return 'die';
            case 'Papier':
                return 'das';
            default:
                return 'der';
        }
    }

    $garbageType = $_POST['type'];
    $article = getArticle($garbageType);

    $text = "Team Orange: Morgen wird $article $garbageType geleert.";

    AlexaSkillApi::sendText($text);
?>