<?php

namespace App\Livewire;

use App\Models\Bonus as ModelsBonus;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Bonus extends Component
{
    public $bonus;
    public $mode;
    public $employees;

    #[Validate('required', message: 'Введите дату')]
    public string $date;
    #[Validate('required', message: 'Введите сумму премии')]
    #[Validate('gt:0', message: 'Сумма премии не может быть меньше или равна нулю')]
    #[Validate('numeric', message: 'Буквы и знаки в сумме премии недопустимы, только цифры')]
    #[Validate('decimal:0,2', message: 'Допустимо от 0 до 2 значимых чисел после запятой')]
    public float $sum;
    public int $employeeId;

    public function mount($mode, $id, $employeeId) {
        if (!Auth::user()->edit_privileges) {
            return redirect()->to("/employees/show/{$employeeId}");
        }

        $this->employees = Employee::get();

        if ($mode == 'edit') {
            $this->bonus = ModelsBonus::find($id);
        } else if ($mode == 'create') {
            $this->bonus = ModelsBonus::make();
        }
        
        $this->mode = $mode;
        $this->date = $this->bonus->date ?? "";
        $this->sum = $this->bonus->sum ?? 0.0;
        $this->employeeId = $this->bonus->employee_id ?? $employeeId;
    }

    public function save() {
        $this->validate();
        
        $this->bonus->date = $this->date;
        $this->bonus->sum = $this->sum;
        $this->bonus->employee_id = $this->employeeId;
        $this->bonus->save();
        return redirect()->to("/employees/edit/{$this->employeeId}");
    }

    public function render()
    {
        return view('livewire.bonus');
    }
}
