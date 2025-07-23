<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $result = Employee::get()->toArray();
        // foreach ($result as &$employee) {
        //     $employee['job_title'] = Employee::find($employee['job_title_id']);
        //     $employee['bonuses'] = Bonus::where('employee_id',$employee['id'])->get()->toArray();

        //     unset($employee);
        // }
        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isJson = $request->isJson();
        if (!$isJson) {
            return response('Запрос должен быть в формате JSON', 400);
        }

        $name = $request->input('name');
        if (!$name || $name == "") {
            return response('В запросе отсутствует параметр "name"', 400);
        }

        $salary = $request->input('salary');
        if (!$salary || floatval($salary) == 0) {
            return response('В запросе некорректно выставлен параметр "salary": зарплата нулевая или не является числом', 400);
        }

        $jobTitleId = $request->input('job_title_id');
        if (!$jobTitleId || $jobTitleId == 0) {
            return response('В запросе некорректно выставлен параметр "job_title_id": ID нулевой или не задан', 400);
        }

        if (Employee::where('name', $name)->count() != 0) {
            return response('Сущность с таким параметром "name" уже существует', 400);
        }

        try {
            $entity = new Employee();
            $entity->name = $name;
            $entity->salary = $salary;
            $entity->job_title_id = $jobTitleId;
            $entity->save();
            return response()->json($entity->toArray());
        } catch (\Throwable $e) {
            return response('Неизвестная ошибка при записи сущности', 504);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $employee = Employee::find($id)->toArray();
        return response()->json($employee);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $isJson = $request->isJson();
        if (!$isJson) {
            return response('Запрос должен быть в формате JSON', 400);
        }

        $name = $request->input('name');
        if (!$name || $name == "") {
            return response('В запросе отсутствует параметр "name"', 400);
        }

        $salary = $request->input('salary');
        if (!$salary || floatval($salary) == 0) {
            return response('В запросе некорректно выставлен параметр "salary": зарплата нулевая или не является числом', 400);
        }

        $jobTitleId = $request->input('job_title_id');
        if (!$jobTitleId || $jobTitleId == 0) {
            return response('В запросе некорректно выставлен параметр "job_title_id": ID нулевой или не задан', 400);
        }

        try {
            $entity = Employee::find($id);
            $entity->name = $name;
            $entity->salary = $salary;
            $entity->job_title_id = $jobTitleId;
            $entity->save();
        } catch (\Throwable $e) {
            return response('Неизвестная ошибка при записи сущности', 504);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Employee::destroy($id);
            return response("Сущность с номером {$id} удалена");
        } catch (\Throwable $e) {
            return response('Неизвестная ошибка при записи сущности', 504);
        }
    }
}
