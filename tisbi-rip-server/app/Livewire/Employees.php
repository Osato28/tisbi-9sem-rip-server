<?php

namespace App\Livewire;

use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Employees extends Component
{
    public $employees;
    public $edited = [];
    public string $mode;

    public function mount() {
        if (Auth::user()->edit_privileges) {
            $this->mode = "edit";
        } else {
            $this->mode = "show";
        }

        $this->employees = Employee::get();
    }

    public function show($id) {
        return redirect()->to("/employees/show/{$id}");
    }

    public function edit($id) {
        return redirect()->to("/employees/edit/{$id}");
    }

    public function delete($id) {
        Employee::find($id)->delete();
        $this->employees = Employee::get();
    }

    public function editJobTitle() {
        return redirect()->to("job_titles/edit");
    }

    public function create() {
        return redirect()->to("/employees/create/0");
    }

    public function render()
    {
        return view('livewire.employees');
    }
}
