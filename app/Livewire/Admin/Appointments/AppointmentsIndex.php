<?php

namespace App\Livewire\Admin\Appointments;

use Livewire\Component;
use App\Models\Appointment;

class AppointmentsIndex extends Component
{
    use \Livewire\WithPagination;

    public function render()
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user'])->orderBy('date', 'desc')->paginate(10);
        return view('livewire.admin.appointments.appointments-index', [
            'appointments' => $appointments
        ]);
    }
}
