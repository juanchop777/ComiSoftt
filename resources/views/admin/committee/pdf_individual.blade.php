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
            <h1>COMITÉ INDIVIDUAL</h1>
            <h2>Acta #{{ $individualCommittee->act_number }}</h2>
        </div>

        <!-- Información Básica -->
        <div class="section">
            <div class="section-title blue">INFORMACIÓN BÁSICA</div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>Fecha de Sesión</td>
                        <td>{{ $individualCommittee->session_date }} {{ $individualCommittee->session_time }}</td>
                    </tr>
                    <tr>
                        <td>Número de Acta</td>
                        <td>#{{ $individualCommittee->act_number }}</td>
                    </tr>
                    <tr>
                        <td>Fecha del Acta</td>
                        <td>{{ $individualCommittee->minutes_date }}</td>
                    </tr>
                    <tr>
                        <td>Modalidad de Asistencia</td>
                        <td><span class="badge badge-blue">{{ $individualCommittee->attendance_mode }}</span></td>
                    </tr>
                    <tr>
                        <td>Tipo de Falta</td>
                        <td>{{ $individualCommittee->offense_class }}</td>
                    </tr>
                    <tr>
                        <td>Descripción de la Falta</td>
                        <td>{{ $individualCommittee->offense_classification }}</td>
                    </tr>
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
                        <td>Documento de Identidad</td>
                        <td>{{ $individualCommittee->id_document }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $individualCommittee->email }}</td>
                    </tr>
                    <tr>
                        <td>Programa</td>
                        <td>{{ $individualCommittee->program_name }}</td>
                    </tr>
                    <tr>
                        <td>Número de Ficha</td>
                        <td>{{ $individualCommittee->batch_number }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Información de la Novedad -->
        <div class="section">
            <div class="section-title yellow">INFORMACIÓN DE LA NOVEDAD</div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>Tipo de Novedad</td>
                        <td>
                            <span class="badge badge-orange">
                                @if($individualCommittee->incident_type == 'Academic')
                                    Académica
                                @elseif($individualCommittee->incident_type == 'Disciplinary')
                                    Disciplinaria
                                @elseif($individualCommittee->incident_type == 'Other')
                                    Otra
                                @else
                                    {{ $individualCommittee->incident_type }}
                                @endif
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

        <!-- Información de la Empresa (si tiene contrato) -->
        @if($individualCommittee->minutes && $individualCommittee->minutes->has_contract)
        <div class="section" style="page-break-before: always;">
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

        <!-- Descargos del Aprendiz -->
        <div class="section">
            <div class="section-title green">DESCARGOS DEL APRENDIZ</div>
            <div class="section-content">
                <div class="text-content">{{ $individualCommittee->statement }}</div>
            </div>
        </div>

        <!-- Decisión del Comité -->
        <div class="section">
            <div class="section-title yellow">DECISIÓN DEL COMITÉ</div>
            <div class="section-content">
                <div class="decision-section">
                    <h4>Resolución del Comité</h4>
                    <table class="info-table">
                        <tr>
                            <td>Decisión</td>
                            <td>
                                <div class="text-content">{{ $individualCommittee->decision }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>Compromisos</td>
                            <td>
                                <div class="text-content">{{ $individualCommittee->commitments }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>Calificación Faltante</td>
                            <td>
                                <div class="text-content">{{ $individualCommittee->missing_rating }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>Recomendaciones</td>
                            <td>
                                <div class="text-content">{{ $individualCommittee->recommendations }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>Observaciones</td>
                            <td>
                                <div class="text-content">{{ $individualCommittee->observations }}</div>
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
