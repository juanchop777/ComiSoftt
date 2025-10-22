<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comité General - Acta #{{ $generalCommittee->act_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #ffffff;
        }
        
        .container {
            max-width: 100%;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
            border-radius: 4px;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        
        .header h2 {
            font-size: 16px;
            margin: 5px 0 0 0;
        }
        
        .section {
            margin-bottom: 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        
        .section-title {
            background-color: #f3f4f6;
            color: #374151;
            padding: 12px 15px;
            font-weight: bold;
            font-size: 14px;
            margin: 0;
            border-bottom: 1px solid #d1d5db;
        }
        
        .section-title.blue {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .section-title.green {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .section-title.yellow {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .section-title.red {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .section-content {
            padding: 15px;
            background-color: #ffffff;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            table-layout: auto;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .info-table td {
            padding: 10px 15px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
            word-wrap: break-word;
            white-space: normal;
            overflow-wrap: break-word;
        }
        
        .info-table td:first-child {
            width: 30%;
            font-weight: bold;
            background-color: #f8fafc;
            color: #374151;
        }
        
        .info-table td:last-child {
            width: 70%;
            background-color: #ffffff;
            color: #1f2937;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            border: 1px solid #d1d5db;
        }
        
        .badge-purple {
            background-color: #f9fafb;
            color: #374151;
        }
        
        .badge-green {
            background-color: #f9fafb;
            color: #374151;
        }
        
        .badge-red {
            background-color: #f9fafb;
            color: #374151;
        }
        
        .badge-orange {
            background-color: #f9fafb;
            color: #374151;
        }
        
        .text-content {
            background-color: #f9fafb;
            padding: 10px 15px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            margin-top: 5px;
            word-wrap: break-word;
            white-space: normal;
            overflow-wrap: break-word;
            min-height: 50px;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .apprentice-card {
            border: 1px solid #e5e7eb;
            margin-bottom: 15px;
            border-radius: 8px;
            overflow: hidden;
            page-break-inside: avoid;
            break-inside: avoid;
            page-break-before: always;
        }
        
        .apprentice-card:first-child {
            page-break-before: auto;
        }
        
        .apprentice-header {
            background-color: #f3f4f6;
            color: #374151;
            padding: 12px 15px;
            font-weight: bold;
            font-size: 12px;
            border-bottom: 1px solid #d1d5db;
        }
        
        .apprentice-content {
            padding: 15px;
        }
        
        .apprentice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .apprentice-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
            word-wrap: break-word;
            white-space: normal;
            overflow-wrap: break-word;
        }
        
        .apprentice-table td:first-child {
            width: 25%;
            font-weight: bold;
            background-color: #f8fafc;
            color: #374151;
        }
        
        .apprentice-table td:last-child {
            width: 75%;
            background-color: #ffffff;
            color: #1f2937;
        }
        
        .company-section {
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
            page-break-inside: avoid;
            break-inside: avoid;
            page-break-before: avoid;
            page-break-after: avoid;
        }
        
        .incident-card {
            border: 1px solid #e5e7eb;
            margin-bottom: 15px;
            border-radius: 8px;
            overflow: hidden;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .company-section h4 {
            color: #374151;
            margin: 0 0 15px 0;
            font-size: 14px;
            font-weight: bold;
        }
        
        
        .decision-section {
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .decision-section h4 {
            color: #374151;
            margin: 0 0 15px 0;
            font-size: 14px;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        
        @page {
            margin: 1cm;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>COMITÉ GENERAL</h1>
            <h2>Acta #{{ $generalCommittee->act_number }}</h2>
        </div>

        <!-- Información de la Sesión -->
        <div class="section">
            <div class="section-title blue">INFORMACIÓN DE LA SESIÓN</div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>Fecha de Sesión</td>
                        <td>{{ $generalCommittee->session_date }}</td>
                    </tr>
                    <tr>
                        <td>Hora de Sesión</td>
                        <td>{{ $generalCommittee->session_time }}</td>
                    </tr>
                    <tr>
                        <td>Modalidad de Asistencia</td>
                        <td><span class="badge badge-purple">{{ $generalCommittee->attendance_mode }}</span></td>
                    </tr>
                    @if($generalCommittee->attendance_mode == 'Virtual' && $generalCommittee->access_link)
                    <tr>
                        <td>Enlace de Acceso</td>
                        <td>{{ $generalCommittee->access_link }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Información de los Aprendices -->
        <div class="section">
            <div class="section-title green">INFORMACIÓN DE LOS APRENDICES</div>
            <div class="section-content">
                @php
                    $minutes = \App\Models\Minute::where('act_number', $generalCommittee->act_number)->get();
                @endphp
                @if($minutes->count() > 0)
                    @foreach($minutes as $index => $minute)
                        <div class="apprentice-card">
                            <div class="apprentice-header">
                                Aprendiz #{{ $index + 1 }} - {{ $minute->trainee_name }}
                            </div>
                            <div class="apprentice-content">
                                <table class="apprentice-table">
                                    <tr>
                                        <td>Tipo de Documento</td>
                                        <td>{{ $minute->document_type ?: 'No especificado' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Número de Documento</td>
                                        <td>{{ $minute->id_document ?: 'No especificado' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Teléfono del Aprendiz</td>
                                        <td>{{ $minute->trainee_phone ?: 'No especificado' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>{{ $minute->email ?: 'No especificado' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Programa de Formación</td>
                                        <td>{{ $minute->program_name ?: 'No especificado' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Número de Ficha</td>
                                        <td>{{ $minute->batch_number ?: 'No especificado' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tipo de Programa</td>
                                        <td>{{ $minute->program_type ?: 'No especificado' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Estado del Aprendiz</td>
                                        <td>{{ $minute->trainee_status ?: 'No especificado' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Centro de Formación</td>
                                        <td>{{ $minute->training_center ?: 'No especificado' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Contrato</td>
                                        <td>
                                            <span class="badge {{ $minute->has_contract ? 'badge-green' : 'badge-red' }}">
                                                {{ $minute->has_contract ? 'Sí' : 'No' }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                                

                                <!-- Información de Empresa (solo si tiene contrato) -->
                                @if($minute->has_contract)
                                <div class="company-section">
                                    <h4>Información de la Empresa</h4>
                                    <table class="apprentice-table">
                                        <tr>
                                            <td>Empresa</td>
                                            <td>{{ $minute->company_name ?: 'No especificado' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Dirección</td>
                                            <td>{{ $minute->company_address ?: 'No especificado' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Responsable RH</td>
                                            <td>{{ $generalCommittee->hr_responsible ?: 'No especificado' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Contacto Empresa</td>
                                            <td>{{ $generalCommittee->company_contact ?: 'No especificado' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-content">No se encontraron aprendices para esta acta.</div>
                @endif
            </div>
        </div>

        <!-- Información de la Novedad -->
        <div class="section">
            <div class="section-title yellow">INFORMACIÓN DE LA NOVEDAD</div>
            <div class="section-content">
                <h4 style="color: #374151; margin: 0 0 15px 0; font-size: 14px; font-weight: bold;">Novedades por Aprendiz</h4>
                @php
                    $minutes = \App\Models\Minute::where('act_number', $generalCommittee->act_number)->get();
                @endphp
                @if($minutes->count() > 0)
                    @foreach($minutes as $index => $minute)
                        <div class="incident-card">
                            <div class="apprentice-header" style="background-color: #dc2626; color: white;">
                                {{ $minute->trainee_name ?: 'Aprendiz #' . ($index + 1) }}
                            </div>
                            <div class="apprentice-content">
                                <table class="apprentice-table">
                                    <tr>
                                        <td>Tipo de Novedad</td>
                                        <td>
                                            <span class="badge badge-orange">
                                                @php
                                                    $incidentTypeMap = [
                                                        'CANCELACION_MATRICULA_ACADEMICO' => 'CANCELACIÓN MATRÍCULA ÍNDOLE ACADÉMICO',
                                                        'CANCELACION_MATRICULA_DISCIPLINARIO' => 'CANCELACIÓN MATRÍCULA ÍNDOLE DISCIPLINARIO',
                                                        'CONDICIONAMIENTO_MATRICULA' => 'CONDICIONAMIENTO DE MATRÍCULA',
                                                        'DESERCION_PROCESO_FORMACION' => 'DESERCIÓN PROCESO DE FORMACIÓN',
                                                        'NO_GENERACION_CERTIFICADO' => 'NO GENERACIÓN-CERTIFICADO',
                                                        'RETIRO_POR_FRAUDE' => 'RETIRO POR FRAUDE',
                                                        'RETIRO_PROCESO_FORMACION' => 'RETIRO PROCESO DE FORMACIÓN',
                                                        'TRASLADO_CENTRO' => 'TRASLADO DE CENTRO',
                                                        'TRASLADO_JORNADA' => 'TRASLADO DE JORNADA',
                                                        'TRASLADO_PROGRAMA' => 'TRASLADO DE PROGRAMA',
                                                        'Academic' => 'Académica',
                                                        'Disciplinary' => 'Disciplinaria',
                                                        'Dropout' => 'Deserción'
                                                    ];
                                                    $translatedType = $incidentTypeMap[$minute->incident_type ?? ''] ?? $minute->incident_type ?? 'No especificado';
                                                @endphp
                                                {{ $translatedType }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Subtipo de Novedad</td>
                                        <td>
                                            <span class="badge badge-orange">
                                                {{ $minute->incident_subtype ? str_replace('_', ' ', $minute->incident_subtype) : 'No especificado' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Descripción de la Novedad</td>
                                        <td>
                                            <div class="text-content">{{ $minute->incident_description ?: 'No especificado' }}</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-content">No se encontraron novedades para esta acta.</div>
                @endif
            </div>
        </div>

        <!-- Información de la Falta -->
        <div class="section">
            <div class="section-title red">INFORMACIÓN DE LA FALTA</div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>Tipo de Falta</td>
                        <td>
                            <span class="badge {{ $generalCommittee->offense_class == 'Leve' ? 'badge-green' : ($generalCommittee->offense_class == 'Grave' ? 'badge-orange' : 'badge-red') }}">
                                {{ $generalCommittee->offense_class ?: 'No especificado' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Descripción de la Falta</td>
                        <td>
                            <div class="text-content">{{ $generalCommittee->offense_classification ?: 'No especificado' }}</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Descargos -->
        <div class="section">
            <div class="section-title green">DESCARGOS</div>
            <div class="section-content">
                @if($generalCommittee->general_statements)
                    <div style="margin-bottom: 15px;">
                        <strong>Descargo General:</strong>
                        <div class="text-content">{{ $generalCommittee->general_statements }}</div>
                    </div>
                @endif

                @if($generalCommittee->individual_statements)
                    <div>
                        <strong>Descargos Individuales:</strong>
                        @php
                            $individualStatements = json_decode($generalCommittee->individual_statements, true);
                            $minutesById = \App\Models\Minute::where('act_number', $generalCommittee->act_number)->get()->keyBy('minutes_id');
                            $minutesList = $minutesById->values();
                        @endphp
                        @if(is_array($individualStatements))
                            @foreach($individualStatements as $key => $statement)
                                @php
                                    $labelName = null;
                                    if (is_string($key) || is_int($key)) {
                                        $minute = $minutesById[$key] ?? null;
                                        if ($minute) {
                                            $labelName = $minute->trainee_name;
                                        }
                                    }
                                    if (!$labelName && is_numeric($key)) {
                                        $minuteByIndex = $minutesList->get((int)$key);
                                        if ($minuteByIndex) {
                                            $labelName = $minuteByIndex->trainee_name;
                                        }
                                    }
                                    if (!$labelName) {
                                        $labelName = 'Aprendiz ' . (is_numeric($key) ? ((int)$key + 1) : '');
                                    }
                                @endphp
                                <div style="margin-bottom: 10px;">
                                    <strong>{{ $labelName }}:</strong>
                                    <div class="text-content">{{ $statement }}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="section">
            <div class="section-title blue">INFORMACIÓN ADICIONAL</div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>Calificación Faltante</td>
                        <td>
                            <div class="text-content">{{ $generalCommittee->missing_rating ?: 'No especificado' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>Recomendaciones</td>
                        <td>
                            <div class="text-content">{{ $generalCommittee->recommendations ?: 'No especificado' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>Observaciones</td>
                        <td>
                            <div class="text-content">{{ $generalCommittee->observations ?: 'No especificado' }}</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Decisión y Compromisos -->
        <div class="section">
            <div class="section-title yellow">DECISIÓN Y COMPROMISOS</div>
            <div class="section-content">
                <div class="decision-section">
                    <h4>Resolución del Comité</h4>
                    <table class="info-table">
                        <tr>
                            <td>Compromisos</td>
                            <td>
                                <div class="text-content">{{ $generalCommittee->commitments ?: 'No especificado' }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>Decisión</td>
                            <td>
                                <div class="text-content">{{ $generalCommittee->decision ?: 'No especificado' }}</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Documento generado el {{ date('d/m/Y H:i:s') }} - Sistema ComiSoft</p>
        </div>
    </div>
</body>
</html>
