<?php

namespace App\Http\Controllers\Partners;

use App\Events\RunSaved;
use App\Http\Controllers\Controller;
use App\Models\Models\Partners\Telemetry;
use App\Runs\CreateRunHelper;
use App\Runs\DeleteHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

class TelemetryController extends Controller
{
    public function consumePayload(Request $request) {
        $packet = $request->getContent();
        $data = json_decode($packet, true)['message'];
//        dd($data);
        $payload = json_decode(base64_decode($data['data']), true);

        // Query token from the data store
        $token = PersonalAccessToken::findToken($payload['AbyssTrackerToken']);

        // Check token access
        if (!$this->isAuthorized($payload, $token)) {
            return $this->failPayload('The issuer of the token provided in AbyssTrackerToken does not match the CharacterID of the Telemetry run. Telemetry recordUUID: ['.$payload['recordUUID'].']');
        }

        // Delete old run if exits
        if ($run_id = $this->getRunForTelemetry($payload)) {
            if (!DeleteHelper::canDeleteRun($run_id, $token)) {
                return $this->failPayload('There is already a run with this Telemetry recordUUID: ['.$payload['recordUUID'].'], but that belongs to a different Tracker character.');
            }
            try {
                DeleteHelper::deleteRun($run_id);
            }
            catch (Throwable $e) {
                return $this->failPayload(sprintf("Could not delete previous run with this Telemetry recordUUID: [%s]: %s", $payload['recordUUID'], $e->getMessage()));
            }
        }
        Telemetry::where('uuid',  $payload['recordUUID'])->delete();

        // Persist new run
        $new_run_id = CreateRunHelper::storeFromTelemetry($payload);

        // Persist new telemetry
        Telemetry::make($payload, $new_run_id);

        logger()->channel('telemetry')->info(sprintf("Successfully imported Telemetry run: %s and linked it to Tracker run #%d", $payload['recordUUID'], $new_run_id));

        if ( config('broadcasting.connections.pusher.is_enabled') == true ) {
            broadcast(RunSaved::createEventForUser($token->tokenable_id));
        }
        return response()->noContent();

    }


    private function failPayload($message) : Response {
        logger()->channel('telemetry')->error($message);
        return $this::createResponseToGCP();
    }

    /**
     * @return Response
     */
    private static function createResponseToGCP() : Response {
        return response()->noContent();
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

    private function getRunForTelemetry(array $payload) : ?int {
        return Telemetry::where('uuid', $payload['recordUUID'])->first('run_id')->run_id ?? null;
    }
}
