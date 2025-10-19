<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportingPerson;
use App\Models\Minute;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MinuteController extends Controller
{
    /**
     * Muestra el listado de actas agrupadas por número de acta
     */
    public function index(Request $request)
    {
        $incidentType = $request->get('incident_type'); // Academic, Disciplinary, Dropout

        // Obtener números de acta únicos con filtros
        $query = Minute::select('act_number')
            ->selectRaw('MIN(minutes_date) as min_date')
            ->groupBy('act_number');

        // Filtrar por tipo de novedad
        if ($incidentType) {
            $query->where('incident_type', $incidentType);
        }

        // Ordenar por fecha y paginar los números de acta únicos
        $actNumbers = $query->orderBy('min_date', 'desc')->paginate(10);

        // Obtener todos los minutes para los números de acta de la página actual
        $actNumbersList = $actNumbers->pluck('act_number')->toArray();
        
        $minutesRaw = Minute::with('reportingPerson')
            ->whereIn('act_number', $actNumbersList)
            ->orderBy('minutes_date', 'desc')
            ->get();

        // Agrupar por número de acta
        $minutes = [];
        foreach ($minutesRaw as $minute) {
            $actNumber = $minute->act_number;

            if (!isset($minutes[$actNumber])) {
                $minutes[$actNumber] = [
                    'minutes_date' => $minute->minutes_date,
                    'reportingPerson' => $minute->reportingPerson,
                    'count' => 0,
                    'incident_types' => [],
                    'raw_data' => []
                ];
            }

            $minutes[$actNumber]['count']++;
            if (!in_array($minute->incident_type, $minutes[$actNumber]['incident_types'])) {
                $minutes[$actNumber]['incident_types'][] = $minute->incident_type;
            }
            $minutes[$actNumber]['raw_data'][] = $minute;
        }

        return view('admin.minutes.index', compact('minutes', 'minutesRaw', 'actNumbers'));
    }

    /**
     * Traduce los tipos de novedad al español
     */
    private function translateIncidentType($type)
    {
        $types = [
            'Academic' => 'Académica',
            'Disciplinary' => 'Disciplinaria',
            'Dropout' => 'Deserción'
        ];
        
        return $types[$type] ?? $type;
    }

    /**
     * Muestra el formulario de creación de actas
     */
    public function create()
    {
        return view('admin.minutes.create');
    }

    /**
     * Almacena una nueva acta en la base de datos
     */
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        
        try {
            DB::beginTransaction();
            
            $reportingPerson = ReportingPerson::create([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null
            ]);

            $this->createMinutes($validated, $reportingPerson->reporting_person_id);
            
            DB::commit();
            
            return redirect()
                ->route('minutes.index')
                ->with('success', 'Acta(s) registrada(s) correctamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear acta: ' . $e->getMessage());
            return back()
                ->with('error', 'Error al guardar el acta')
                ->withInput();
        }
    }

    /**
     * Muestra el formulario de edición de un acta
     */
    public function edit($actNumber)
    {
        try {
            $minutes = Minute::with('reportingPerson')
                        ->where('act_number', $actNumber)
                        ->get();

            if ($minutes->isEmpty()) {
                throw new \Exception("No se encontró el acta número $actNumber");
            }

            $firstMinute = $minutes->first();
            $minutesDate = $this->getMinutesDate($firstMinute, $actNumber);

            return view('admin.minutes.edit', [
                'actNumber' => $actNumber,
                'minutes' => $minutes,
                'reportingPerson' => $firstMinute->reportingPerson,
                'minutesDate' => $minutesDate
            ]);

        } catch (\Exception $e) {
            Log::error('Error en edición de acta: ' . $e->getMessage());
            return redirect()
                ->route('minutes.index')
                ->with('error', 'Error al cargar el acta para edición: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza un acta existente
     */
    public function update(Request $request, $actNumber)
    {
        $validated = $this->validateRequest($request, true);
        
        try {
            DB::beginTransaction();
            
            $minutes = Minute::where('act_number', $actNumber)->get();
            if ($minutes->isEmpty()) {
                throw new \Exception("No se encontró el acta número $actNumber");
            }

            $reportingPersonId = $minutes->first()->reporting_person_id;

            // Actualizar persona que reporta
            ReportingPerson::where('reporting_person_id', $reportingPersonId)->update([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null
            ]);

            // Actualizar o crear aprendices
            $this->upsertMinutes($request, $reportingPersonId, $actNumber);

            DB::commit();
            
            return redirect()
                ->route('minutes.index')
                ->with('success', 'Acta actualizada correctamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar acta: ' . $e->getMessage());
            return back()
                ->with('error', 'Error al actualizar el acta')
                ->withInput();
        }
    }

    /**
     * Elimina un acta o aprendiz específico
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $result = $this->deleteMinuteOrActa($id);
            
            DB::commit();
            
            return response()->json($result);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Valida los datos del request
     */
    private function validateRequest(Request $request, $isUpdate = false)
    {
        $rules = [
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'act_number' => 'required|string|max:20',
            'minutes_date' => 'required|date|before_or_equal:today',
            'trainee_name' => 'required|array',
            'trainee_name.*' => 'required|string|max:100',
            'trainee_email.*' => 'nullable|email|max:100',
            'document_type.*' => 'required|string|max:10',
            'id_document.*' => 'required|string|max:30',
            'trainee_phone.*' => 'nullable|string|max:20',
            'program_name.*' => 'required|string|max:100',
            'batch_number.*' => 'required|string|max:20',
            'training_center' => 'required|string|max:255',
            'program_type.*' => 'required|string|max:100',
            'trainee_status.*' => 'required|string|max:50',
            'has_contract.*' => 'nullable|in:0,1',
            'company_name.*' => 'nullable|string|max:100',
            'company_address.*' => 'nullable|string|max:150',
            'hr_manager_name.*' => 'nullable|string|max:100',
            'company_contact.*' => 'nullable|string|max:150',
            'incident_type.*' => 'nullable|in:CANCELACION_MATRICULA_ACADEMICO,CANCELACION_MATRICULA_DISCIPLINARIO,CONDICIONAMIENTO_MATRICULA,DESERCION_PROCESO_FORMACION,NO_GENERACION_CERTIFICADO,RETIRO_POR_FRAUDE,RETIRO_PROCESO_FORMACION,TRASLADO_CENTRO,TRASLADO_JORNADA,TRASLADO_PROGRAMA',
            'incident_subtype.*' => 'nullable|in:INCUMPLIMIENTO_CONTRATO_APRENDIZAJE,NO_CUMPLIO_PLAN_MEJORAMIENTO,SANCION_IMPUESTA_MEDIANTE_DEBIDO_PROCESO,CONCERTACION_PLAN_DE_MEJORAMIENTO,INCUMPLIMIENTO_INASISTENCIA_3_DIAS,NO_PRESENTA_EVIDENCIA_ETAPA_PRODUCTIVA,NO_SE_REINTEGRA_APLAZAMIENTO,FORMACION_NO_REALIZADA,PROGRAMA_DE_FORMACION_REALIZADO_NO_CORRESPONDE,SUPLANTACION_DATOS_BASICOS_PARA_CERTIFICARSE,NO_INICIO_PROCESO_FORMACION,POR_FALLECIMIENTO,CAMBIO_DE_DOMICILIO,MOTIVOS_LABORALES,MOTIVOS_PERSONALES',
            'incident_description.*' => 'required|string'
        ];

        if ($isUpdate) {
            // Permitir crear nuevos aprendices (minutes_ids puede traer vacíos o no existir)
            $rules['minutes_ids'] = 'array';
            $rules['minutes_ids.*'] = 'nullable|integer';
        }

        return $request->validate($rules);
    }

    /**
     * Crea los registros de minutos
     */
    private function createMinutes($data, $reportingPersonId)
    {
        foreach ($data['trainee_name'] as $index => $name) {
            Minute::create([
                'act_number' => $data['act_number'],
                'minutes_date' => $data['minutes_date'],
                'trainee_name' => $name,
                'email' => $data['trainee_email'][$index] ?? null,
                'document_type' => $data['document_type'][$index],
                'id_document' => $data['id_document'][$index],
                'trainee_phone' => $data['trainee_phone'][$index] ?? null,
                'program_name' => $data['program_name'][$index],
                'batch_number' => $data['batch_number'][$index],
                'training_center' => $data['training_center'],
                'program_type' => $data['program_type'][$index],
                'trainee_status' => $data['trainee_status'][$index],
                'has_contract' => ($data['has_contract'][$index] ?? 0) == '1',
                'company_name' => $data['company_name'][$index] ?? null,
                'company_address' => $data['company_address'][$index] ?? null,
                'hr_manager_name' => $data['hr_manager_name'][$index] ?? null,
                'company_contact' => $data['company_contact'][$index] ?? null,
                'incident_type' => $data['incident_type'][$index] ?? null,
                'incident_subtype' => $data['incident_subtype'][$index] ?? null,
                'incident_description' => $data['incident_description'][$index],
                'reception_date' => now()->format('Y-m-d'),
                'reporting_person_id' => $reportingPersonId
            ]);
        }
    }

    /**
     * Actualiza existentes o crea nuevos registros de minutos
     */
    private function upsertMinutes(Request $request, $reportingPersonId, $actNumber)
    {
        // Si quieres, aquí podrías eliminar los que no fueron enviados (soft delete),
        // pero como ya usas botón de eliminar por AJAX, no lo hacemos automáticamente.

        foreach ($request->trainee_name as $index => $name) {
            $minuteId = $request->minutes_ids[$index] ?? null;

            $data = [
                'act_number'          => $request->act_number,
                'minutes_date'        => $request->minutes_date,
                'trainee_name'        => $name,
                'email'               => $request->trainee_email[$index] ?? null,
                'document_type'       => $request->document_type[$index],
                'id_document'         => $request->id_document[$index],
                'trainee_phone'       => $request->trainee_phone[$index] ?? null,
                'program_name'        => $request->program_name[$index],
                'batch_number'        => $request->batch_number[$index],
                'training_center'     => $request->training_center,
                'program_type'        => $request->program_type[$index],
                'trainee_status'      => $request->trainee_status[$index],
                'has_contract'        => ($request->has_contract[$index] ?? 0) == '1',
                'company_name'        => $request->company_name[$index] ?? null,
                'company_address'     => $request->company_address[$index] ?? null,
                'hr_manager_name'     => $request->hr_manager_name[$index] ?? null,
                'company_contact'     => $request->company_contact[$index] ?? null,
                'incident_type'       => $request->incident_type[$index] ?? null,
                'incident_subtype'    => $request->incident_subtype[$index] ?? null,
                'incident_description'=> $request->incident_description[$index],
                'reporting_person_id' => $reportingPersonId,
            ];

            if (!empty($minuteId)) {
                // Actualizar aprendiz existente
                Minute::where('minutes_id', $minuteId)->update($data);
            } else {
                // Crear nuevo aprendiz
                $data['reception_date'] = now()->format('Y-m-d');
                Minute::create($data);
            }
        }
    }

    /**
     * Obtiene la fecha del acta con manejo de errores
     */
    private function getMinutesDate($minute, $actNumber)
    {
        if (empty($minute->minutes_date)) {
            Log::warning("El acta $actNumber no tiene fecha registrada. Usando fecha actual.");
            return now()->format('Y-m-d');
        }
        
        return Carbon::parse($minute->minutes_date)->format('Y-m-d');
    }

    /**
     * Elimina un aprendiz individual o un acta completa
     */
    private function deleteMinuteOrActa($id)
    {
        // Primero intentar encontrar como aprendiz individual
        $minute = Minute::find($id);
        
        if ($minute) {
            return $this->deleteApprentice($minute);
        }
        
        // Si no se encontró como aprendiz, intentar como acta completa
        return $this->deleteActa($id);
    }

    /**
     * Elimina un aprendiz individual
     */
    private function deleteApprentice($minute)
    {
        $reportingPersonId = $minute->reporting_person_id;
        $actNumber = $minute->act_number;
        
        $minute->delete();
        
        // Verificar si quedan más aprendices en el acta
        $remainingMinutes = Minute::where('act_number', $actNumber)->count();
        
        if ($remainingMinutes === 0) {
            // No quedan más aprendices, eliminar también la persona que reporta
            ReportingPerson::where('reporting_person_id', $reportingPersonId)->delete();
            
            return [
                'success' => true,
                'message' => 'Aprendiz eliminado y acta cerrada (no quedan más aprendices)',
                'type' => 'apprentice_with_act'
            ];
        }
        
        return [
            'success' => true,
            'message' => 'Aprendiz eliminado correctamente',
            'type' => 'apprentice'
        ];
    }

    /**
     * Elimina un acta completa
     */
    private function deleteActa($actNumber)
    {
        $minutes = Minute::where('act_number', $actNumber)->get();
        
        if ($minutes->isEmpty()) {
            return [
                'success' => false,
                'message' => 'No se encontró el registro a eliminar'
            ];
        }
        
        $reportingPersonId = $minutes->first()->reporting_person_id;
        
        // Eliminar todos los registros del acta
        Minute::where('act_number', $actNumber)->delete();
        
        // Verificar si la persona que reporta tiene más actas
        $remainingMinutes = Minute::where('reporting_person_id', $reportingPersonId)->count();
        
        // Si no tiene más actas, eliminar también la persona que reporta
        if ($remainingMinutes === 0) {
            ReportingPerson::where('reporting_person_id', $reportingPersonId)->delete();
        }
        
        return [
            'success' => true,
            'message' => 'Acta eliminada correctamente',
            'type' => 'act'
        ];
    }

    public function ajaxSearch(Request $request)
{
    $term = $request->get('term', '');

    $minutes = Minute::where('act_number', 'like', "%{$term}%")
                      ->orWhere('trainee_name', 'like', "%{$term}%")
                      ->orderBy('minutes_date', 'desc')
                      ->limit(50)
                      ->get();

    $results = [];
    foreach ($minutes as $minute) {
        $results[] = [
            'id' => $minute->minutes_id,
            'label' => "Acta #{$minute->act_number} - {$minute->trainee_name} (" . \Carbon\Carbon::parse($minute->minutes_date)->format('d/m/Y') . ")",
            'trainee_name' => $minute->trainee_name,
            'minutes_date' => $minute->minutes_date,
        ];
    }

    return response()->json($results);
}

    /**
     * Genera un PDF del acta
     */
    public function pdf($actNumber)
    {
        try {
            $minutes = Minute::with('reportingPerson')
                        ->where('act_number', $actNumber)
                        ->get();

            if ($minutes->isEmpty()) {
                abort(404, 'Acta no encontrada');
            }

            $firstMinute = $minutes->first();
            $reportingPerson = $firstMinute->reportingPerson;
            $minutesDate = $firstMinute->minutes_date;

            $pdf = \PDF::loadView('admin.minutes.pdf', [
                'actNumber' => $actNumber,
                'minutes' => $minutes,
                'reportingPerson' => $reportingPerson,
                'minutesDate' => $minutesDate
            ]);

            $filename = "Acta_{$actNumber}_" . now()->format('Y-m-d_H-i-s') . '.pdf';
            
            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Error al generar PDF del acta: ' . $e->getMessage());
            abort(500, 'Error al generar el PDF');
        }
    }

}
