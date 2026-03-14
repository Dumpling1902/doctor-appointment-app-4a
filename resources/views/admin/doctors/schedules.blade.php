<x-admin-layout title="Horarios del Doctor | MediAppoint"
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
        'name' => 'Horarios',
    ],
]">

    @livewire('admin.doctors.doctor-schedules', ['doctor' => $doctor])

</x-admin-layout>
