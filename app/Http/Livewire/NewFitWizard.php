<?php

namespace App\Http\Livewire;

use App\Http\Controllers\EFT\Exceptions\MalformedEFTException;
use App\Http\Controllers\EFT\FitParser;
use Illuminate\Support\Collection;
use Livewire\Component;

class NewFitWizard extends Component
{
    /** @var int */
    public $step;

    /** @var ?string */
    public $fitName;

    /** @var string */
    public $eft; // EFT string

    /** @var string */
    public $wizardTitle;


    /** @var Collection */
    public $stepsReady;

    public function mount() {
        $this->step = 0;
        $this->fitName = null;
        $this->wizardTitle = "New fit";
        $this->stepsReady = collect([]);
    }

    public function updatingEft($value) {
        try {
            $obj = $this->parseEft($value);
            if ($obj->isDefaultName()) {
                $this->fitName = collect(config("shipnames.names"))->random();
                session()->flash('message', __("new-fit-wizard.default-name", ['shipname' => $this->fitName]));
                session()->flash('messageType','success');
            }
            else {
                session()->flash('message', __("new-fit-wizard.eft-verified"));
                session()->flash('messageType','success');
            }
            $this->wizardTitle = "Uploading fit: ".$this->fitName;
            if (!$this->stepsReady->has(0)) {
                $this->stepsReady->add(0);
            }

        }
        catch (MalformedEFTException $meft) {
            session()->flash('message', $meft->getMessage());
            session()->flash('messageType','danger');

            if (!$this->stepsReady->has(0)) {
                $this->stepsReady->forget(0);
            }
            $this->wizardTitle = "Invalid fit";
        }
        catch (\Exception $exc) {
            session()->flash('message', $exc->getMessage());
            session()->flash('messageType','danger');
            $this->wizardTitle = "Invalid fit";
            if (!$this->stepsReady->has(0)) {
                $this->stepsReady->forget(0);
            }

        }
    }

    public function goToStep(int $stepNum) {
//        dd($this->stepsReady, $stepNum);
        if ($this->stepsReady->has($this->step)) {
            $this->step = $stepNum;
            $this->message = null;
        }
    }

    public function parseEft($value) {
        /** @var FitParser $fitParser */
        $fitParser = resolve('App\Http\Controllers\EFT\FitParser');
        $fitObj = $fitParser->getFitTypes($value);
        if (!$fitObj->canGoToAbyss()) {
            throw new MalformedEFTException("This ship (".$fitObj->getShipName().") cannot fly in Abyssal Deadspace!");
        }
        return $fitObj;
    }

    public function render()
    {
        return view('livewire.new-fit-wizard');
    }
}
