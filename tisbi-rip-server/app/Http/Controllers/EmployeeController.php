<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\Employee;
use App\Models\JobTitle;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Employee::get()->toArray());
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
        if (!$jobTitleId || JobTitle::find($jobTitleId) == null) {
            return response('В запросе некорректно выставлен параметр "job_title_id": ID не соответствует должности или не задан', 400);
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
        $entity = Employee::find($id);
        if ($entity == null) {
            return response("Сущности с ID {$id} в базе данных нет.", 400);
        }
        return response()->json($entity);
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
        if (!$jobTitleId || JobTitle::find($jobTitleId) == null) {
            return response('В запросе некорректно выставлен параметр "job_title_id": ID не соответствует должности или не задан', 400);
        }

        $entity = Employee::find($id);
        if ($entity == null) {
            return response("Сущность с ID {$id} не найдена", 400);
        }

        try {
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
        $entity = Employee::find($id);
        if ($entity == null) {
            return response("Сущность с ID {$id} не найдена", 400);
        }

        try {
            $entity->delete();
            return response("Сущность с номером {$id} удалена");
        } catch (\Throwable $e) {
            return response('Неизвестная ошибка при записи сущности', 504);
        }
    }
}
