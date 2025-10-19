<?php

namespace App\Http\Controllers;

use App\Models\IndividualCommittee;
use App\Models\Minute;
use Illuminate\Http\Request;

class IndividualCommitteeController extends Controller
{
    public function index(Request $request)
    {
        $query = IndividualCommittee::query();

        // Filtrar por nombre del aprendiz
        if ($request->filled('trainee_name')) {
            $query->where('trainee_name', 'like', '%' . $request->trainee_name . '%');
        }

        // Filtrar por número de acta
        if ($request->filled('act_number')) {
            $query->where('act_number', 'like', '%' . $request->act_number . '%');
        }

        $committees = $query->orderBy('session_date', 'desc')->paginate(10);
        return view('admin.committee.index_individual', compact('committees'));
    }

    public function create(Request $request)
    {
        // Si viene con parámetro continue, mostrar información sobre aprendices pendientes
        $continue = $request->get('continue', false);
        $pendingInfo = null;
        
        if ($continue) {
            // Obtener información sobre aprendices que no tienen comité aún
            $pendingInfo = $this->getPendingApprentices();
        }
        
        // SIEMPRE filtrar actas completadas - solo mostrar actas con aprendices pendientes
        $minutes = $this->getMinutesWithPendingApprentices();
        
        // También obtener todos los minutes para el JavaScript (sin filtro)
        $allMinutes = Minute::with('reportingPerson')->orderBy('minutes_date', 'desc')->get();
        
        // Obtener información sobre qué aprendices ya tienen comité
        $minutesWithCommittee = IndividualCommittee::pluck('minutes_id')->toArray();
        
        return view('admin.committee.create_individual', compact('minutes', 'allMinutes', 'continue', 'pendingInfo', 'minutesWithCommittee'));
    }
    
    private function getPendingApprentices()
    {
        // Obtener todos los minutes
        $allMinutes = Minute::with('reportingPerson')->get();
        
        // Obtener actas que ya tienen comité general (excluir completamente)
        $excludedActNumbers = \App\Models\GeneralCommittee::pluck('act_number')->unique()->toArray();
        
        // Obtener todos los minutes que ya tienen comité individual
        $minutesWithCommittee = IndividualCommittee::pluck('minutes_id')->toArray();
        
        // Filtrar los que no tienen comité individual Y no están en actas con comité general
        $pendingMinutes = $allMinutes
            ->whereNotIn('minutes_id', $minutesWithCommittee)
            ->whereNotIn('act_number', $excludedActNumbers);
        
        // Agrupar por acta
        $groupedByAct = $pendingMinutes->groupBy('act_number');
        
        // Agregar información adicional sobre el progreso de cada acta
        $groupedByAct->transform(function ($minutes, $actNumber) use ($allMinutes) {
            $allMinutesInAct = $allMinutes->where('act_number', $actNumber);
            $totalApprentices = $allMinutesInAct->count();
            $pendingCount = $minutes->count();
            $completedCount = $totalApprentices - $pendingCount;
            
            return [
                'minutes' => $minutes,
                'total_apprentices' => $totalApprentices,
                'pending_count' => $pendingCount,
                'completed_count' => $completedCount,
                'progress_percentage' => $totalApprentices > 0 ? round(($completedCount / $totalApprentices) * 100, 1) : 0
            ];
        });
        
        return $groupedByAct;
    }
    
    private function getMinutesWithPendingApprentices()
    {
        // Obtener todos los minutes
        $allMinutes = Minute::with('reportingPerson')->get();
        
        // Obtener actas que ya tienen comité general (excluir completamente)
        $excludedActNumbers = \App\Models\GeneralCommittee::pluck('act_number')->unique()->toArray();
        
        // Obtener todos los minutes que ya tienen comité individual
        $minutesWithCommittee = IndividualCommittee::pluck('minutes_id')->toArray();
        
        // Filtrar los que no tienen comité individual Y no están en actas con comité general
        $pendingMinutes = $allMinutes
            ->whereNotIn('minutes_id', $minutesWithCommittee)
            ->whereNotIn('act_number', $excludedActNumbers);
        
        // Obtener números de acta únicos que tienen aprendices pendientes
        $actNumbersWithPending = $pendingMinutes->pluck('act_number')->unique();
        
        // Filtrar solo las actas que tienen aprendices pendientes
        $minutesWithPendingActs = $allMinutes->whereIn('act_number', $actNumbersWithPending);
        
        return $minutesWithPendingActs->sortByDesc('minutes_date');
    }
    
    private function getPendingMinutesForAct($actNumber)
    {
        // Verificar si la acta ya tiene comité general
        $hasGeneralCommittee = \App\Models\GeneralCommittee::where('act_number', $actNumber)->exists();
        if ($hasGeneralCommittee) {
            return collect([]); // No hay aprendices pendientes si ya tiene comité general
        }
        
        // Obtener todos los minutes de la acta específica
        $actMinutes = Minute::with('reportingPerson')->where('act_number', $actNumber)->get();
        
        // Obtener todos los minutes que ya tienen comité individual
        $minutesWithCommittee = IndividualCommittee::pluck('minutes_id')->toArray();
        
        // Filtrar los que no tienen comité individual
        $pendingMinutes = $actMinutes->whereNotIn('minutes_id', $minutesWithCommittee);
        
        return $pendingMinutes;
    }

    public function show(IndividualCommittee $individualCommittee)
    {
        // Cargar la relación con minutes para verificar si tiene contrato
        $individualCommittee->load('minutes');
        
        return view('admin.committee.show_individual', compact('individualCommittee'));
    }

    public function edit(IndividualCommittee $individualCommittee)
    {
        // Cargar la relación con minutes para verificar si tiene contrato
        $individualCommittee->load('minutes');
        
        $minutes = Minute::with('reportingPerson')->orderBy('minutes_date', 'desc')->get();
        return view('admin.committee.edit_individual', compact('individualCommittee', 'minutes'));
    }

    public function update(Request $request, IndividualCommittee $individualCommittee)
    {
        try {
            $request->validate([
                'session_date' => 'required|date',
                'session_time' => 'required',
                'minutes_id' => 'required|exists:minutes,minutes_id',
                'attendance_mode' => 'required|string',
                'offense_class' => 'required|string',
            ]);

            $data = $request->all();
            $data['committee_mode'] = 'Individual';

            // Solo obtener datos del minute para campos que no están en el formulario
            $minute = Minute::find($data['minutes_id']);
            if ($minute) {
                // Solo llenar campos que no vienen del formulario
                $data['act_number'] = $minute->act_number;
                $data['minutes_date'] = $minute->minutes_date;
                
                // Solo llenar campos de empresa si no están en el formulario
                if (empty($data['company_name'])) {
                    $data['company_name'] = $minute->company_name;
                }
                if (empty($data['company_address'])) {
                    $data['company_address'] = $minute->company_address;
                }
                if (empty($data['company_contact'])) {
                    $data['company_contact'] = $minute->company_contact;
                }
                if (empty($data['hr_responsible'])) {
                    $data['hr_responsible'] = $minute->hr_manager_name;
                }
                
                // Llenar nuevos campos del minute si no están en el formulario
                if (empty($data['document_type'])) {
                    $data['document_type'] = $minute->document_type;
                }
                if (empty($data['trainee_phone'])) {
                    $data['trainee_phone'] = $minute->trainee_phone;
                }
                if (empty($data['program_type'])) {
                    $data['program_type'] = $minute->program_type;
                }
                if (empty($data['trainee_status'])) {
                    $data['trainee_status'] = $minute->trainee_status;
                }
                if (empty($data['training_center'])) {
                    $data['training_center'] = $minute->training_center;
                }
                if (empty($data['incident_subtype'])) {
                    $data['incident_subtype'] = $minute->incident_subtype;
                }
            }

            $individualCommittee->update($data);
            
            \Log::info('Comité individual actualizado exitosamente', [
                'id' => $individualCommittee->individual_committee_id,
                'data' => $data
            ]);

            return redirect()->route('committee.individual.index')->with('success', 'Comité individual actualizado correctamente.');
        } catch (\Exception $e) {
            \Log::error('Error al actualizar comité individual', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);
            
            return redirect()->back()->with('error', 'Error al actualizar el comité: ' . $e->getMessage());
        }
    }

    public function destroy(IndividualCommittee $individualCommittee)
    {
        try {
            $individualCommittee->delete();
            
            \Log::info('Comité individual eliminado exitosamente', [
                'id' => $individualCommittee->individual_committee_id
            ]);

            return redirect()->route('committee.individual.index')->with('success', 'Comité individual eliminado correctamente.');
        } catch (\Exception $e) {
            \Log::error('Error al eliminar comité individual', [
                'error' => $e->getMessage(),
                'id' => $individualCommittee->individual_committee_id
            ]);
            
            return redirect()->back()->with('error', 'Error al eliminar el comité: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            \Log::info('=== INICIANDO STORE ===');
            \Log::info('Request data:', $request->all());
            \Log::info('Has committees?', ['has_committees' => $request->has('committees')]);
            \Log::info('Is committees array?', ['is_array' => is_array($request->committees)]);
            
            // Verificar si se están enviando múltiples comités
            if ($request->has('committees') && is_array($request->committees)) {
                \Log::info('Procesando múltiples comités');
                return $this->storeMultipleCommittees($request);
            }
            
            \Log::info('Procesando comité individual');
            
            // Procesar un solo comité (método original)
            $request->validate([
                'session_date' => 'required|date',
                'session_time' => 'required',
                'minutes_id' => 'required|exists:minutes,minutes_id',
                'attendance_mode' => 'required|string',
                'offense_class' => 'required|string',
            ]);

            $data = $request->all();
            $data['committee_mode'] = 'Individual';

            // Obtener datos del minute para llenar campos adicionales
            $minute = Minute::find($data['minutes_id']);
            if ($minute) {
                $data['act_number'] = $minute->act_number;
                $data['trainee_name'] = $minute->trainee_name;
                $data['minutes_date'] = $minute->minutes_date;
                $data['id_document'] = $minute->id_document;
                $data['document_type'] = $minute->document_type;
                $data['program_name'] = $minute->program_name;
                $data['program_type'] = $minute->program_type;
                $data['trainee_status'] = $minute->trainee_status;
                $data['training_center'] = $minute->training_center;
                $data['batch_number'] = $minute->batch_number;
                $data['email'] = $minute->email;
                $data['trainee_phone'] = $minute->trainee_phone;
                $data['company_name'] = $minute->company_name;
                $data['company_address'] = $minute->company_address;
                $data['hr_contact'] = $minute->hr_contact;
                $data['company_contact'] = $minute->company_contact;
                $data['incident_type'] = $minute->incident_type;
                $data['incident_subtype'] = $minute->incident_subtype;
                $data['incident_description'] = $minute->incident_description;
                $data['hr_responsible'] = $minute->hr_manager_name;
            }

            $committee = IndividualCommittee::create($data);
            
            \Log::info('Comité individual creado exitosamente', [
                'id' => $committee->individual_committee_id,
                'data' => $data
            ]);

            // Siempre redirigir a la lista
            return redirect()->route('committee.individual.index')->with('success', 'Comité individual creado correctamente.');
        } catch (\Exception $e) {
            \Log::error('Error al crear comité individual', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);
            
            return redirect()->back()->with('error', 'Error al crear el comité: ' . $e->getMessage());
        }
    }
    
    private function storeMultipleCommittees(Request $request)
    {
        try {
            $committees = $request->committees;
            $createdCommittees = [];
            
            \Log::info('Procesando múltiples comités', [
                'count' => count($committees),
                'committees' => $committees
            ]);
            
            foreach ($committees as $committeeData) {
                // Validar datos básicos
                if (empty($committeeData['minutes_id']) || empty($committeeData['session_date'])) {
                    \Log::warning('Comité omitido por datos incompletos', $committeeData);
                    continue;
                }
                
                // Crear el comité
                $committee = IndividualCommittee::create($committeeData);
                $createdCommittees[] = $committee;
                
                \Log::info('Comité individual creado', [
                    'id' => $committee->individual_committee_id,
                    'trainee' => $committee->trainee_name
                ]);
            }
            
            $count = count($createdCommittees);
            \Log::info('Múltiples comités creados exitosamente', [
                'total_created' => $count
            ]);
            
            return redirect()->route('committee.individual.index')
                ->with('success', "Se crearon {$count} comité(s) individual(es) correctamente.");
                
        } catch (\Exception $e) {
            \Log::error('Error al crear múltiples comités', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);
            
            return redirect()->back()->with('error', 'Error al crear los comités: ' . $e->getMessage());
        }
    }

    public function pdf(IndividualCommittee $individualCommittee)
    {
        $individualCommittee->load('minutes');
        
        $pdf = \PDF::loadView('admin.committee.pdf_individual', compact('individualCommittee'));
        
        $filename = 'Comite_Individual_' . $individualCommittee->trainee_name . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
}


