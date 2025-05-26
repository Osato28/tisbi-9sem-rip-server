<?php

namespace App\Livewire;

use App\Models\JobTitle as ModelsJobTitle;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class JobTitle extends Component
{
    public $jobTitles;
    public $jobTitleId;
    #[Validate('required', 'Поле не может быть пустым')]
    public string $name;
    public function mount() {
        if (!Auth::user()->edit_privileges) {
            return redirect()->to("/employees");
        }

        $this->jobTitles = ModelsJobTitle::get();
    }
    public function save() {
        $this->validate();
        
        if ($this->jobTitleId == -1) {
            // create new job title
            $jobTitle = ModelsJobTitle::create([
                'name' => $this->name
            ]);
        } else {
            $jobTitle = ModelsJobTitle::find($this->jobTitleId);
            $jobTitle->name = $this->name;
            $jobTitle->save();
        }
        return redirect()->to('/employees');
    }
    public function delete() 
    {
        if ($this->jobTitleId != -1) {
            $jobTitle = ModelsJobTitle::find($this->jobTitleId);
            $jobTitle->delete();
        }
        return redirect()->to('/employees');
    }

    public function render()
    {
        return view('livewire.job-title');
    }
}
