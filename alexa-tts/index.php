<?php
    define('__ROOT__', dirname(__FILE__));
    require_once(__ROOT__.'/config.php');
    require_once(__ROOT__.'/alexa-skill-api.php');

    $text = $_POST['text'];
    
    AlexaSkillApi::sendText($text);
?>