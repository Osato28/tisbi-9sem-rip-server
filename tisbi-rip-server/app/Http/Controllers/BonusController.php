<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(Bonus::get()->toArray());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

        $sum = $request->input('sum');
        if (!$sum || floatval($sum) == 0) {
            return response('В запросе некорректно выставлен параметр "sum": размер премии нулевой или не является числом', 400);
        }

        $date = $request->input('date');
        if (!$date || $date == "") {
            return response('В запросе отсутствует параметр "date"', 400);
        }
        if (\DateTime::createFromFormat('Y-m-d', $date) == false) {
            return response('Параметр "date" должен соответствовать формату yyyy-MM-dd', 400);
        }

        $employeeId = $request->input('employee_id');
        if (!$employeeId || $employeeId == 0) {
            return response('В запросе некорректно выставлен параметр "employee_id": ID нулевой или не задан', 400);
        }
        
        try {
            $entity = new Bonus();
            $entity->sum = $sum;
            $entity->date = $date;
            $entity->employee_id = $employeeId;
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
        $entity = Bonus::find($id);
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

        $sum = $request->input('sum');
        if (!$sum || floatval($sum) == 0) {
            return response('В запросе некорректно выставлен параметр "sum": размер премии нулевой или не является числом', 400);
        }

        $date = $request->input('date');
        if (!$date || $date == "") {
            return response('В запросе отсутствует параметр "date"', 400);
        }
        if (\DateTime::createFromFormat('Y-m-d', $date) == false) {
            return response('Параметр "date" должен соответствовать формату yyyy-MM-dd', 400);
        }

        $employeeId = $request->input('employee_id');
        if (!$employeeId || $employeeId == 0) {
            return response('В запросе некорректно выставлен параметр "employee_id": ID нулевой или не задан', 400);
        }

        $entity = Bonus::find($id);
        if ($entity == null) {
            return response("Сущность с ID {$id} не найдена", 400);
        }

        try {
            $entity->sum = $sum;
            $entity->date = $date;
            $entity->employee_id = $employeeId;
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
        $entity = Bonus::find($id);
        if ($entity == null) {
            return response("Сущность с ID {$id} не найдена", 400);
        }

        try {
            $entity->delete();
            return response("Должность с номером {$id} удалена");
        } catch (\Throwable $e) {
            return response('Неизвестная ошибка при записи сущности', 504);
        }
    }
}
