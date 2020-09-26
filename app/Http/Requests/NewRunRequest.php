<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewRunRequest extends FormRequest
{
    /** @var array */
    protected $vesselArray = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Request $request
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [
            'TYPE'     => 'required',
            'TIER'     => 'required',
            'SURVIVED' => 'required',
            'PUBLIC'   => 'required',
            'vessel'   => 'required',
            'RUN_DATE' => 'required|date',
            'KILLMAIL' => 'nullable|regex:/https?:\/\/zkillboard\.com\/kill\/\d+\/?/m',
            'RUN_LENGTH_M' => 'nullable|numeric|min:0|max:20',
            'RUN_LENGTH_S' => 'nullable|numeric|min:0|max:59',
        ];
        if ($request->get("SURVIVED") == "1") {
            $rules['LOOT_DETAILED'] = 'required';
        }

        return $rules;
    }

    public function attributes() {
        return [
            'TYPE'     => 'Abyss type',
            'TIER'     => 'Abyss difficulty tier',
            'SURVIVED' => 'whether you survived or not',
            'PUBLIC'   => 'whether you want your run public or anonym',
            'vessel'   => 'which ship/fit you flew',
            'RUN_DATE' => 'run date (you shouldn\'t see this)',
            'KILLMAIL' => 'killmail link',
            'RUN_LENGTH_M' => 'run length minutes',
            'RUN_LENGTH_S' => 'run length seconds',
        ];
    }

    /**
     * @return array|mixed
     */
    private function getVessel() {
        if ($this->vesselArray == null) {
            $this->vesselArray = json_decode($this->get("vessel"), true);
        }

        return $this->vesselArray;
    }


    public function getShipId() {
        return $this->getVessel()['SHIP_ID'] ?? null;
    }

    public function getFitId() {
        $fitId = ($this->getVessel()['FIT_ID'] ?? null);
        return $fitId == "" ? null : $fitId;
    }



    public function messages()
    {
        return [
            'required' => "Please fill :attribute before saving your request",
            'regex'    => "Please link a valid zKillboard link like this: https://zkillboard.com/kill/81359022/"
        ];
    }

    /**
     * @param bool $asInt
     *
     * @return bool|int
     */
    public function isBonusRoom(bool $asInt = true) {
        $isBonus = $this->get("TIER") == config("tracker.constants.bonus-room");
        return $asInt ? ($isBonus ? 1 : 0) : $isBonus;
    }
}
