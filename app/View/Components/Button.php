<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
		public string $link = '#',
		public string $target = '',
		public string $label = 'Click me',
        public string $type = 'solid', // solid, outline
        public string $size = 'md', // solid, outline
        public string $border = '', // any border classname
        public string $bg = '', // any bg classname
        public string $text = '', // any text classname
        public string $iconPos = 'start',
	)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
