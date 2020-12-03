<?php

namespace App\View\Components;

use Illuminate\View\Component;

class icon extends Component
{
    public $iconset;
    public $icon;
    public $class;

    /**
     * icon constructor.
     *
     * @param $iconset
     * @param $icon
     * @param $class
     */
    public function __construct($icon = "",$iconset = "", $class = "bringupper4 tinyicon mt-1") {
        $this->iconset = $iconset;
        $this->icon = $icon;
        $this->class = $class;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.icon');
    }
}
