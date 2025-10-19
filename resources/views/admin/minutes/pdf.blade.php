<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acta de Novedades - {{ $actNumber }}</title>
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
            font-size: 18px;
            margin: 5px 0 0 0;
        }
        
        .header h3 {
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
        
        .section-title.gray {
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
            margin-bottom: 15px;
            table-layout: fixed;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .info-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
            word-wrap: break-word;
            white-space: normal;
            overflow-wrap: break-word;
            overflow: visible;
            height: auto;
            min-height: 35px;
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
        
        .subsection {
            margin-bottom: 20px;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .subsection-title {
            color: #374151;
            margin: 0 0 10px 0;
            font-size: 13px;
            font-weight: bold;
            background-color: #f3f4f6;
            padding: 8px 12px;
            border-radius: 4px;
            border-left: 4px solid #3b82f6;
        }
        
        .incident-section {
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .incident-section h4 {
            color: #374151;
            margin: 0 0 15px 0;
            font-size: 14px;
            font-weight: bold;
            background-color: #f3f4f6;
            padding: 8px 12px;
            border-radius: 4px;
        }
        
        .incident-details {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 15px;
            margin: 12px 0;
            page-break-inside: avoid;
            break-inside: avoid;
            min-height: 40px;
            overflow: visible;
            word-wrap: break-word;
            white-space: normal;
            overflow-wrap: break-word;
        }
        
        .incident-details h5 {
            color: #374151;
            margin: 0 0 10px 0;
            font-size: 12px;
            font-weight: bold;
            display: block;
        }
        
        .incident-details p {
            margin: 0;
            color: #1f2937;
            font-size: 11px;
            line-height: 1.5;
            word-wrap: break-word;
            white-space: normal;
            overflow-wrap: break-word;
            display: block;
            width: 100%;
            hyphens: auto;
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
            size: A4;
        }
        
        /* Cada aprendiz en una página completa */
        .apprentice-page {
            page-break-before: always;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        /* Ajustar márgenes para mejor distribución */
        .apprentice-page .section-content {
            padding: 20px;
        }
        
        /* Espaciado entre subsecciones */
        .subsection + .subsection {
            margin-top: 25px;
        }
        
        /* Asegurar que toda la sección Novedad quede junta */
        .novedad-complete {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            page-break-before: avoid !important;
            break-before: avoid !important;
            page-break-after: avoid !important;
            break-after: avoid !important;
        }
        
        .novedad-content {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        
        /* Evitar que el título se separe del contenido */
        .novedad-complete .subsection-title {
            page-break-after: avoid !important;
            break-after: avoid !important;
        }
        
        /* Asegurar que los detalles de novedad queden juntos */
        .novedad-content .incident-details {
            page-break-before: avoid !important;
            break-before: avoid !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        
        /* Forzar que toda la sección novedad esté en una sola página */
        .novedad-complete {
            display: block !important;
            position: relative !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SERVICIO NACIONAL DE APRENDIZAJE</h1>
            <h2>CENTRO DE FORMACIÓN AGROINDUSTRIAL</h2>
            <h3>CONSOLIDADO DE NOVEDADES ACADÉMICAS Y DISCIPLINARIAS</h3>
        </div>

        <!-- Información del Acta -->
        <div class="section">
            <div class="section-title blue">INFORMACIÓN DEL ACTA</div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>Número de Acta</td>
                        <td>#{{ $actNumber }}</td>
                    </tr>
                    <tr>
                        <td>Fecha del Acta</td>
                        <td>{{ $minutes->first()->minutes_date ? \Carbon\Carbon::parse($minutes->first()->minutes_date)->format('d/m/Y') : 'No especificada' }}</td>
                    </tr>
                    <tr>
                        <td>Centro de Formación</td>
                        <td>{{ $minutes->first()->training_center ?? 'No especificado' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Información de la Persona que Reporta -->
        @if($reportingPerson)
        <div class="section">
            <div class="section-title blue">PERSONA QUE REPORTA</div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>Nombre Completo</td>
                        <td>{{ $reportingPerson->full_name }}</td>
                    </tr>
                    <tr>
                        <td>Correo Electrónico</td>
                        <td>{{ $reportingPerson->email }}</td>
                    </tr>
                    <tr>
                        <td>Teléfono</td>
                        <td>{{ $reportingPerson->phone ?? 'No especificado' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        @endif

        <!-- Información de los Aprendices -->
        @foreach($minutes as $index => $minute)
        <div class="section apprentice-page" style="page-break-before: always; page-break-inside: avoid; break-inside: avoid;">
            <div class="section-title green">INFORMACIÓN DEL APRENDIZ #{{ $index + 1 }}</div>
            <div class="section-content">
                <!-- Información Personal del Aprendiz -->
                <div class="subsection">
                    <h4 class="subsection-title">Datos Personales</h4>
                    <table class="info-table">
                        <tr>
                            <td>Nombre del Aprendiz</td>
                            <td>{{ $minute->trainee_name }}</td>
                        </tr>
                        <tr>
                            <td>Teléfono del Aprendiz</td>
                            <td>{{ $minute->trainee_phone ?? 'No especificado' }}</td>
                        </tr>
                        <tr>
                            <td>Tipo de Documento</td>
                            <td>{{ $minute->document_type ?? 'No especificado' }}</td>
                        </tr>
                        <tr>
                            <td>Número de Documento</td>
                            <td>{{ $minute->id_document }}</td>
                        </tr>
                        @if($minute->email)
                        <tr>
                            <td>Correo del Aprendiz</td>
                            <td>{{ $minute->email }}</td>
                        </tr>
                        @endif
                    </table>
                </div>

                <!-- Información Académica -->
                <div class="subsection">
                    <h4 class="subsection-title">Información Académica</h4>
                    <table class="info-table">
                        <tr>
                            <td>Programa de Formación</td>
                            <td>{{ $minute->program_name }}</td>
                        </tr>
                        <tr>
                            <td>Número de Ficha</td>
                            <td>{{ $minute->batch_number }}</td>
                        </tr>
                        <tr>
                            <td>Tipo de Programa</td>
                            <td>{{ $minute->program_type ?? 'No especificado' }}</td>
                        </tr>
                        <tr>
                            <td>Estado del Aprendiz</td>
                            <td>{{ $minute->trainee_status ?? 'No especificado' }}</td>
                        </tr>
                        <tr>
                            <td>¿Tiene Contrato?</td>
                            <td>{{ $minute->has_contract ? 'Sí' : 'No' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Información de la Empresa (si tiene contrato) -->
                @if($minute->has_contract)
                <div class="subsection">
                    <h4 class="subsection-title">Información de la Empresa</h4>
                    <table class="info-table">
                        <tr>
                            <td>Nombre de la Empresa</td>
                            <td>{{ $minute->company_name ?? 'No especificado' }}</td>
                        </tr>
                        <tr>
                            <td>Dirección</td>
                            <td>{{ $minute->company_address ?? 'No especificado' }}</td>
                        </tr>
                        <tr>
                            <td>Responsable RH</td>
                            <td>{{ $minute->hr_manager_name ?? 'No especificado' }}</td>
                        </tr>
                        <tr>
                            <td>Contacto</td>
                            <td>{{ $minute->company_contact ?? 'No especificado' }}</td>
                        </tr>
                    </table>
                </div>
                @endif

            </div>
        </div>

        <!-- Información de la Novedad - Fuera de la card del aprendiz -->
        <div class="section" style="page-break-inside: avoid; break-inside: avoid;">
            <div class="section-title blue">NOVEDAD</div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>Tipo de Novedad</td>
                        <td>
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
                                    'TRASLADO_PROGRAMA' => 'TRASLADO DE PROGRAMA',
                                ];
                            @endphp
                            {{ $incidentTypes[$minute->incident_type] ?? $minute->incident_type }}
                        </td>
                    </tr>
                    @if($minute->incident_subtype)
                    <tr>
                        <td>Subtipo de Novedad</td>
                        <td>{{ str_replace('_', ' ', $minute->incident_subtype) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Descripción</td>
                        <td>
                            <div class="text-content">{{ $minute->incident_description }}</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        @endforeach

        <div class="footer">
            <p>Documento generado el {{ date('d/m/Y H:i:s') }} - Sistema ComiSoft</p>
        </div>
    </div>
</body>
</html>