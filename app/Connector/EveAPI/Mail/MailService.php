<?php
    namespace App\Connector\EveAPI\Mail;

    use App\Connector\EveAPI\EveAPICore;

    class MailService extends EveAPICore {




        /**
         * Sends an EVE-mail
         *
         * @param int    $charId Sender char ID
         * @param int    $target Target char ID
         * @param string $title  Mail title
         * @param string $body   Mail body
         * @return int Mail ID on success
         * @throws \Exception Error text if cant send mail
         */
        public function sendMaiItoCharacter(int $charId, int $target, string $title, string $body): int {
            $params = [
                "approved_cost" => 0,
                "body" => $body,
                "recipients" => [
                    [
                        "recipient_id" => $target,
                        "recipient_type" => "character"
                    ]
                ],
                "subject" => $title];
            $id = $this->simplePost($charId, "characters/$charId/mail/", json_encode($params), false);

            if ($this->isJson($id) && isset(json_decode($id)->error)) {
                throw new \Exception("Unable to send email: " . $id->error);
            } else {
                return $id;
            }
        }
    }
