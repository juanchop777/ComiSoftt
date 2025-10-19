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

        $committees = $query->orderBy('session_date', 'desc')->paginate(10);
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

        // Obtener datos del primer minute para llenar campos adicionales
        $firstMinute = Minute::where('act_number', $request->act_number)->first();
        if ($firstMinute) {
            $data['trainee_name'] = $firstMinute->trainee_name;
            $data['minutes_date'] = $firstMinute->minutes_date;
            $data['id_document'] = $firstMinute->id_document;
            $data['document_type'] = $firstMinute->document_type;
            $data['program_name'] = $firstMinute->program_name;
            $data['program_type'] = $firstMinute->program_type;
            $data['trainee_status'] = $firstMinute->trainee_status;
            $data['training_center'] = $firstMinute->training_center;
            $data['batch_number'] = $firstMinute->batch_number;
            $data['email'] = $firstMinute->email;
            $data['trainee_phone'] = $firstMinute->trainee_phone;
            $data['company_name'] = $firstMinute->company_name;
            $data['company_address'] = $firstMinute->company_address;
            $data['hr_contact'] = $firstMinute->hr_contact;
            // $data['company_contact'] = $firstMinute->company_contact; // Campo no existe en general_committees
            $data['incident_type'] = $firstMinute->incident_type;
            $data['incident_subtype'] = $firstMinute->incident_subtype;
            $data['incident_description'] = $firstMinute->incident_description;
            $data['hr_responsible'] = $firstMinute->hr_manager_name;
        }

        // Si hay descargos individuales, los convertimos a JSON
        if ($request->has('individual_statements')) {
            $data['individual_statements'] = json_encode($request->individual_statements);
        }

        GeneralCommittee::create($data);

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

        $generalCommittee->update($data);

        return redirect()->route('committee.general.index')->with('success', 'Comité general actualizado correctamente.');
    }

    public function destroy(GeneralCommittee $generalCommittee)
    {
        $generalCommittee->delete();
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


