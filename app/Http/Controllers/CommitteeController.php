<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Minutes;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    public function index()
    {
        $committees = Committee::with('minutes')->get();
        return view('admin.committee.index', compact('committees'));
    }

    public function create()
{
    // Obtenemos todas las actas (minutes) ordenadas por fecha descendente
    // Solo actas que no tengan comité asociado para evitar duplicados
    $minutes = Minutes::whereDoesntHave('committees')
                     ->orderBy('minutes_date', 'desc')
                     ->orderBy('act_number', 'desc')
                     ->get();

    // Retornamos la vista con la variable
    return view('admin.committee.create', compact('minutes'));
}


    public function store(Request $request)
{
    $request->validate([
        'minutes_id' => 'required|exists:Minutes,minutes_id',
        'session_date' => 'required|date',
        'session_time' => 'required',
        'minutes_date' => 'required|date',
        'attendance_mode' => 'required|in:Presencial,Virtual,No asistió',
        'offense_class' => 'required|in:Leve,Grave,Muy Grave',
        'fault_type' => 'required|string',
        'statement' => 'required|string',
        'decision' => 'required|string',
        'commitments' => 'nullable|string',
        'access_link' => 'nullable|url',
        'offense_classification' => 'nullable|string',
        'missing_rating' => 'nullable|string',
        'recommendations' => 'nullable|string',
        'observations' => 'nullable|string',
    ]);

    $minute = Minutes::findOrFail($request->minutes_id);

    Committee::create([
        'minutes_id' => $minute->minutes_id,
        'act_number' => $minute->act_number,
        'session_date' => $request->session_date,
        'session_time' => $request->session_time,
        'minutes_date' => $request->minutes_date,
        'trainee_name' => $minute->trainee_name,
        'attendance_mode' => $request->attendance_mode,
        'offense_class' => $request->offense_class,
        'fault_type' => $request->fault_type,
        'statement' => $request->statement,
        'decision' => $request->decision,
        'commitments' => $request->commitments,
        'access_link' => $request->access_link,
        'offense_classification' => $request->offense_classification,
        'missing_rating' => $request->missing_rating,
        'recommendations' => $request->recommendations,
        'observations' => $request->observations,
    ]);

    return redirect()->route('committee.index')->with('success', 'Comité creado correctamente.');
}


    public function show(Committee $committee)
    {
        return view('admin.committee.show', compact('committee'));
    }

    public function edit(Committee $committee)
    {
        // Obtenemos todas las actas (minutes) ordenadas por fecha descendente
        $minutes = Minutes::orderBy('minutes_date', 'desc')
                         ->orderBy('act_number', 'desc')
                         ->get();

        return view('admin.committee.edit', compact('committee', 'minutes'));
    }

    public function update(Request $request, Committee $committee)
    {
        $request->validate([
            'minutes_id' => 'required|exists:Minutes,minutes_id',
            'session_date' => 'required|date',
            'session_time' => 'required',
            'minutes_date' => 'required|date',
            'attendance_mode' => 'required|in:Presencial,Virtual,No asistió',
            'offense_class' => 'required|in:Leve,Grave,Muy Grave',
            'fault_type' => 'required|string',
            'statement' => 'required|string',
            'decision' => 'required|string',
            'commitments' => 'nullable|string',
            'access_link' => 'nullable|url',
            'offense_classification' => 'nullable|string',
            'missing_rating' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'observations' => 'nullable|string',
        ]);

        $minute = Minutes::findOrFail($request->minutes_id);

        $committee->update([
            'minutes_id' => $minute->minutes_id,
            'act_number' => $minute->act_number,
            'session_date' => $request->session_date,
            'session_time' => $request->session_time,
            'minutes_date' => $request->minutes_date,
            'trainee_name' => $minute->trainee_name,
            'attendance_mode' => $request->attendance_mode,
            'offense_class' => $request->offense_class,
            'fault_type' => $request->fault_type,
            'statement' => $request->statement,
            'decision' => $request->decision,
            'commitments' => $request->commitments,
            'access_link' => $request->access_link,
            'offense_classification' => $request->offense_classification,
            'missing_rating' => $request->missing_rating,
            'recommendations' => $request->recommendations,
            'observations' => $request->observations,
        ]);

        return redirect()->route('committee.index')->with('success', 'Comité actualizado correctamente.');
    }

    public function destroy(Committee $committee)
    {
        $committee->delete();
        return redirect()->route('committee.index')->with('success', 'Comité eliminado correctamente.');
    }
}
 