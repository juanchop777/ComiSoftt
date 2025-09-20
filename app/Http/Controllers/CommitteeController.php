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
    // Log para debuggear
    Log::info('Datos recibidos en store:', $request->all());
    
    // Validación básica para todos los tipos de comité
    $baseValidation = [
        'session_date' => 'required|date',
        'session_time' => 'required',
        'minutes_date' => 'required|date',
        'committee_mode' => 'required|in:Individual,General',
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
        'general_statements' => 'nullable|string',
        'individual_statements' => 'nullable|array',
    ];
    
    // Verificar si es un comité general o individual
    if ($request->committee_mode === 'General') {
        // Para comité general, validamos minutes_id (del primer acta) y modalidad de asistencia
        $validationRules = array_merge($baseValidation, [
            'minutes_id' => 'required|exists:minutes,minutes_id',
            'attendance_mode' => 'required|in:Presencial,Virtual,No asistió',
        ]);
    } else {
        // Para comité individual, validamos minutes_id y modalidad de asistencia individual
        $validationRules = array_merge($baseValidation, [
            'minutes_id' => 'required|exists:minutes,minutes_id',
            'attendance_mode' => 'required|in:Presencial,Virtual,No asistió',
        ]);
    }
    
    try {
        $request->validate($validationRules);
        Log::info('Validaciones pasaron correctamente');
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Error de validación:', $e->errors());
        throw $e;
    }
    
    // Procesar según el tipo de comité
    if ($request->committee_mode === 'General') {
        // Comité general - crear un comité para todos los aprendices del mismo acta
        $firstMinute = Minute::findOrFail($request->minutes_id);
        $actNumber = $firstMinute->act_number;
        
        // Buscar todas las actas con el mismo número
        $minutes = Minute::where('act_number', $actNumber)->get();
        $createdCount = 0;
        
        foreach ($minutes as $minute) {
            // Obtener el descargo individual para este aprendiz si existe
            $individualStatement = null;
            if ($request->has('individual_statements') && is_array($request->individual_statements)) {
                $individualStatement = $request->individual_statements[$minute->minutes_id] ?? null;
            }
            
            $committeeData = [
                'minutes_id' => $minute->minutes_id,
                'act_number' => $minute->act_number,
                'session_date' => $request->session_date,
                'session_time' => $request->session_time,
                'minutes_date' => $request->minutes_date,
                'trainee_name' => $minute->trainee_name,
                'attendance_mode' => $request->attendance_mode,
                'committee_mode' => $request->committee_mode,
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
                'general_statements' => $request->general_statements,
                'individual_statements' => $individualStatement,
            ];
            
            Log::info('Creando comité general con datos:', $committeeData);
            
            try {
                Committee::create($committeeData);
                $createdCount++;
                Log::info('Comité creado exitosamente para aprendiz: ' . $minute->trainee_name);
            } catch (\Exception $e) {
                Log::error('Error al crear comité para aprendiz ' . $minute->trainee_name . ': ' . $e->getMessage());
                throw $e;
            }
        }
        
        return redirect()->route('committee.index')
                ->with('success', "Se ha creado un comité general para $createdCount aprendices correctamente.");
    } else {
        // Comité individual - crear un solo comité
        $minute = Minute::findOrFail($request->minutes_id);
        
        $committeeData = [
            'minutes_id' => $minute->minutes_id,
            'act_number' => $minute->act_number,
            'session_date' => $request->session_date,
            'session_time' => $request->session_time,
            'minutes_date' => $request->minutes_date,
            'trainee_name' => $minute->trainee_name,
            'attendance_mode' => $request->attendance_mode,
            'committee_mode' => $request->committee_mode,
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
            'general_statements' => $request->general_statements,
        ];
        
        Log::info('Creando comité individual con datos:', $committeeData);
        
        try {
            Committee::create($committeeData);
            Log::info('Comité individual creado exitosamente para aprendiz: ' . $minute->trainee_name);
        } catch (\Exception $e) {
            Log::error('Error al crear comité individual para aprendiz ' . $minute->trainee_name . ': ' . $e->getMessage());
            throw $e;
        }
        
        return redirect()->route('committee.index')
                ->with('success', 'Comité individual creado correctamente.');
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
            'committee_mode' => 'required|in:Individual,General',
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
            'general_statements' => 'nullable|string',
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
            'committee_mode' => $request->committee_mode,
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
            'general_statements' => $request->general_statements,
        ]);

        return redirect()->route('committee.index')->with('success', 'Comité actualizado correctamente.');
    }

    public function destroy(Committee $committee)
    {
        $committee->delete();
        return redirect()->route('committee.index')->with('success', 'Comité eliminado correctamente.');
    }
}
 