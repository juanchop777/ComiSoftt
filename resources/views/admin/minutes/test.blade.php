@extends('layouts.admin')

@section('content')
<div class="container p-4">
    <h1>Prueba de Base de Datos</h1>
    
    <h3>Testing Minutes Model:</h3>
    @php
        try {
            $minutes = App\Models\Minutes::all();
            echo "<p>✅ Minutes encontrados: " . $minutes->count() . "</p>";
            
            if($minutes->count() > 0) {
                $firstMinute = $minutes->first();
                echo "<p>Primer minuto: ID=" . $firstMinute->minutes_id . ", Act Number=" . $firstMinute->act_number . "</p>";
            }
        } catch (Exception $e) {
            echo "<p>❌ Error en Minutes: " . $e->getMessage() . "</p>";
        }
    @endphp
    
    <h3>Testing ReportingPerson Model:</h3>
    @php
        try {
            $reportingPeople = App\Models\ReportingPerson::all();
            echo "<p>✅ ReportingPerson encontrados: " . $reportingPeople->count() . "</p>";
            
            if($reportingPeople->count() > 0) {
                $firstPerson = $reportingPeople->first();
                echo "<p>Primera persona: ID=" . $firstPerson->reporting_person_id . ", Nombre=" . $firstPerson->full_name . "</p>";
            }
        } catch (Exception $e) {
            echo "<p>❌ Error en ReportingPerson: " . $e->getMessage() . "</p>";
        }
    @endphp
    
    <h3>Testing Relationship:</h3>
    @php
        try {
            $minutesWithRelation = App\Models\Minutes::with('reportingPerson')->get();
            echo "<p>✅ Minutes con relación cargados: " . $minutesWithRelation->count() . "</p>";
            
            if($minutesWithRelation->count() > 0) {
                $firstMinute = $minutesWithRelation->first();
                if($firstMinute->reportingPerson) {
                    echo "<p>✅ Relación funcionando: " . $firstMinute->reportingPerson->full_name . "</p>";
                } else {
                    echo "<p>❌ Relación no funcionando para minuto ID: " . $firstMinute->minutes_id . "</p>";
                }
            }
        } catch (Exception $e) {
            echo "<p>❌ Error en relación: " . $e->getMessage() . "</p>";
        }
    @endphp
    
    <a href="{{ route('minutes.index') }}" class="btn btn-primary">Volver al Index</a>
</div>
@endsection

