<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Appointment;

class ConsultationManager extends Component
{
    public Appointment $appointment;
    public $tab = 'consulta';
    
    // Consulta
    public $diagnosis = '';
    public $treatment = '';
    public $notes = '';

    // Receta
    public $medications = [];

    // Modal
    public $showHistoryModal = false;
    public $showMedicalHistoryModal = false;

    public function mount(Appointment $appointment)
    {
        $this->appointment = $appointment;
        // Agregamos dos medicamentos por defecto en la estructura
        $this->addMedication();
        $this->addMedication();
    }

    public function addMedication()
    {
        $this->medications[] = ['name' => '', 'dosage' => '', 'frequency' => '', 'duration' => ''];
    }

    public function removeMedication($index)
    {
        unset($this->medications[$index]);
        $this->medications = array_values($this->medications);
    }

    protected $rules = [
        'diagnosis' => 'required|string|min:5',
        'treatment' => 'required|string|min:5',
        'notes' => 'nullable|string',
        'medications.*.name' => 'nullable|string',
    ];

    public function setTab($tabName)
    {
        $this->tab = $tabName;
    }

    public function save()
    {
        $this->validate();

        // For now we just close the appointment since there is no column for diagnosis/treatment in step 1.
        $this->appointment->update(['status' => 2]); // Status 2 = Atendida / Cerrada

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Consulta Guardada',
            'text' => 'La consulta médica ha sido finalizada correctamente.',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function getPastConsultationsProperty()
    {
        // Mocked from past appointments just to show the logic in the modal
        // since diagnosis/treatment were not added to appointments table
        return Appointment::with('doctor.user')
                ->where('patient_id', $this->appointment->patient_id)
                ->where('id', '!=', $this->appointment->id)
                ->where('status', 2)
                ->orderBy('date', 'desc')
                ->get();
    }

    public function render()
    {
        return view('livewire.admin.consultation-manager');
    }
}
