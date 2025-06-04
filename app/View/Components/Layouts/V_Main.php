<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

// Main layout component for the application.
// Handles the overall page structure, title, and breadcrumbs.
class V_Main extends Component
{
    // The title of the page.
    public string $title;
    // An array defining the breadcrumbs for the page.
    public array $breadcrumbs;

    // Create a new component instance.
    // Initializes the title and breadcrumbs.
    public function __construct($title = 'Game Application', $breadcrumbs = [])
    {
        $this->title = $title;
        $this->breadcrumbs = $breadcrumbs;
    }

    // Get the view / contents that represent the component.
    // Returns the main layout view.
    public function render()
    {
        return view('components.layouts.v-main');
    }
}
