<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class VMainLayout extends Component
{
    public string $title;
    public array $breadcrumbs; // Added breadcrumbs property

    public function __construct($title = 'Game Application', $breadcrumbs = [])
    {
        $this->title = $title;
        $this->breadcrumbs = $breadcrumbs;
    }

    public function render()
    {
        return view('components.layouts.v-main-layout');
    }
}
