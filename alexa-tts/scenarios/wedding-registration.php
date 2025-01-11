<?php
    require_once(dirname(__DIR__).'/endpoint.php');

    class WeddingRegistrationEndpoint extends Endpoint {

        protected function requiresAuthentication(): bool
        {
            return false;
        }

        protected function assembleText(): string
        {
            $stream = file_get_contents('php://input');
            $body = json_decode($stream, true);

            if ($body === null) {
                return 'Fehler! Die von Wordpress übermittelten Jobdaten konnten nicht ausgelesen werden.';
            }

            error_log(json_encode($body));

            // participation
            $firstName = $body['name_1'];
            $lastName = $body['name_2'];
            $participation = $body['select_1'] === 'true';
            $whatsAppCommunityConsent = $body['consent_2'] === 'checked';

            $output = sprintf(
                '%s %s nimmt an der Hochzeit %s teil %s.',
                $firstName,
                $lastName,
                $participation ? '' : 'nicht',
                $whatsAppCommunityConsent ? 'und möchte zur Whatsapp-Community hinzugefügt werden' : ''
            );

            return $output;
        }

        private function getNames(array $body): array
        {
            $fnKeys = preg_grep("/name_1_first_name(_\d+)?/", array_keys($body));
            return array_map(fn ($key) => $body[$key] . $body[str_replace('first', 'last', $key)], $fnKeys);
        }

        private function formatNames(array $names): string
        {
            return implode(
                ' und ',
                array_filter(
                    array_merge(
                        [
                            implode(
                                ', ',
                                array_slice($names, 0, -1)
                            )
                        ],
                        array_slice($names, -1)
                    ),
                    'strlen'
                )
            );
        }

    }

    (new WeddingRegistrationEndpoint())->execute();
