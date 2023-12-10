<?php

namespace App\View\Components\Gtm;

use Illuminate\View\Component;

class NoScript extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $container = config('tag_manager.container');

        if (!$container) {
            return '';
        }

        return '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id='.$container.'"height="0"width="0"style="display:none;visibility:hidden"></iframe></noscript>';
    }
}
