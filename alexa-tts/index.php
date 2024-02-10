<?php
    require_once(__DIR__.'/endpoint.php');

    class IndexEndpoint extends Endpoint {

        protected function assembleText(): string
        {
            return $_REQUEST['text'];
        }

    }

    (new IndexEndpoint())->execute();
?>