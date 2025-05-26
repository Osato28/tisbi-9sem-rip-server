<?php

namespace App\Livewire;

use App\Models\Bonus;
use App\Models\Employee as ModelsEmployee;
use App\Models\JobTitle;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Employee extends Component
{
    public $employee;
    public $jobTitles;
    public $mode;

    #[Validate('required', message: 'Поле не может быть пустым')]
    public string $name;
    #[Validate('required', message: 'Поле не может быть пустым')]
    #[Validate('gt:0', message: 'Зарплата не может быть нулевой или отрицательной')]
    public float $salary;
    #[Validate('gte:0', message: 'Выберите должность')]
    public int $jobTitleId;

    public function mount($mode, $id) {
        $this->jobTitles = JobTitle::get();
        $this->mode = $mode;

        if ($mode != 'show' && !Auth::user()->edit_privileges) {
            return redirect()->to("/employees/show/{$id}");
        }

        if ($mode != 'create') {
            $this->employee = ModelsEmployee::find($id);
        } else {
            $this->employee = ModelsEmployee::make();
        }
            
        $this->name = $this->employee->name ?? "";
        $this->salary = $this->employee->salary ?? 0;
        $this->jobTitleId = $this->employee->jobTitle ? $this->employee->jobTitle->id : -1;
    }
    
    public function save() {
        $this->validate();
        
        $this->employee->name = $this->name;
        $this->employee->salary = $this->salary;
        $this->employee->job_title_id = $this->jobTitleId;
        $this->employee->save();
        return redirect()->to("/employees");
    }

    public function editBonus($id) {
        return redirect()->to("/bonuses/edit/{$id}/{$this->employee->id}");
    }

    public function deleteBonus($id) {
        Bonus::find($id)->delete();
        $this->employee = ModelsEmployee::find($this->employee->id);
    }

    public function createBonus() {
        return redirect()->to("/bonuses/create/0/{$this->employee->id}");
    }

    public function render()
    {
        return view('livewire.employee');
    }
}
