<?php
    require_once(dirname(__DIR__).'/endpoint.php');

    class JenkinsEndpoint extends Endpoint {

        protected function assembleText(): string
        {
            $stream = file_get_contents('php://input');
            $body = json_decode($stream, true);

            if ($body === null) {
                return 'Fehler! Die von Jenkins übermittelten Jobdaten konnten nicht ausgelesen werden.';
            }

            $project = $body['project'];
            $job = $this->getOutputJob($body['job']);
            $result = $this->getOutputResult($body['result']);

            return "$project: $job $result.";
        }

        private function getOutputJob(string $jobType): string {
            switch ($jobType) {
                case 'build':
                    return 'Bauvorgang';
                default:
                    return 'Veröffentlichung';
            }
        }
        private function getOutputResult(string $jobResult): string {
            switch ($jobResult) {
                case 'success':
                    return 'erfolgreich';
                default:
                    return 'fehlgeschlagen';
            }
        }
        
    }

    (new JenkinsEndpoint())->execute();
