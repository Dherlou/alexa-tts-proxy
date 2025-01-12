<?php
    require_once(dirname(__DIR__).'/endpoint.php');

    class WeddingRegistrationEndpoint extends Endpoint {

        protected function requiresAuthentication(): bool
        {
            return false;
        }

        protected function assembleText(): string
        {
            // read request

            $stream = file_get_contents('php://input');
            $body = json_decode($stream, true);

            if ($body === null) {
                return 'Fehler! Die von Wordpress übermittelten Jobdaten konnten nicht ausgelesen werden.';
            }

            // log request for debugging

            error_log(json_encode($body));

            // participation

            $firstName = $body['name_1'];
            $lastName = $body['name_2'];
            $participation = ($body['select_1'] ?? 'false') === 'true';
            $whatsAppCommunityConsent = isset($body['consent_2']);

            $output = sprintf(
                '%s %s nimmt an der Hochzeit %s teil %s. ',
                $firstName,
                $lastName,
                $participation ? '' : 'nicht',
                $whatsAppCommunityConsent ? 'und möchte zur Whatsapp-Community hinzugefügt werden' : ''
            );

            // media usage

            $mediaUsageCreation = isset($body['consent_5']);
            $output .= sprintf(
                'Anfertigung von Medienaufnahmen: %s einverstanden. ',
                $mediaUsageCreation ? '' : 'nicht'
            );

            $mediaUsagePublication = isset($body['consent_6']);
            $output .= sprintf(
                'Veröffentlichung von Medienaufnahmen: %s einverstanden. ',
                $mediaUsagePublication ? '' : 'nicht'
            );

            // eating organization

            $eatingHabits = $this->formatList(explode(', ', $body['checkbox_1']));
            $output .= sprintf('Essgewohnheiten: %s. ', $eatingHabits);
            
            $cakeDonation = trim($body['text_1'] ?? '');
            if (!empty($cakeDonation)) {
                $output .= sprintf('Kuchenspende: %s. ', $cakeDonation);
            }

            // practical help

            $instrument = trim($body['text_2'] ?? '');
            if (!empty($instrument)) {
                $output .= sprintf('Instrumentalbegleitung: %s. ', $instrument);
            }

            $vocals = isset($body['consent_3']);
            if ($vocals) {
                $output .= 'Gesangsbegleitung. ';
            }

            $logistics = isset($body['consent_4']);
            if ($logistics) {
                $output .= 'Logistische Unterstützung. ';
            }

            // misc

            $notice = trim($body['textarea_1'] ?? '');
            if (!empty($notice)) {
                $output .= sprintf('Hinweis: %s.', $notice);
            }

            return $output;
        }

        /**
         * Returns a natural language joined sentence of the list items in German language.
         */
        private function formatList(array $items): string
        {
            return implode(
                ' und ',
                array_filter(
                    array_merge(
                        [
                            implode(
                                ', ',
                                array_slice($items, 0, -1)
                            )
                        ],
                        array_slice($items, -1)
                    ),
                    'strlen'
                )
            );
        }

    }

    (new WeddingRegistrationEndpoint())->execute();
