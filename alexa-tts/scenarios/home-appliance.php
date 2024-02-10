<?php
    require_once(dirname(__DIR__).'/endpoint.php');

    class HomeApplianceEndpoint extends Endpoint {

        protected function assembleText(): string
        {
            $appliance = $this->getOutputAppliance($_POST['appliance']);
            $status = $this->getOutputStatus($_POST['status']);

            return "Haushalt: $appliance ist $status.";
        }

        private function getOutputAppliance(string $jobAppliance): string {
            switch ($jobAppliance) {
                case 'dishwasher':
                    return 'der Geschirrspülgang';
                case 'hob':
                    return 'der Kochvorgang';
                default:
                    return 'unbekanntes Gerät';
            }
        }

        private function getOutputStatus(string $jobStatus): string {
            switch ($jobStatus) {
                case 'started':
                    return 'gestartet';
                case 'done':
                    return 'fertig';
                default:
                    return 'in einem unbekannten Zustand';
            }
        }

    }

    (new HomeApplianceEndpoint())->execute();
?>