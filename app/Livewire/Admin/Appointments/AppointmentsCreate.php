<?php

namespace App\Livewire\Admin\Appointments;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Speciality;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AppointmentsCreate extends Component
{
    public $patient_id;
    public $doctor_id;
    public $date;
    public $start_time;
    public $end_time;
    public $reason;

    // Campos de búsqueda
    public $search_date;
    public $search_time;
    public $search_specialty;
    public $searched = false;

    // Horarios ficticios disponibles
    public $dummy_slots = ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '15:00', '15:30', '16:00', '16:30'];

    public function mount()
    {
        $this->search_date = Carbon::today()->format('Y-m-d');
        // Initial setup for date
        $this->date = $this->search_date;
    }

    protected function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'required|string',
        ];
    }

    public function searchAvailability()
    {
        $this->searched = true;
        // Reiniciamos selección
        $this->doctor_id = null;
        $this->start_time = null;
        $this->end_time = null;
        $this->date = $this->search_date;
    }

    public function selectSlot($doctorId, $time)
    {
        $this->doctor_id = $doctorId;
        $this->date = $this->search_date;
        $this->start_time = $time;
        // Forzamos la hora final a ser start_time + 15 min 
        $this->end_time = Carbon::createFromFormat('H:i', $time)->addMinutes(15)->format('H:i');
    }

    public function save()
    {
        $this->validate();

        Appointment::create([
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'reason' => $this->reason,
            'status' => 1,
            'duration' => 15, // default
        ]);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cita Creada',
            'text' => 'La cita ha sido registrada correctamente.',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        $query = Doctor::with(['user', 'speciality']);

        if ($this->search_specialty) {
            $query->where('speciality_id', $this->search_specialty);
        }

        $availableDoctors = $query->get();

        $selectedDoctorName = null;
        if ($this->doctor_id) {
            $selectedDoctorName = Doctor::find($this->doctor_id)?->user?->name;
        }

        return view('livewire.admin.appointments.appointments-create', [
            'patients' => Patient::with('user')->get(),
            'specialities' => Speciality::all(),
            'availableDoctors' => $availableDoctors,
            'selectedDoctorName' => $selectedDoctorName
        ]);
    }
}
