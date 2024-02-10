<?php
    require_once(dirname(__DIR__).'/endpoint.php');

    class TeamOrangeEndpoint extends Endpoint {

        protected function assembleText(): string
        {
            $garbageType = $_POST['type'];
            $article = $this->getArticle($garbageType);

            return "Team Orange: Morgen wird $article $garbageType geleert.";
        }

        private function getArticle(string $garbageType): string {
            switch ($garbageType) {
                case 'Gelbe Tonne':
                    return 'die';
                case 'Papier':
                    return 'das';
                default:
                    return 'der';
            }
        }

    }

    (new TeamOrangeEndpoint())->execute();
