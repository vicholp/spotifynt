<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SchemaOrg extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(private array $schema)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        $output = '';

        foreach ($this->schema as $schema) {
            $output += $schema->toScript();
        }

        // @phpstan-ignore-next-line
        return $output;
    }
}
