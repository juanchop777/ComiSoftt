<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Minute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommitteeController extends Controller
{
    public function index(Request $request)
{
    // Armamos la consulta base con la relación
    $query = Committee::with('minutes');

    // 🔍 Filtro por nombre del aprendiz
    if ($request->filled('trainee_name')) {
        $query->where('trainee_name', 'LIKE', '%' . $request->trainee_name . '%');
    }

    // 🔍 Filtro por fecha de sesión
    if ($request->filled('session_date')) {
        $query->whereDate('session_date', $request->session_date);
    }

    // Obtenemos el resultado
    $committees = $query->orderBy('session_date', 'desc')->get();

    return view('admin.committee.index', compact('committees'));
}


    

    public function create()
{
    // Primero verificamos los datos
    $totalMinutes = Minute::count();
    $availableMinutes = Minute::whereDoesntHave('committees')->count();
    
    // Creamos el log para debugging
    Log::debug('Datos de actas:', [
        'total' => $totalMinutes,
        'disponibles' => $availableMinutes
    ]);
    
    // Ahora obtenemos los datos para la vista
    $minutes = Minute::with('reportingPerson')
        ->whereDoesntHave('committees')
        ->orderBy('minutes_date', 'desc')
        ->orderBy('act_number', 'desc')
        ->get();
    
    return view('admin.committee.create', compact('minutes'));
}

    public function store(Request $request)
{
    // Validación básica para todos los tipos de comité
    $baseValidation = [
        'session_date' => 'required|date',
        'session_time' => 'required',
        'minutes_date' => 'required|date',
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
    ];
    
    // Verificar si es un comité general o individual
    if ($request->has('committee_mode') && $request->committee_mode === 'general') {
        // Para comité general, validamos la modalidad de asistencia general
        $validationRules = array_merge($baseValidation, [
            'attendance_mode_general' => 'required|in:Presencial,Virtual,No asistió',
            'act_numbers' => 'required|array', // Array de números de acta para comité general
            'act_numbers.*' => 'required|string',
        ]);
    } else {
        // Para comité individual, validamos minutes_id y modalidad de asistencia individual
        $validationRules = array_merge($baseValidation, [
            'minutes_id' => 'required|exists:minutes,minutes_id',
            'attendance_mode' => 'required|in:Presencial,Virtual,No asistió',
        ]);
    }
    
    $request->validate($validationRules);
    
    // Procesar según el tipo de comité
    if ($request->has('committee_mode') && $request->committee_mode === 'general') {
        // Comité general - crear un comité para cada acta seleccionada
        $actNumbers = $request->act_numbers;
        $createdCount = 0;
        
        foreach ($actNumbers as $actNumber) {
            // Buscar todas las actas con ese número
            $minutes = Minute::where('act_number', $actNumber)->get();
            
            foreach ($minutes as $minute) {
                Committee::create([
                    'minutes_id' => $minute->minutes_id,
                    'act_number' => $minute->act_number,
                    'session_date' => $request->session_date,
                    'session_time' => $request->session_time,
                    'minutes_date' => $request->minutes_date,
                    'trainee_name' => $minute->trainee_name,
                    'attendance_mode' => $request->attendance_mode_general, // Usar la modalidad general
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
                
                $createdCount++;
            }
        }
        
        return redirect()->route('committee.index')
                ->with('success', "Se han creado $createdCount comités correctamente.");
    } else {
        // Comité individual - crear un solo comité
        $minute = Minute::findOrFail($request->minutes_id);
        
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
        
        return redirect()->route('committee.index')
                ->with('success', 'Comité creado correctamente.');
    }
}


    public function show(Committee $committee)
    {
        return view('admin.committee.show', compact('committee'));
    }

    public function edit(Committee $committee)
    {
        // Obtenemos todas las actas (minutes) ordenadas por fecha descendente
        $minutes = Minute::orderBy('minutes_date', 'desc')
                         ->orderBy('act_number', 'desc')
                         ->get();

        return view('admin.committee.edit', compact('committee', 'minutes'));
    }

    public function update(Request $request, Committee $committee)
    {
        $request->validate([
            'minutes_id' => 'required|exists:minutes,minutes_id',
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

        $minute = Minute::findOrFail($request->minutes_id);

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
 