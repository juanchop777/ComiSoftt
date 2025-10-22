<?php

namespace App\Http\Controllers;

use App\Models\FinalMinute;
use Illuminate\Http\Request;

class FinalMinuteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FinalMinute::query();
        
        // Búsqueda por texto (número de acta, comité, ciudad)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('act_number', 'like', "%{$searchTerm}%")
                  ->orWhere('committee_name', 'like', "%{$searchTerm}%")
                  ->orWhere('city', 'like', "%{$searchTerm}%");
            });
        }
        
        // Filtro por fecha
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
        
        $finalMinutes = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());
        
        return view('admin.final-minutes.index', compact('finalMinutes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.final-minutes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'act_number' => 'required|string|max:10',
            'committee_name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'place_link' => 'nullable|string|max:255',
            'address_regional_center' => 'nullable|string|max:255',
            'conclusions' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,xls,xlsx|max:10240'
        ]);

        try {
            // Crear directorio para este acta si no existe
            $actNumber = $request->act_number;
            $folderPath = "final-minutes/{$actNumber}";
            $fullPath = storage_path("app/public/{$folderPath}");
            
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $savedFiles = [];
            
            // Procesar cada archivo adjunto
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $index => $file) {
                    if ($file->isValid()) {
                        // Generar nombre único para el archivo
                        $originalName = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $fileName = time() . '_' . ($index + 1) . '_' . pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;
                        
                        // Guardar el archivo
                        $storedPath = $file->storeAs($folderPath, $fileName, 'public');
                        
                        \Log::info('Archivo guardado', [
                            'original_name' => $originalName,
                            'stored_name' => $fileName,
                            'stored_path' => $storedPath,
                            'folder_path' => $folderPath,
                            'file_size' => $file->getSize()
                        ]);
                        
                        // Verificar que el archivo se guardó correctamente
                        $fullPath = storage_path("app/public/{$folderPath}/{$fileName}");
                        if (file_exists($fullPath)) {
                            \Log::info('Archivo verificado en disco', ['path' => $fullPath]);
                        } else {
                            // Intentar con la ruta que devuelve storeAs
                            $alternativePath = storage_path("app/{$storedPath}");
                            if (file_exists($alternativePath)) {
                                \Log::info('Archivo encontrado en ruta alternativa', ['path' => $alternativePath]);
                            } else {
                                \Log::error('Archivo NO encontrado en ninguna ruta', [
                                    'path1' => $fullPath,
                                    'path2' => $alternativePath,
                                    'stored_path' => $storedPath
                                ]);
                            }
                        }
                        
                        // Guardar información del archivo
                        $savedFiles[] = [
                            'original_name' => $originalName,
                            'stored_name' => $fileName,
                            'path' => "{$folderPath}/{$fileName}",
                            'size' => $file->getSize(),
                            'mime_type' => $file->getMimeType(),
                            'uploaded_at' => now()
                        ];
                    }
                }
            }

            // Crear el registro en la base de datos
            $finalMinute = FinalMinute::create([
                'act_number' => $request->act_number,
                'committee_name' => $request->committee_name,
                'city' => $request->city,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'place_link' => $request->place_link,
                'address_regional_center' => $request->address_regional_center,
                'conclusions' => $request->conclusions,
                'attachments' => $savedFiles
            ]);

            return redirect()->route('final-minutes.index')
                ->with('success', "Acta final #{$actNumber} creada exitosamente con " . count($savedFiles) . " archivo(s) adjunto(s).");

        } catch (\Exception $e) {
            \Log::error('Error al crear acta final: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al guardar el acta. Por favor, intente nuevamente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FinalMinute $finalMinute)
    {
        return view('admin.final-minutes.show', compact('finalMinute'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinalMinute $finalMinute)
    {
        return view('admin.final-minutes.edit', compact('finalMinute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinalMinute $finalMinute)
    {
        $request->validate([
            'act_number' => 'required|string|max:10',
            'committee_name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'place_link' => 'nullable|string|max:255',
            'address_regional_center' => 'nullable|string|max:255',
            'conclusions' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,xls,xlsx|max:10240'
        ]);

        try {
            $updateData = [
                'act_number' => $request->act_number,
                'committee_name' => $request->committee_name,
                'city' => $request->city,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'place_link' => $request->place_link,
                'address_regional_center' => $request->address_regional_center,
                'conclusions' => $request->conclusions,
            ];

            // Si hay nuevos archivos, procesarlos
            if ($request->hasFile('attachments')) {
                $actNumber = $request->act_number;
                $folderPath = "final-minutes/{$actNumber}";
                $fullPath = storage_path("app/public/{$folderPath}");
                
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }

                $savedFiles = [];
                
                foreach ($request->file('attachments') as $index => $file) {
                    if ($file->isValid()) {
                        $originalName = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $fileName = time() . '_' . ($index + 1) . '_' . pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;
                        
                            $file->storeAs($folderPath, $fileName, 'public');
                        
                        $savedFiles[] = [
                            'original_name' => $originalName,
                            'stored_name' => $fileName,
                            'path' => "{$folderPath}/{$fileName}",
                            'size' => $file->getSize(),
                            'mime_type' => $file->getMimeType(),
                            'uploaded_at' => now()
                        ];
                    }
                }

                // Combinar archivos existentes con los nuevos
                $existingFiles = $finalMinute->attachments ?? [];
                $updateData['attachments'] = array_merge($existingFiles, $savedFiles);
            }

            $finalMinute->update($updateData);

            return redirect()->route('final-minutes.index')
                ->with('success', 'Acta final actualizada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al actualizar acta final: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el acta. Por favor, intente nuevamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinalMinute $finalMinute)
    {
        try {
            // Eliminar archivos físicos si existen
            if ($finalMinute->attachments && is_array($finalMinute->attachments)) {
                foreach ($finalMinute->attachments as $attachment) {
                    if (isset($attachment['path'])) {
                        $filePath = storage_path("app/public/{$attachment['path']}");
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                }
                
                // Eliminar directorio si está vacío
                $folderPath = storage_path("app/public/final-minutes/{$finalMinute->act_number}");
                if (is_dir($folderPath) && count(scandir($folderPath)) == 2) { // Solo . y ..
                    rmdir($folderPath);
                }
            }

            $finalMinute->delete();

            return redirect()->route('final-minutes.index')
                ->with('success', 'Acta final eliminada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al eliminar acta final: ' . $e->getMessage());
            return redirect()->route('final-minutes.index')
                ->with('error', 'Error al eliminar el acta. Por favor, intente nuevamente.');
        }
    }

    /**
     * Download a specific attachment file.
     */
    public function downloadAttachment(FinalMinute $finalMinute, $attachmentIndex)
    {
        try {
            $attachments = $finalMinute->attachments;
            
            if (!is_array($attachments) || !isset($attachments[$attachmentIndex])) {
                return redirect()->back()->with('error', 'Archivo no encontrado.');
            }

            $attachment = $attachments[$attachmentIndex];
            
            // Intentar múltiples rutas posibles
            $possiblePaths = [
                storage_path("app/public/{$attachment['path']}"),
                storage_path("app/{$attachment['path']}"),
                storage_path("app/public/final-minutes/{$finalMinute->act_number}/{$attachment['stored_name']}"),
                storage_path("app/private/{$attachment['path']}"),
                storage_path("app/private/final-minutes/{$finalMinute->act_number}/{$attachment['stored_name']}")
            ];
            
            $filePath = null;
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $filePath = $path;
                    break;
                }
            }

            if (!$filePath) {
                return redirect()->back()->with('error', 'El archivo no existe en el servidor.');
            }

            return response()->download($filePath, $attachment['original_name']);

        } catch (\Exception $e) {
            \Log::error('Error al descargar archivo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al descargar el archivo.');
        }
    }

    /**
     * Download all acta data and files as a ZIP archive.
     */
    public function downloadZip(FinalMinute $finalMinute)
    {
        try {
            // Crear archivo ZIP temporal
            $zipFileName = "acta_{$finalMinute->act_number}_" . now()->format('Y-m-d_H-i-s') . '.zip';
            $zipPath = storage_path("app/temp/{$zipFileName}");
            
            // Crear directorio temporal si no existe
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $zip = new \ZipArchive();
            
            if ($zip->open($zipPath, \ZipArchive::CREATE) !== TRUE) {
                return redirect()->back()->with('error', 'No se pudo crear el archivo ZIP.');
            }

            // 1. Agregar archivo de información en formato JSON
            $actaJson = $this->generateActaInfoJson($finalMinute);
            $zip->addFromString("acta_{$finalMinute->act_number}_datos.json", $actaJson);

            // 2. Generar y agregar PDF del acta
            try {
                $pdf = \PDF::loadView('admin.final-minutes.pdf', compact('finalMinute'));
                $pdfContent = $pdf->output();
                $zip->addFromString("acta_{$finalMinute->act_number}_documento.pdf", $pdfContent);
                \Log::info('PDF agregado al ZIP exitosamente', ['act_number' => $finalMinute->act_number]);
            } catch (\Exception $e) {
                \Log::error('Error al generar PDF para ZIP: ' . $e->getMessage());
            }

            // 3. Agregar todos los archivos adjuntos
            $attachmentsAdded = 0;
            if ($finalMinute->attachments && is_array($finalMinute->attachments) && count($finalMinute->attachments) > 0) {
                $zip->addEmptyDir("archivos_adjuntos");
                
                foreach ($finalMinute->attachments as $index => $attachment) {
                    // Intentar múltiples rutas posibles
                    $possiblePaths = [
                        storage_path("app/public/{$attachment['path']}"),
                        storage_path("app/{$attachment['path']}"),
                        storage_path("app/public/final-minutes/{$finalMinute->act_number}/{$attachment['stored_name']}"),
                        storage_path("app/private/{$attachment['path']}"),
                        storage_path("app/private/final-minutes/{$finalMinute->act_number}/{$attachment['stored_name']}")
                    ];
                    
                    $filePath = null;
                    foreach ($possiblePaths as $path) {
                        if (file_exists($path)) {
                            $filePath = $path;
                            break;
                        }
                    }
                    
                    if ($filePath && file_exists($filePath)) {
                        $originalName = $attachment['original_name'];
                        
                        // Leer el contenido del archivo y agregarlo al ZIP
                        $fileContent = file_get_contents($filePath);
                        if ($fileContent !== false) {
                            $success = $zip->addFromString("archivos_adjuntos/{$originalName}", $fileContent);
                            if ($success) {
                                $attachmentsAdded++;
                                \Log::info('Archivo agregado al ZIP exitosamente', [
                                    'original_name' => $originalName,
                                    'file_path' => $filePath,
                                    'file_size' => strlen($fileContent)
                                ]);
                            }
                        }
                    } else {
                        \Log::warning('Archivo no encontrado para ZIP', [
                            'attachment' => $attachment,
                            'possible_paths' => $possiblePaths
                        ]);
                    }
                }
            }

            // 4. Agregar archivo README con instrucciones
            $readme = $this->generateReadmeContent($finalMinute, $attachmentsAdded);
            $zip->addFromString("README.txt", $readme);

            $zip->close();

            // Verificar que el ZIP se creó correctamente
            if (file_exists($zipPath)) {
                $zipSize = filesize($zipPath);
                
                // Descargar el archivo ZIP
                return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
            } else {
                return redirect()->back()->with('error', 'Error al crear el archivo ZIP.');
            }

        } catch (\Exception $e) {
            \Log::error('Error al crear ZIP: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al crear el archivo comprimido: ' . $e->getMessage());
        }
    }

    /**
     * Generate HTML content with acta information.
     */
    private function generateActaInfoHtml(FinalMinute $finalMinute)
    {
        $html = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acta de Reunión #' . $finalMinute->act_number . '</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
        .header { background: #2563eb; color: white; padding: 20px; text-align: center; border-radius: 8px; margin-bottom: 30px; }
        .section { margin-bottom: 25px; padding: 15px; border: 1px solid #e5e7eb; border-radius: 8px; }
        .label { font-weight: bold; color: #374151; }
        .value { margin-top: 5px; }
        .attachments { background: #f9fafb; }
        .attachment-item { background: white; margin: 10px 0; padding: 10px; border-radius: 4px; border: 1px solid #d1d5db; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ACTA DE REUNIÓN #' . $finalMinute->act_number . '</h1>
        <h2>' . $finalMinute->committee_name . '</h2>
    </div>

    <div class="section">
        <h3>Información General</h3>
        <p><span class="label">Ciudad:</span> <span class="value">' . $finalMinute->city . '</span></p>
        <p><span class="label">Fecha:</span> <span class="value">' . $finalMinute->date->format('d/m/Y') . '</span></p>
        <p><span class="label">Horario:</span> <span class="value">' . $finalMinute->start_time . ' - ' . $finalMinute->end_time . '</span></p>
    </div>';

        if ($finalMinute->place_link) {
            $html .= '<div class="section">
                <h3>Ubicación</h3>
                <p><span class="label">Lugar/Enlace:</span> <span class="value">' . $finalMinute->place_link . '</span></p>';
        }

        if ($finalMinute->address_regional_center) {
            $html .= '<p><span class="label">Dirección/Centro:</span> <span class="value">' . $finalMinute->address_regional_center . '</span></p>';
        }

        $html .= '</div>';

        if ($finalMinute->conclusions) {
            $html .= '<div class="section">
                <h3>Conclusiones</h3>
                <p>' . nl2br(e($finalMinute->conclusions)) . '</p>
            </div>';
        }

        if ($finalMinute->attachments && count($finalMinute->attachments) > 0) {
            $html .= '<div class="section attachments">
                <h3>Archivos Adjuntos (' . count($finalMinute->attachments) . ')</h3>';
            
            foreach ($finalMinute->attachments as $attachment) {
                $html .= '<div class="attachment-item">
                    <p><strong>' . $attachment['original_name'] . '</strong></p>
                    <p>Tamaño: ' . number_format($attachment['size'] / 1024, 1) . ' KB</p>
                    <p>Subido: ' . \Carbon\Carbon::parse($attachment['uploaded_at'])->format('d/m/Y H:i') . '</p>
                </div>';
            }
            
            $html .= '</div>';
        }

        $html .= '</body></html>';
        
        return $html;
    }

    /**
     * Generate JSON content with acta information.
     */
    private function generateActaInfoJson(FinalMinute $finalMinute)
    {
        $data = [
            'acta_info' => [
                'act_number' => $finalMinute->act_number,
                'committee_name' => $finalMinute->committee_name,
                'city' => $finalMinute->city,
                'date' => $finalMinute->date->format('Y-m-d'),
                'start_time' => $finalMinute->start_time,
                'end_time' => $finalMinute->end_time,
                'place_link' => $finalMinute->place_link,
                'address_regional_center' => $finalMinute->address_regional_center,
                'conclusions' => $finalMinute->conclusions,
                'created_at' => $finalMinute->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $finalMinute->updated_at->format('Y-m-d H:i:s')
            ],
            'attachments' => $finalMinute->attachments ?? [],
            'export_info' => [
                'exported_at' => now()->format('Y-m-d H:i:s'),
                'exported_by' => 'Sistema ComiSoftt',
                'version' => '1.0'
            ]
        ];

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Generate README content with instructions.
     */
    private function generateReadmeContent(FinalMinute $finalMinute, $attachmentsAdded = 0)
    {
        $attachmentCount = $finalMinute->attachments ? count($finalMinute->attachments) : 0;
        
        return "ACTA DE REUNIÓN #{$finalMinute->act_number}
========================================

INFORMACIÓN DEL ACTA:
- Número: {$finalMinute->act_number}
- Comité/Reunión: {$finalMinute->committee_name}
- Ciudad: {$finalMinute->city}
- Fecha: {$finalMinute->date->format('d/m/Y')}
- Horario: {$finalMinute->start_time} - {$finalMinute->end_time}
- Archivos adjuntos en BD: {$attachmentCount}
- Archivos incluidos en ZIP: {$attachmentsAdded}

ARCHIVOS INCLUIDOS:
==================
1. acta_{$finalMinute->act_number}_informacion.html - Información completa en formato HTML
2. acta_{$finalMinute->act_number}_datos.json - Datos estructurados en formato JSON
3. archivos_adjuntos/ - Carpeta con todos los documentos adjuntos ({$attachmentsAdded} archivos)
4. README.txt - Este archivo con instrucciones

INSTRUCCIONES:
=============
- Para ver la información completa, abra el archivo HTML en su navegador
- Los datos JSON pueden ser importados en otros sistemas
- Los archivos adjuntos están organizados en la carpeta 'archivos_adjuntos'
- Este archivo fue generado automáticamente por el Sistema ComiSoftt

NOTA: Si la carpeta 'archivos_adjuntos' está vacía, significa que los archivos
originales no se encontraron en el servidor o no se guardaron correctamente.

Fecha de exportación: " . now()->format('d/m/Y H:i:s') . "
Sistema: ComiSoftt - Gestión de Actas de Reunión";
    }
}
