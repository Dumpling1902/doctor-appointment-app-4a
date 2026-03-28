<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\User;
use App\Models\Patient;
use App\Models\BloodType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportPatientsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle(): void
    {
        $path = Storage::path($this->filePath);
        if (!file_exists($path)) {
            Log::error('Archivo no encontrado: ' . $path);
            return;
        }

        try {
            Log::info("Iniciando importación .xlsx/.csv vía SimpleExcel: " . $path);

            // 1. Lector Inteligente: Soporta XLSX y CSV. 
            // Procesa en streaming, usando 0% problemas de memoria.
            $reader = SimpleExcelReader::create($path);
            
            // 2. Normalizar encabezados (quitar espacios a snake_case) 
            // ej. "Correo Electronico" -> "correo_electronico"
            $reader->useHeaders(array_map(function ($header) {
                return trim(strtolower(str_replace(' ', '_', $header)));
            }, $reader->getHeaders()));

            $read = 0;
            $inserted = 0;
            $failures = 0;
            $errors = 0;
            
            // 3. getRows() emite y descarta filas automáticamente preservando la RAM
            $reader->getRows()->each(function(array $row) use (&$read, &$inserted, &$failures, &$errors) {
                $read++;

                // 4. Validación Fina (Mismo resultado que SkipsOnFailure)
                $validator = Validator::make($row, [
                    'correo' => 'required|email',
                    'nombre_completo' => 'required|string|min:3',
                ]);

                if ($validator->fails()) {
                    Log::warning("Fila {$read} rechazada (Validación de formato): " . implode(' - ', $validator->messages()->all()));
                    $failures++;
                    return; // Retornar pasa a la siguiente fila
                }

                try {
                    $email = trim($row['correo']);
                    $name = trim($row['nombre_completo']);

                    $user = User::where('email', $email)->first();

                    if (!$user) {
                        $user = User::create([
                            'name' => $name,
                            'email' => $email,
                            'password' => Hash::make('password123'),
                            'id_number' => 'ID-' . Str::random(8),
                            'phone' => trim($row['telefono'] ?? ''),
                            'address' => 'No especificada', 
                        ]);
                        try { $user->assignRole('Paciente'); } catch (\Exception $e) {}
                    }

                    // Tipo de Sangre
                    $bloodTypeId = null;
                    if (!empty($row['tipo_sangre'])) {
                        $bloodType = BloodType::firstOrCreate(['name' => strtoupper(trim($row['tipo_sangre']))]);
                        $bloodTypeId = $bloodType->id;
                    }

                    // Insertar Paciente
                    if (!$user->patient) {
                        $dateOfBirth = null;
                        if (!empty($row['fecha_nacimiento'])) {
                            try {
                                $dateOfBirth = \Carbon\Carbon::parse($row['fecha_nacimiento'])->format('Y-m-d');
                            } catch (\Exception $e) {}
                        }

                        Patient::create([
                            'user_id' => $user->id,
                            'blood_type_id' => $bloodTypeId,
                            'allergies' => mb_substr(trim($row['alergias'] ?? ''), 0, 255),
                            'date_of_birth' => $dateOfBirth,
                        ]);
                        $inserted++;
                    }

                } catch (\Exception $e) {
                    Log::error("Fila {$read} rechazada (Error Constraint SQL): " . $e->getMessage());
                    $errors++;
                }
            }); 

            Log::info("====== RESUMEN IMPORTACIÓN (Simple-Excel) ======");
            Log::info("Total Leídas: {$read} | Insertadas: {$inserted} | Fallos formato: {$failures} | Errores SQL: {$errors}");

            Storage::delete($this->filePath);

        } catch (\Exception $e) {
            Log::error("Error Fatal Sistemático en Job ImportPatients: " . $e->getMessage());
            throw $e;
        }
    }
}
