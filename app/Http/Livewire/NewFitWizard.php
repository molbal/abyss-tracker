<?php

namespace App\Http\Livewire;

use App\Http\Controllers\EFT\Exceptions\MalformedEFTException;
use App\Http\Controllers\EFT\FitParser;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    public function mount() {
        $this->step = 0;
        $this->fitName = null;
        $this->description = null;
        $this->wizardTitle = "New fit";
        $this->stepsReady = collect([]);
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
        catch (\Exception $exc) {
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

    public function progressToPrivacy(string $description, string $youtubeLink) {
//        dd($description, $youtubeLink);
        $this->description = $description;
        $this->youtubeLink = $youtubeLink;

        if (!$this->stepsReady->has(self::STEP_DESCRIPTION)) {
            $this->stepsReady->add(self::STEP_DESCRIPTION);
        }

        $this->goToStep(self::STEP_PRIVACY);

    }
    public function parseEft($value) {
        /** @var FitParser $fitParser */
        $fitParser = resolve('App\Http\Controllers\EFT\FitParser');
        $fitObj = $fitParser->getFitTypes($value);
        if (!$fitObj->canGoToAbyss()) {
            throw new MalformedEFTException("The ".$fitObj->getShipName()." cannot fly in Abyssal Deadspace - the Abyss Tracker only accepts Abyssal Deadspace capable ships. For a general fit service check out our friends at <a href='https://eveworkbench.com/' target='_blank' rel='nofollow'>EVE Workbench</a>.");
        }
        return $fitObj;
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
