<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class VMainLayout extends Component
{
    public $title;

    public function __construct($title = 'Game Application')
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('components.layouts.v-main-layout');
    }
}
