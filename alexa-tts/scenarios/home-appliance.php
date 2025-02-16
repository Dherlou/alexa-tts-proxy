<?php
    require_once(dirname(__DIR__).'/endpoint.php');

    class HomeApplianceEndpoint extends Endpoint {

        protected function assembleText(): string
        {
            $appliance = $this->getOutputAppliance($_POST['appliance']);
            $status = $this->getOutputStatus($_POST['status'] ?? 'done');
            $time = $this->getOutputTime(intval($_POST['time'] ?? 0));

            return "Haushalt: $appliance ist $time $status.";
        }

        private function getOutputAppliance(string $jobAppliance): string {
            switch ($jobAppliance) {
                case 'dishwasher':
                    return 'der Geschirrspülgang';
                case 'washing_machine':
                    return 'die Waschmaschine';
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

        private function getOutputTime(int $seconds): string {
            $mins = intval(floor($seconds / 60));
            $secs = $seconds % 60;

            $output = [];

            if ($mins > 0) {
                $output[] = sprintf(
                    '%d Minute%s',
                    $mins,
                    $mins === 1 ? '' : 'n'
                );
            }

            if ($secs > 0) {
                $output[] = sprintf(
                    '%d Sekunde%s',
                    $secs,
                    $secs === 1 ? '' : 'n'
                );
            }

            return count($output) === 0 ? '' :
                'in ' . implode(' und ', $output);
        }

    }

    (new HomeApplianceEndpoint())->execute();
?>