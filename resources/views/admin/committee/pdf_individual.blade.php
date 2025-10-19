<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comité Individual - {{ $individualCommittee->trainee_name }}</title>
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
            background-color: #3b82f6;
            color: white;
            border-radius: 8px;
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
        
        .section:last-child {
            margin-bottom: 5px;
        }
        
        .section-title {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 12px 15px;
            font-weight: bold;
            font-size: 14px;
            margin: 0;
        }
        
        .section-title.blue {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .section-title.green {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .section-title.yellow {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .section-title.red {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .section-title.purple {
            background-color: #e9d5ff;
            color: #7c3aed;
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
        }
        
        .badge-blue {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .badge-green {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .badge-red {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .badge-orange {
            background-color: #fed7aa;
            color: #ea580c;
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
        
        .company-section {
            background-color: #f0fdf4;
            border: 2px solid #10b981;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .company-section h4 {
            color: #166534;
            margin: 0 0 15px 0;
            font-size: 14px;
            font-weight: bold;
        }
        
        .decision-section {
            background-color: #fefce8;
            border: 2px solid #f59e0b;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .decision-section h4 {
            color: #92400e;
            margin: 0 0 15px 0;
            font-size: 14px;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
            page-break-before: avoid;
            page-break-inside: avoid;
            break-before: avoid;
            break-inside: avoid;
        }
        
        @page {
            margin: 1cm;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>COMITÉ INDIVIDUAL</h1>
            <h2>Acta #{{ $individualCommittee->act_number }}</h2>
        </div>

        <!-- Información de la Sesión -->
        <div class="section">
            <div class="section-title blue">INFORMACIÓN DE LA SESIÓN</div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>Fecha de Sesión</td>
                        <td>{{ $individualCommittee->session_date }}</td>
                    </tr>
                    <tr>
                        <td>Hora de Sesión</td>
                        <td>{{ $individualCommittee->session_time }}</td>
                    </tr>
                    <tr>
                        <td>Modalidad de Asistencia</td>
                        <td><span class="badge badge-blue">{{ $individualCommittee->attendance_mode }}</span></td>
                    </tr>
                    @if($individualCommittee->attendance_mode == 'Virtual' && $individualCommittee->access_link)
                    <tr>
                        <td>Enlace de Acceso</td>
                        <td>{{ $individualCommittee->access_link }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Información del Aprendiz -->
        <div class="section">
            <div class="section-title green">INFORMACIÓN DEL APRENDIZ</div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>Nombre del Aprendiz</td>
                        <td>{{ $individualCommittee->trainee_name }}</td>
                    </tr>
                    <tr>
                        <td>Tipo de Documento</td>
                        <td>{{ $individualCommittee->document_type ?: 'No especificado' }}</td>
                    </tr>
                    <tr>
                        <td>Número de Documento</td>
                        <td>{{ $individualCommittee->id_document }}</td>
                    </tr>
                    <tr>
                        <td>Teléfono del Aprendiz</td>
                        <td>{{ $individualCommittee->trainee_phone ?: 'No especificado' }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $individualCommittee->email }}</td>
                    </tr>
                    <tr>
                        <td>Programa de Formación</td>
                        <td>{{ $individualCommittee->program_name }}</td>
                    </tr>
                    <tr>
                        <td>Número de Ficha</td>
                        <td>{{ $individualCommittee->batch_number }}</td>
                    </tr>
                    <tr>
                        <td>Tipo de Programa</td>
                        <td>{{ $individualCommittee->program_type ?: 'No especificado' }}</td>
                    </tr>
                    <tr>
                        <td>Estado del Aprendiz</td>
                        <td>{{ $individualCommittee->trainee_status ?: 'No especificado' }}</td>
                    </tr>
                    <tr>
                        <td>Centro de Formación</td>
                        <td>{{ $individualCommittee->training_center ?: 'No especificado' }}</td>
                    </tr>
                    <tr>
                        <td>¿Tiene Contrato?</td>
                        <td>
                            @if($individualCommittee->minutes && $individualCommittee->minutes->has_contract)
                                <span class="badge badge-green">Sí</span>
                            @else
                                <span class="badge badge-red">No</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Información de la Empresa (si tiene contrato) -->
        @if($individualCommittee->minutes && $individualCommittee->minutes->has_contract)
        <div class="section">
            <div class="section-title green">INFORMACIÓN DE LA EMPRESA</div>
            <div class="section-content">
                <div class="company-section">
                    <h4>Datos de la Empresa</h4>
                    <table class="info-table">
                        <tr>
                            <td>Nombre de la Empresa</td>
                            <td>{{ $individualCommittee->company_name }}</td>
                        </tr>
                        <tr>
                            <td>Dirección de la Empresa</td>
                            <td>{{ $individualCommittee->company_address }}</td>
                        </tr>
                        <tr>
                            <td>Contacto de la Empresa</td>
                            <td>{{ $individualCommittee->company_contact ?? $individualCommittee->hr_contact ?? 'No especificado' }}</td>
                        </tr>
                        <tr>
                            <td>RRHH Responsable</td>
                            <td>{{ $individualCommittee->hr_responsible ?? 'No especificado' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Información de la Novedad -->
        <div class="section">
            <div class="section-title yellow">INFORMACIÓN DE LA NOVEDAD</div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>Tipo de Novedad</td>
                        <td>
                            <span class="badge badge-orange">
                                @php
                                    $incidentTypes = [
                                        'CANCELACION_MATRICULA_ACADEMICO' => 'CANCELACIÓN MATRÍCULA ÍNDOLE ACADÉMICO',
                                        'CANCELACION_MATRICULA_DISCIPLINARIO' => 'CANCELACIÓN MATRÍCULA ÍNDOLE DISCIPLINARIO',
                                        'CONDICIONAMIENTO_MATRICULA' => 'CONDICIONAMIENTO DE MATRÍCULA',
                                        'DESERCION_PROCESO_FORMACION' => 'DESERCIÓN PROCESO DE FORMACIÓN',
                                        'NO_GENERACION_CERTIFICADO' => 'NO GENERACIÓN-CERTIFICADO',
                                        'RETIRO_POR_FRAUDE' => 'RETIRO POR FRAUDE',
                                        'RETIRO_PROCESO_FORMACION' => 'RETIRO PROCESO DE FORMACIÓN',
                                        'TRASLADO_CENTRO' => 'TRASLADO DE CENTRO',
                                        'TRASLADO_JORNADA' => 'TRASLADO DE JORNADA',
                                        'TRASLADO_PROGRAMA' => 'TRASLADO DE PROGRAMA'
                                    ];
                                @endphp
                                {{ $incidentTypes[$individualCommittee->incident_type] ?? $individualCommittee->incident_type }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Subtipo de Novedad</td>
                        <td>
                            <span class="badge badge-blue">
                                {{ $individualCommittee->incident_subtype ? str_replace('_', ' ', $individualCommittee->incident_subtype) : 'No especificado' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Descripción de la Novedad</td>
                        <td>
                            <div class="text-content">{{ $individualCommittee->incident_description }}</div>
                        </td>
                    </tr>
                </table>
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
                            <span class="badge 
                                @if($individualCommittee->offense_class == 'Leve') badge-green
                                @elseif($individualCommittee->offense_class == 'Grave') badge-orange
                                @elseif($individualCommittee->offense_class == 'Gravísimo') badge-red
                                @else badge-blue @endif">
                                {{ $individualCommittee->offense_class ?: 'No especificado' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Descripción de la Falta</td>
                        <td>
                            <div class="text-content">{{ $individualCommittee->offense_classification ?: 'No especificado' }}</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Descargos del Aprendiz -->
        <div class="section">
            <div class="section-title purple">DESCARGOS DEL APRENDIZ</div>
            <div class="section-content">
                <div class="text-content">{{ $individualCommittee->statement ?: 'No se registraron descargos' }}</div>
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
                            <div class="text-content">{{ $individualCommittee->missing_rating ?: 'No especificado' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>Recomendaciones</td>
                        <td>
                            <div class="text-content">{{ $individualCommittee->recommendations ?: 'No especificado' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>Observaciones</td>
                        <td>
                            <div class="text-content">{{ $individualCommittee->observations ?: 'No especificado' }}</div>
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
                                <div class="text-content">{{ $individualCommittee->commitments ?: 'No especificado' }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>Decisión</td>
                            <td>
                                <div class="text-content">{{ $individualCommittee->decision ?: 'No especificado' }}</div>
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
