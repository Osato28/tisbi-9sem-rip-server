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
     * Show the form for creating a new resource.
     */
    public function create()
    {
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

        if (JobTitle::where('name', $name)->count() != 0) {
            return response('Сущность с таким параметром "name" уже существует', 409);
        }

        try {
            $entity = new JobTitle();
            $entity->name = $name;
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
        if (!$name || $name == "") {
            return response('В запросе отсутствует параметр "name"', 400);
        }

        try {
            $entity = JobTitle::find($id);
            if ($entity->name != $name) {
                $entity->name = $name;
                $entity->save();
            }
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
            JobTitle::destroy($id);
            return response("Должность с номером {$id} удалена");
        } catch (\Throwable $e) {
            return response('Неизвестная ошибка при записи сущности', 504);
        }
    }
}
