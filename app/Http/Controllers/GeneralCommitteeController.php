<?php

namespace App\Http\Controllers;

use App\Models\GeneralCommittee;
use App\Models\Minute;
use Illuminate\Http\Request;

class GeneralCommitteeController extends Controller
{
    public function index(Request $request)
    {
        $query = GeneralCommittee::query();

        // Filtrar por número de acta
        if ($request->filled('act_number')) {
            $query->where('act_number', 'like', '%' . $request->act_number . '%');
        }

        // Filtrar por fecha de sesión
        if ($request->filled('session_date')) {
            $query->whereDate('session_date', $request->session_date);
        }

        // Agrupar por act_number para mostrar solo un registro por comité general
        $committees = $query->selectRaw('MIN(general_committee_id) as general_committee_id, session_date, session_time, act_number, attendance_mode, offense_class')
            ->groupBy('act_number', 'session_date', 'session_time', 'attendance_mode', 'offense_class')
            ->orderBy('session_date', 'desc')
            ->paginate(10);
            
        return view('admin.committee.index_general', compact('committees'));
    }

    public function create()
    {
        // Excluir actas que ya tienen comité general O comité individual
        $excludedActNumbers = collect([])
            ->merge(GeneralCommittee::pluck('act_number'))
            ->merge(\App\Models\IndividualCommittee::pluck('act_number'))
            ->unique()
            ->toArray();

        $minutes = Minute::with('reportingPerson')
            ->when(count($excludedActNumbers) > 0, function ($q) use ($excludedActNumbers) {
                $q->whereNotIn('act_number', $excludedActNumbers);
            })
            ->orderBy('minutes_date', 'desc')
            ->get();

        // También enviamos todas las actas si se necesitan para JS (opcional)
        $allMinutes = Minute::with('reportingPerson')->orderBy('minutes_date', 'desc')->get();

        return view('admin.committee.create_general', compact('minutes', 'allMinutes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'session_date' => 'required|date',
            'session_time' => 'required',
            'act_number' => 'required',
            'attendance_mode' => 'required|string',
            'offense_class' => 'required|string',
        ]);

        $data = $request->all();
        $data['committee_mode'] = 'General';

        // Obtener TODOS los minutos para el act_number
        $allMinutes = Minute::where('act_number', $request->act_number)->get();
        
        if ($allMinutes->count() > 0) {
            // Crear un registro por cada aprendiz
            foreach ($allMinutes as $minute) {
                $dataPerTrainee = $data; // Copiar datos base
                
                // Llenar campos específicos de cada aprendiz
                $dataPerTrainee['trainee_name'] = $minute->trainee_name;
                $dataPerTrainee['minutes_id'] = $minute->minutes_id;
                $dataPerTrainee['minutes_date'] = $minute->minutes_date;
                $dataPerTrainee['id_document'] = $minute->id_document;
                $dataPerTrainee['document_type'] = $minute->document_type;
                $dataPerTrainee['program_name'] = $minute->program_name;
                $dataPerTrainee['program_type'] = $minute->program_type;
                $dataPerTrainee['trainee_status'] = $minute->trainee_status;
                $dataPerTrainee['training_center'] = $minute->training_center;
                $dataPerTrainee['batch_number'] = $minute->batch_number;
                $dataPerTrainee['email'] = $minute->email;
                $dataPerTrainee['trainee_phone'] = $minute->trainee_phone;
                $dataPerTrainee['company_name'] = $minute->company_name;
                $dataPerTrainee['company_address'] = $minute->company_address;
                $dataPerTrainee['company_contact'] = $minute->company_contact;
                $dataPerTrainee['incident_type'] = $minute->incident_type;
                $dataPerTrainee['incident_subtype'] = $minute->incident_subtype;
                $dataPerTrainee['incident_description'] = $minute->incident_description;
                $dataPerTrainee['hr_responsible'] = $minute->hr_manager_name;
                
                // Si hay descargos individuales, guardar todos los descargos
                if ($request->has('individual_statements') && !empty($request->individual_statements)) {
                    $dataPerTrainee['individual_statements'] = json_encode($request->individual_statements);
                }
                
                // Crear el registro para este aprendiz
                GeneralCommittee::create($dataPerTrainee);
            }
        }

        return redirect()->route('committee.general.index')->with('success', 'Comité general creado correctamente.');
    }

    public function show(GeneralCommittee $generalCommittee)
    {
        $generalCommittee->load('minutes');
        $minutes = Minute::where('act_number', $generalCommittee->act_number)->get();
        return view('admin.committee.show_general', compact('generalCommittee', 'minutes'));
    }

    public function edit(GeneralCommittee $generalCommittee)
    {
        $generalCommittee->load('minutes');
        $minutesForAct = Minute::where('act_number', $generalCommittee->act_number)->get();
        $minutes = Minute::with('reportingPerson')->orderBy('minutes_date', 'desc')->get();
        return view('admin.committee.edit_general', compact('generalCommittee', 'minutes', 'minutesForAct'));
    }

    public function update(Request $request, GeneralCommittee $generalCommittee)
    {
        $request->validate([
            'session_date' => 'required|date',
            'session_time' => 'required',
            'attendance_mode' => 'required|string',
            'offense_class' => 'required|string',
        ]);

        $data = $request->all();

        // Obtener datos del minute para llenar campos adicionales si no están en el formulario
        if ($request->has('minutes_id') && $request->minutes_id) {
            $minute = Minute::find($request->minutes_id);
            if ($minute) {
                // Solo llenar campos que no vienen del formulario
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
                if (empty($data['company_contact'])) {
                    $data['company_contact'] = $minute->company_contact;
                }
            }
        }

        // Normalizar descargos: si el general llega vacío, guardamos null.
        $generalText = trim((string) $request->input('general_statements', ''));

        // Manejo de individuales: filtrar vacíos y decidir null o JSON
        $individualArray = $request->input('individual_statements', null);
        if (is_array($individualArray)) {
            $filtered = [];
            foreach ($individualArray as $key => $val) {
                if (is_string($val)) {
                    $val = trim($val);
                }
                if (!empty($val)) {
                    $filtered[$key] = $val;
                }
            }
            $individualArray = count($filtered) > 0 ? $filtered : null;
        }

        // Reglas exclusivas: si hay individuales válidos, anulamos el general; si no, usamos el general (puede ser null)
        if ($individualArray !== null) {
            $data['individual_statements'] = json_encode($individualArray);
            $data['general_statements'] = null;
        } else {
            $data['individual_statements'] = null;
            $data['general_statements'] = ($generalText === '') ? null : $generalText;
        }

        // Actualizar TODOS los registros del mismo act_number
        $allCommittees = GeneralCommittee::where('act_number', $generalCommittee->act_number)->get();
        
        foreach ($allCommittees as $committee) {
            $committee->update($data);
        }

        return redirect()->route('committee.general.index')->with('success', 'Comité general actualizado correctamente.');
    }

    public function destroy(GeneralCommittee $generalCommittee)
    {
        // Eliminar TODOS los registros del mismo act_number
        GeneralCommittee::where('act_number', $generalCommittee->act_number)->delete();
        return redirect()->route('committee.general.index')->with('success', 'Comité general eliminado correctamente.');
    }

    public function pdf(GeneralCommittee $generalCommittee)
    {
        $generalCommittee->load('minutes');
        
        $pdf = \PDF::loadView('admin.committee.pdf_general', compact('generalCommittee'));
        
        $filename = 'Comite_General_Acta_' . $generalCommittee->act_number . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
}


