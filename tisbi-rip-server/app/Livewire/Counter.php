<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Counter extends Component
{    
    public $count = 1;
 
    public function increment()
    {
        $this->count++;
    }
 
    public function decrement()
    {
        $this->count--;
    }

    #[Layout('components.layouts.none')]
    public function render()
    {
        return view('livewire.counter');
    }
}
