<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acta #{{ $actNumber }}</title>
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
            margin-bottom: 10px;
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
        
        .section-content {
            padding: 10px;
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
            padding: 8px 12px;
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
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            margin-top: 3px;
            word-wrap: break-word;
            white-space: normal;
            overflow-wrap: break-word;
            min-height: 40px;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .apprentice-card {
            border: 1px solid #e5e7eb;
            margin-bottom: 10px;
            border-radius: 8px;
            overflow: hidden;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .apprentice-header {
            background-color: #10b981;
            color: white;
            padding: 12px 15px;
            font-weight: bold;
            font-size: 12px;
        }
        
        .apprentice-content {
            padding: 10px;
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
            background-color: #f0fdf4;
            border: 2px solid #10b981;
            border-radius: 8px;
            padding: 10px;
            margin: 10px 0;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .company-section h4 {
            color: #166534;
            margin: 0 0 10px 0;
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
            <h1>ACTA DE NOVEDADES</h1>
            <h2>Acta #{{ $actNumber }}</h2>
        </div>

        <!-- Información Básica -->
        <div class="section">
            <div class="section-title blue">INFORMACIÓN BÁSICA</div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>Número de Acta</td>
                        <td>#{{ $actNumber }}</td>
                    </tr>
                    <tr>
                        <td>Fecha del Acta</td>
                        <td>{{ \Carbon\Carbon::parse($minutesDate)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Cantidad de Aprendices</td>
                        <td>{{ $minutes->count() }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Información de la Persona que Reporta -->
        @if($reportingPerson)
        <div class="section">
            <div class="section-title green">INFORMACIÓN DE LA PERSONA QUE REPORTA</div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>Nombre Completo</td>
                        <td>{{ $reportingPerson->full_name }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $reportingPerson->email }}</td>
                    </tr>
                    <tr>
                        <td>Teléfono</td>
                        <td>{{ $reportingPerson->phone ?: 'No especificado' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        @endif

        <!-- Información de los Aprendices -->
        <div class="section">
            <div class="section-title green">INFORMACIÓN DE LOS APRENDICES</div>
            <div class="section-content">
                @foreach($minutes as $index => $minute)
                    <div class="apprentice-card" @if($minute->has_contract) style="page-break-before: always;" @endif>
                        <div class="apprentice-header">
                            Aprendiz #{{ $index + 1 }} - {{ $minute->trainee_name }}
                        </div>
                        <div class="apprentice-content">
                            <table class="apprentice-table">
                                <tr>
                                    <td>Documento</td>
                                    <td>{{ $minute->id_document ?: 'No especificado' }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{ $minute->email ?: 'No especificado' }}</td>
                                </tr>
                                <tr>
                                    <td>Programa</td>
                                    <td>{{ $minute->program_name ?: 'No especificado' }}</td>
                                </tr>
                                <tr>
                                    <td>Ficha</td>
                                    <td>{{ $minute->batch_number ?: 'No especificado' }}</td>
                                </tr>
                                <tr>
                                    <td>Contrato</td>
                                    <td>
                                        <span class="badge {{ $minute->has_contract ? 'badge-green' : 'badge-red' }}">
                                            {{ $minute->has_contract ? 'Sí' : 'No' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tipo Novedad</td>
                                    <td>
                                        <span class="badge badge-orange">
                                            @php
                                                $incidentTypeMap = [
                                                    'Academic' => 'Académica',
                                                    'Disciplinary' => 'Disciplinaria', 
                                                    'Dropout' => 'Deserción'
                                                ];
                                                $translatedType = $incidentTypeMap[$minute->incident_type] ?? $minute->incident_type;
                                            @endphp
                                            {{ $translatedType ?: 'No especificado' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                            
                            @if($minute->incident_description)
                            <div style="margin: 10px 0;">
                                <strong>Descripción:</strong>
                                <div class="text-content">{{ $minute->incident_description }}</div>
                            </div>
                            @endif

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
                                        <td>{{ $minute->hr_manager_name ?: 'No especificado' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Contacto Empresa</td>
                                        <td>{{ $minute->company_contact ?: 'No especificado' }}</td>
                                    </tr>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="footer">
            <p>Documento generado el {{ date('d/m/Y H:i:s') }} - Sistema ComiSoft</p>
        </div>
    </div>
</body>
</html>
