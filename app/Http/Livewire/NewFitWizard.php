<?php

namespace App\Http\Livewire;

use App\Http\Controllers\EFT\Exceptions\MalformedEFTException;
use App\Http\Controllers\EFT\FitParser;
use App\Http\Controllers\Partners\EveWorkbench;
use App\Http\Controllers\Partners\ZKillboard;
use DOMDocument;
use DOMXPath;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class NewFitWizard extends Component
{
    const STEP_FIT = 0;
    const STEP_DESCRIPTION = 1;
    const STEP_PRIVACY = 2;


    /** @var int */
    public $step;

    /** @var ?string */
    public $fitName;

    /** @var string */
    public $eft; // EFT string

    /** @var string */
    public $wizardTitle;

    /** @var string */
    public $description;

    /** @var string */
    public $youtubeLink;

    /** @var Collection */
    public $stepsReady;

    /** @var string */
    public $privacy;

    /** @var int */
    public $Electrical;

    /** @var int */
    public $Dark;

    /** @var int */
    public $Exotic;

    /** @var int */
    public $Firestorm;

    /** @var int */
    public $Gamma;


    /** @var int */
    public $oldFitId;

    /** @var string */
    public $oldFitName;

    public function mount() {
        $this->step = 0;
        $this->fitName = null;
        $this->description = null;
        $this->wizardTitle = "New fit";
        $this->stepsReady = collect([]);
        $this->privacy = 'public';

        if ($this->oldFitId != null) {
            $this->wizardTitle = "Updating fit: ".$this->oldFitName;
            $fit = DB::table("fits")->where("ID", $this->oldFitId)->first();
            $this->fitName = $this->oldFitName;
            $this->description = $fit->DESCRIPTION;

            $this->youtubeLink = $fit->VIDEO_LINK;
            $this->privacy = $fit->PRIVACY;
            $this->eft = $fit->RAW_EFT;
            $this->updatingEft($fit->RAW_EFT);
            $fitreco = DB::table("fit_recommendations")->where('FIT_ID', $fit->ID)->first();
            $this->Electrical = $fitreco->ELECTRICAL;
            $this->Dark = $fitreco->DARK;
            $this->Exotic = $fitreco->EXOTIC;
            $this->Firestorm = $fitreco->FIRESTORM;
            $this->Gamma = $fitreco->GAMMA;
        }
    }

    public function updatingEft($value) {
        if ($value == "") {
            session()->flash('message', "Please paste your fit in EFT format.");
            session()->flash('messageType','warning');
            return;
        }

        try {
            $obj = $this->parseEft($value);
            if ($obj->isDefaultName()) {
                $this->fitName = $this->getRandomFitName();
                session()->flash('message', __("new-fit-wizard.default-name", ['shipname' => $this->fitName]));
                session()->flash('messageType','success');
            }
            else {
                $this->fitName = $obj->getFitName();
                session()->flash('message', __("new-fit-wizard.eft-verified"));
                session()->flash('messageType','success');
            }
            $this->wizardTitle = "Uploading fit: ".$this->fitName;
            if (!$this->stepsReady->has(self::STEP_FIT)) {
                $this->stepsReady->add(self::STEP_FIT);
            }

        }
        catch (MalformedEFTException $meft) {
            session()->flash('message', $meft->getMessage());
            session()->flash('messageType','danger');

            if (!$this->stepsReady->has(self::STEP_FIT)) {
                $this->stepsReady->forget(self::STEP_FIT);
            }
            $this->wizardTitle = "Invalid fit";
        }
        catch (Exception $exc) {
            session()->flash('message', $exc->getMessage());
            session()->flash('messageType','danger');
            $this->wizardTitle = "Invalid fit";
            if ($this->stepsReady->has(self::STEP_FIT)) {
                $this->stepsReady->forget(self::STEP_FIT);
            }

        }
    }

    public function goToStep(int $stepNum) {
        if ($this->stepsReady->has($this->step)) {
            $this->step = $stepNum;
            $this->dispatchBrowserEvent('step-change', ['newstep' => $stepNum]);
        }
    }

    public function progressToPrivacy(string $description, string $youtubeLink, $Electrical ,$Dark ,$Exotic ,$Firestorm ,$Gamma) {
        $this->description = $description;
        $this->youtubeLink = $youtubeLink;

        $this->Electrical = $Electrical;
        $this->Dark = $Dark;
        $this->Exotic = $Exotic;
        $this->Firestorm = $Firestorm;
        $this->Gamma = $Gamma;

        if ($Electrical == 0 && $Dark == 0 && $Exotic == 0 && $Firestorm == 0 && $Gamma == 0) {
            $this->dispatchBrowserEvent('step-change', ['newstep' => self::STEP_DESCRIPTION]);
            throw ValidationException::withMessages(['ELECTRICAL' => [__('new-fit-wizard.all-weather-0')]]);
        }

        if (!$this->stepsReady->has(self::STEP_DESCRIPTION)) {
            $this->stepsReady->add(self::STEP_DESCRIPTION);
        }

        $this->goToStep(self::STEP_PRIVACY);

    }

    /**
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function process() {
        if (!in_array($this->privacy, ['public', 'incognito', 'private'])) {
            throw ValidationException::withMessages(['privacy' => [__("new-fit-wizard.privacy-unselected")]]);
        }

        return redirect()->action('FitsController@new_store', [
            "fitName" => $this->fitName,
            "eft" => $this->eft,
            "description" => $this->description,
            "video_link" => $this->youtubeLink,
            "ELECTRICAL" => $this->Electrical,
            "DARK" => $this->Dark,
            "EXOTIC" => $this->Exotic,
            "FIRESTORM" => $this->Firestorm,
            "GAMMA" => $this->Gamma,
            "privacy" => $this->privacy,
            "rootId" => $this->oldFitId
        ]);
    }

    public function parseEft($value) {
        /** @var FitParser $fitParser */
        $fitParser = resolve('App\Http\Controllers\EFT\FitParser');
        $fitObj = $fitParser->getFitTypes($value);
        if (!$fitObj->canGoToAbyss()) {
            throw new MalformedEFTException(__("new-fit-wizard.not-abyss-capable", ['shipname' => $fitObj->getShipName()]));
        }
        return $fitObj;
    }

    public function importFromZkill(string $zkillLink) {
        $zkillLink = trim($zkillLink);
        Validator::make(['link' => $zkillLink], [
            'link' => 'required|regex:'.config('tracker.verification.zkillboard', '/https?:\/\/zkillboard\.com\/kill\/\d+\/?$/m')
        ], [
            'required' => "Please fill :attribute before saving your fit",
            'regex' => "Please enter a valid zKilboard link",
        ])->validate();
        try {
            $eft = ZKillboard::getZKillboardFit($zkillLink);

            $this->eft = $eft;
            $this->updatingEft($eft);
        }
        catch (Exception $e) {
            throw ValidationException::withMessages([
                "zKillboard" => $e->getMessage()
            ]);
        }
    }

    public function importFromEveWorkbench(string $ewbLink) {
        $ewbLink = trim($ewbLink);
        Validator::make(['link' => $ewbLink], [
            'link' => 'required|regex:'.config('tracker.verification.eveworkbench', '/https?:\/\/(www.)?eveworkbench.com\/fitting\/[a-z \-]+\/[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}\/?$/m')
        ], [
            'required' => "Please fill :attribute before saving your fit",
            'regex' => "Please enter a valid EVE Workbench link",
        ])->validate();
        try {
            $eft = EveWorkbench::getEveWorkbenchFit($ewbLink);

            $this->eft = $eft;
            $this->updatingEft($eft);
        }
        catch (Exception $e) {
            throw ValidationException::withMessages([
                "eveWorkbench" => $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.new-fit-wizard');
    }

    /**
     * @return Collection|mixed
     */
    private function getRandomFitName() {
        return collect(config("shipnames.names"))->random()." Mk-".strtoupper(base_convert(DB::table("fits")->count(), 10, 32));
    }
}
