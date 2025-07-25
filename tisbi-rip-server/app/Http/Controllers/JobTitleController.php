<?php

namespace App\Http\Controllers;

use App\Models\JobTitle;
use Illuminate\Http\Request;

class JobTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(JobTitle::get()->toArray());
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
        if (!$name || !is_string($name) || $name == "") {
            return response('В запросе отсутствует или не является строкой параметр "name"', 400);
        }

        $insurancePayout = $request->input('insurance_payout');
        if (!$insurancePayout || !doubleval($insurancePayout) || $insurancePayout == 0) {
            return response('В запросе отсутствует или не является числом с плавающей точкой параметр "insurance_payout"', 400);
        }

        if (JobTitle::where('name', $name)->count() != 0) {
            return response('Сущность с таким параметром "name" уже существует', 400);
        }

        try {
            $entity = new JobTitle();
            $entity->name = $name;
            $entity->insurance_payout = $insurancePayout;
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
        return response()->json(JobTitle::find($id)->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $isJson = $request->isJson();
        if (!$isJson) {
            return response('Запрос должен быть в формате JSON', 400);
        }

        $name = $request->input('name');
        if (!$name || !is_string($name) || $name == "") {
            return response('В запросе отсутствует параметр "name"', 400);
        }

        $insurancePayout = $request->input('insurance_payout');
        if (!$insurancePayout || !doubleval($insurancePayout) || $insurancePayout == 0) {
            return response('В запросе отсутствует или не является числом с плавающей точкой параметр "insurance_payout"', 400);
        }

        $entity = JobTitle::find($id);
        if ($entity == null) {
            return response("Сущность с ID {$id} не найдена", 400);
        }

        try {
            $entity->name = $name;
            $entity->insurance_payout = $insurancePayout;
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
        $entity = JobTitle::find($id);
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
