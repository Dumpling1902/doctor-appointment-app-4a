<x-admin-layout title="Pacientes | MediAppoint"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Doctores',
        'href' => route('admin.doctors.index'),
    ],
    [
        'name' => 'Detalle',
    ],
]">

@livewire('admin.datatables.doctor-table')



</x-admin-layout>