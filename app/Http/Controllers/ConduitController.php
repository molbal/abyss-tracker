<?php

namespace App\Http\Controllers;

use App\Char;
use App\Fit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;


/**
 * Conduit v1 routes
 * @authenticated

 */
class ConduitController extends Controller
{

    /**
     * Ping endpoint
     *
     * Returns a single success=>true endpoint if the auth token is valid.
     * @group Misc
     * @return bool[]
     * @response {"success": true,"char": {"id": 93940047,"name": "Veetor Nara"}}
     *
     */
    public function ping(Request $request) {
        return ['success' => true,
            'char' => [
            'id' => $request->user()->CHAR_ID,
            'name' => $request->user()->NAME,
        ],];
    }


    /**
     * List fits
     *
     * Lists all fits selectable by the authenticated user: public fits, incognito fits, and users' private fits. Cached for a minute.
     *
     * @group Fits
     * @queryParam flexibleFitHash string Fit hash to match (full match, lowercase, see https://github.com/molbal/abyss-tracker/wiki/Flexible-Fit-Hash) Example: e892eac7e0c39ec6cb683211aed4f40a
     * @queryParam revisions ID If provided, only fits with historical relation to this will be displayed. Example: 76
     * @responseField success boolean true on normal operation, false on exception
     * @responseField error string|null null on normal operation, string containing error message on exception
     * @responseField char object contains the authenticated character's ID and name
     * @responseField char.id int|null authenticated character's ID  (might be null on error)
     * @responseField char.name string|null authenticated character's name (might be null on error)
     * @responseField items array contains the fits' short forms
     * @responseField items.*.id int Fit ID
     * @responseField items.*.name string Fit name
     * @responseField items.*.uploader object contains the fits' uploader and privacy selection
     * @responseField items.*.uploader.privacy string Enum field, values: 'public', 'incognito', 'private'. If incognito is set, the char id and name are set to <strong>null</strong>
     * @responseField items.*.uploader.char.id Fit uploader's ID (null,incognito privacy setting)
     * @responseField items.*.uploader.char.name Fit uploader's name (null,incognito privacy setting)
     * @responseField items.*.uploader.ship object Contains the fit hull ID, hull name, and hull size
     * @responseField items.*.uploader.ship.id int Hull ID
     * @responseField items.*.uploader.ship.name string Hull name
     * @responseField items.*.uploader.ship.size string Hull size ('frigate', 'destroyer', 'cruiser')
     * @responseField count int contains how many records were returned
     * @response {"success": true,"char": {"id": 93940047,"name": "Veetor Nara"},"items": [{"id": 157,"name": "Example","uploader": {"privacy": "public","char": {"id": 93940047,"name": "Veetor Nara"}},"ship": {"id": 629,"name": "Rupture","size": "cruiser"}}],"count": 1,"error": null}
     */
    public function fitList(Request $request) : array {
        try {

        $charId = $request->user()->CHAR_ID;
        if ($request->has('flexibleFitHash')) {
            $collection = Fit::listForApi($charId, ffh: $request->get('flexibleFitHash'));
        }
        elseif ($request->has('revisions')) {
            $collection = Fit::listForApi($charId, revision: $request->get('revisions'));
        }
        else {
            $collection = Cache::remember('api.fits.list.'.$charId, now()->addMinute(), function () use ($charId) {
                return Fit::listForApi($charId);
            });
        }

        return [
            'success' => true,
            'char' => [
                'id' => $request->user()->CHAR_ID,
                'name' => $request->user()->NAME,
            ],
            'items' => $collection,
            'count' => $collection->count(),
            'error' => null
        ];
        }
        catch (\Exception $e) {
            return [
                'success' => false,
                'char' => [
                    'id' => $request->user()->CHAR_ID ?? null,
                    'name' => $request->user()->NAME ?? null,
                ],
                'items' => null,
                'count' => null,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get a single fit
     *
     * Gets most data for a fit. Cached for a minute.
     *
     * @group Fits
     * @responseField success boolean true on normal operation, false on exception
     * @responseField error string|null null on normal operation, string containing error message on exception
     * @responseField char object contains the authenticated character's ID and name
     * @responseField char.id int|null authenticated character's ID  (might be null on error)
     * @responseField char.name string|null authenticated character's name (might be null on error)
     * @responseField item object contains the fit's extended form
     * @responseField item.id int Fit ID
     * @responseField item.name string Fit name
     * @responseField item.flexibleFitHash string Fit hash (see https://github.com/molbal/abyss-tracker/wiki/Flexible-Fit-Hash)
     * @responseField item.uploader object contains the fits' uploader and privacy selection
     * @responseField item.uploader.privacy string Enum field, values: 'public', 'incognito', 'private'. If incognito is set, the char id and name are set to <strong>null</strong>
     * @responseField item.uploader.char.id Fit uploader's ID (null,incognito privacy setting)
     * @responseField item.uploader.char.name Fit uploader's name (null,incognito privacy setting)
     * @responseField item.uploader.ship object Contains the fit hull ID, hull name, and hull size
     * @responseField item.uploader.ship.id int Hull ID
     * @responseField item.uploader.ship.name string Hull name
     * @responseField item.uploader.ship.size string Hull size ('frigate', 'destroyer', 'cruiser')
     * @responseField item.eft string The raw EFT uploaded by the creator
     * @responseField item.tags array Contains applicable tags (Automatically generated)
     * @responseField item.stats array Stat's array, please see <a href='https://github.com/molbal/svcfitstat/'>SVCFITSTAT</a> for schema
     * @responseField item.status string How well is the fit tested? Enum: 'untested', 'works', 'deprecated'
     * @responseField item.price int estimated ISK value of the fit
     * @responseField count int contains how many records were returned
     * @response {"success":true,"char":{"id":93940047,"name":"Veetor Nara"},"item":{"id":76,"name":"Easy passive Gila","uploader":{"privacy":"public","char":{"id":93940047,"name":"Veetor Nara"}},"ship":{"id":17715,"name":"Gila","size":"cruiser"},"eft":"[Gila, Easy passive Gila]\r\n\r\nDrone Damage Amplifier II\r\nDrone Damage Amplifier II\r\nDrone Damage Amplifier II\r\n\r\nCaldari Navy Large Shield Extender\r\nCaldari Navy Large Shield Extender\r\nCaldari Navy Large Shield Extender\r\nAdaptive Invulnerability Shield Hardener II\r\nAdaptive Invulnerability Shield Hardener II\r\nFederation Navy 10MN Afterburner\r\n\r\nRapid Light Missile Launcher II, Caldari Navy Nova Light Missile\r\nRapid Light Missile Launcher II, Caldari Navy Nova Light Missile\r\nRapid Light Missile Launcher II, Caldari Navy Nova Light Missile\r\nRapid Light Missile Launcher II, Caldari Navy Nova Light Missile\r\nMedium Ghoul Compact Energy Nosferatu\r\n\r\nMedium Core Defense Field Purger II\r\nMedium Core Defense Field Purger II\r\nMedium Core Defense Field Purger II\r\n\r\n\r\nRepublic Fleet Valkyrie x2\r\nRepublic Fleet Valkyrie x2\r\nValkyrie II x2\r\nValkyrie II x2\r\nValkyrie II x2","flexibleFitHash":"e892eac7e0c39ec6cb683211aed4f40a","tags":["Afterburner","Strong drones","Missiles","Shield regen tank"],"stats":{"offense":{"totalDps":"566.9","weaponDps":"121.62","droneDps":"445.28","totalVolley":"2303.62"},"defense":{"ehp":{"total":"51801.874919544","shield":"43082.278457411","armor":"4074.0740740741","hull":"4645.5223880597"},"resists":{"shield":{"em":"0.5418","therm":"0.6334","kin":"0.7251","exp":"0.7709"},"armor":{"em":"0.5","therm":"0.45","kin":"0.25","exp":"0.1"},"hull":{"em":"0.33","therm":"0.33","kin":"0.33","exp":"0.33"}},"reps":{"burst":{"shieldRegen":"272.32","shieldBoost":"0","armor":"0","hull":"0","total":"272.32"},"sustained":{"shieldRegen":"272.32","shieldBoost":"0","armor":"0","hull":"0","total":"272.32"}}},"misc":{"ship":{"id":"17715","name":"Gila","cpuMax":"475","powerMax":"837.5","cpuUsed":"448","pgUsed":"829.7","calibrationUsed":"225","warpSpeed":"4"},"drones":{"activeDrones":"2","droneBayTotal":"100","droneBandwidthUsed":"20","droneBayUsed":"20"},"maxSpeed":"697.65","signature":"247.91","capacitor":{"capacity":"1750","stable":"1","stableAt":"90.48"},"targeting":{"range":"72500","resolution":"356.25","strength":"26.4"}}},"status":"works","price":462898985},"error":null}
     */
    public function fitGet(Request $request, int $id) : array {
        try {

            $charId = $request->user()->CHAR_ID;
            $fit = Cache::remember('api.fits.char'.$charId.'.'.$id, now()->addSecond(), function () use ($charId, $id) {
                return Fit::getForApi($charId, $id);
            });

            return [
                'success' => true,
                'char' => [
                    'id' => $request->user()->CHAR_ID,
                    'name' => $request->user()->NAME,
                ],
                'item' => $fit,
                'error' => null
            ];
        }
        catch (\Exception $e) {
            return [
                'success' => false,
                'char' => [
                    'id' => $request->user()->CHAR_ID ?? null,
                    'name' => $request->user()->NAME ?? null,
                ],
                'item' => null,
                'count' => null,
                'error' => $e->getMessage()
            ];
        }

    }
}
