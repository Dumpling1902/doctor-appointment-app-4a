<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Patient;
use App\Models\BloodType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class PatientsImport implements ToModel, WithHeadingRow, WithChunkReading, WithValidation, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    public $rowsRead = 0;
    public $rowsInserted = 0;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $this->rowsRead++;

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

            try {
                $user->assignRole('Paciente');
            } catch (\Exception $e) {
                // Ignorar si el rol no existe, o loguearlo.
            }
        }

        // Tipo de sangre
        $bloodTypeId = null;
        $bloodTypeStr = trim($row['tipo_sangre'] ?? '');
        if (!empty($bloodTypeStr)) {
            $bloodType = BloodType::firstOrCreate([
                'name' => strtoupper($bloodTypeStr)
            ]);
            $bloodTypeId = $bloodType->id;
        }

        // Paciente
        if (!$user->patient) {
            $dateOfBirth = trim($row['fecha_nacimiento'] ?? '');
            if (!empty($dateOfBirth)) {
                try {
                    $dateOfBirth = \Carbon\Carbon::parse($dateOfBirth)->format('Y-m-d');
                } catch (\Exception $e) {
                    $dateOfBirth = null;
                }
            } else {
                $dateOfBirth = null;
            }

            $this->rowsInserted++;

            return new Patient([
                'user_id' => $user->id,
                'blood_type_id' => $bloodTypeId,
                'allergies' => mb_substr(trim($row['alergias'] ?? ''), 0, 255),
                'date_of_birth' => $dateOfBirth,
            ]);
        }

        return null;
    }

    public function rules(): array
    {
        return [
            'correo' => 'required|email',
            'nombre_completo' => 'required|string|min:3',
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
