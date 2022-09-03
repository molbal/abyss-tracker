<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Models\Partners\Telemetry;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class TelemetryController extends Controller
{
    public function consumePayload(Request $request) {
        $packet = $request->getContent();
        $data = json_decode($packet, true);
        $payload = json_decode(base64_decode($data['message']));

        // Query token from the data store
        $token = PersonalAccessToken::findToken($payload['AbyssTrackerToken']);

        // Check token access
        if (!$this->isAuthorized($payload, $token)) {
            abort(403, 'The issuer of the token provided in AbyssTrackerToken does not match the CharacterID of the Telemetry run.');
        }

        // Delete old run if exitst
        if ($this->runExistsForMessage($payload)) {
            // todo
        }

    }

    /**
     * Checks if the token is valid.
     * @param array               $payload
     * @param PersonalAccessToken $token
     *
     * @return bool
     */
    private function isAuthorized(array $payload, PersonalAccessToken $token) : bool {
        return $payload['CharacterID'] == $token->tokenable_id;
    }

    private function runExistsForMessage(array $payload) : bool {
        return Telemetry::where('uuid', $payload['uuid'])->exists();
    }

    private function persistTelemetry(array $payload) {
        $uuid = $payload['uuid'];
    }
}
