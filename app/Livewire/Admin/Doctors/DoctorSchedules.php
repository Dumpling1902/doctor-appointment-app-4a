<?php

namespace App\Livewire\Admin\Doctors;

use Livewire\Component;
use App\Models\Doctor;

class DoctorSchedules extends Component
{
    public Doctor $doctor;

    public function mount(Doctor $doctor)
    {
        $this->doctor = $doctor;
    }

    public function render()
    {
        // Horarios ficticios temporales organizados por día
        $schedules = [
            'Lunes' => ['08:00', '08:30', '09:00', '09:30', '10:00'],
            'Martes' => ['10:00', '10:30', '11:00', '11:30', '12:00'],
            'Miércoles' => ['08:00', '08:30', '09:00', '15:00', '15:30'],
            'Jueves' => ['10:00', '10:30', '16:00', '16:30', '17:00'],
            'Viernes' => ['08:00', '09:00', '10:00', '11:00', '12:00'],
        ];

        return view('livewire.admin.doctors.doctor-schedules', compact('schedules'));
    }
}
