<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Counter extends Component
{    
    public $count = 1;
 
    public function mount() {
        if (!Auth::user()->edit_privileges) {
            return redirect()->to("/employees");
        }
    }
    public function increment()
    {
        $this->count++;
    }
 
    public function decrement()
    {
        $this->count--;
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
