<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acta Final #{{ $finalMinute->act_number }}</title>
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
        
        .section:last-child {
            margin-bottom: 5px;
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
            overflow-wrap: break-word;
        }
        
        .info-table td:first-child {
            width: 30%;
            font-weight: bold;
            background-color: #f9fafb;
            color: #374151;
        }
        
        .info-table td:last-child {
            width: 70%;
            color: #1f2937;
        }
        
        .info-table tr:last-child td {
            border-bottom: none;
        }
        
        .conclusions-content {
            padding: 15px;
            background-color: #ffffff;
            white-space: pre-wrap;
            line-height: 1.6;
            color: #1f2937;
        }
        
        .attachments-list {
            padding: 15px;
            background-color: #ffffff;
        }
        
        .attachment-item {
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
        }
        
        .attachment-item:last-child {
            border-bottom: none;
        }
        
        .attachment-icon {
            margin-right: 10px;
            color: #dc2626;
            font-size: 16px;
        }
        
        .attachment-details {
            flex: 1;
        }
        
        .attachment-name {
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 2px;
        }
        
        .attachment-meta {
            font-size: 11px;
            color: #6b7280;
        }
        
        .legal-footer {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            text-align: justify;
            color: #374151;
            font-size: 11px;
            line-height: 1.5;
            page-break-before: avoid;
            break-before: avoid;
        }
        
        .legal-footer strong {
            color: #1f2937;
        }
        
        @media print {
            body { margin: 0; padding: 15px; }
            .header { page-break-inside: avoid; }
            .section { page-break-inside: avoid; }
            .info-table { page-break-inside: avoid; }
            .legal-footer { 
                page-break-inside: avoid;
                page-break-before: avoid;
                break-before: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Acta Final #{{ $finalMinute->act_number }}</h1>
            <h2>{{ $finalMinute->committee_name }}</h2>
        </div>
        
        <!-- Información General -->
        <div class="section">
            <div class="section-title">Información General</div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <td>Comité/Reunión:</td>
                        <td>{{ $finalMinute->committee_name }}</td>
                    </tr>
                    <tr>
                        <td>Ciudad:</td>
                        <td>{{ $finalMinute->city }}</td>
                    </tr>
                    <tr>
                        <td>Fecha:</td>
                        <td>{{ $finalMinute->date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Horario:</td>
                        <td>{{ $finalMinute->start_time->format('g:i A') }} - {{ $finalMinute->end_time->format('g:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Ubicación -->
        <div class="section">
            <div class="section-title">Ubicación</div>
            <div class="section-content">
                <table class="info-table">
                    @if($finalMinute->place_link)
                    <tr>
                        <td>Lugar/Enlace:</td>
                        <td>{{ $finalMinute->place_link }}</td>
                    </tr>
                    @endif
                    @if($finalMinute->address_regional_center)
                    <tr>
                        <td>Dirección/Centro:</td>
                        <td>{{ $finalMinute->address_regional_center }}</td>
                    </tr>
                    @endif
                    @if(!$finalMinute->place_link && !$finalMinute->address_regional_center)
                    <tr>
                        <td>Información:</td>
                        <td>No hay información de ubicación</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
        
        <!-- Conclusiones -->
        @if($finalMinute->conclusions)
        <div class="section">
            <div class="section-title">Conclusiones</div>
            <div class="conclusions-content">{{ $finalMinute->conclusions }}</div>
        </div>
        @endif
        
        <!-- Archivos Adjuntos -->
        @if($finalMinute->attachments && count($finalMinute->attachments) > 0)
        <div class="section">
            <div class="section-title">Archivos Adjuntos ({{ count($finalMinute->attachments) }})</div>
            <div class="attachments-list">
                @foreach($finalMinute->attachments as $index => $attachment)
                <div class="attachment-item">
                    <div class="attachment-details">
                        <div class="attachment-name">{{ $attachment['original_name'] }}</div>
                        <div class="attachment-meta">{{ number_format($attachment['size'] / 1024, 1) }} KB - {{ \Carbon\Carbon::parse($attachment['uploaded_at'])->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Pie de Página Legal -->
        <div class="legal-footer">
            <p><strong>De acuerdo con La Ley 1581 de 2012, Protección de Datos Personales,</strong> el Servicio Nacional de Aprendizaje SENA, se compromete a garantizar la seguridad y protección de los datos personales que se encuentran almacenados en este documento, y les dará el tratamiento correspondiente en cumplimiento de lo establecido legalmente.</p>
        </div>
    </div>
</body>
</html>
