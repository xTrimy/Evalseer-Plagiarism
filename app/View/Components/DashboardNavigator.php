<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardNavigator extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    private $page;
    public function __construct($page = null)
    {
        $this->page = $page;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard-navigator',["page"=>$this->page]);
    }
}
