<x-admin-layout title="Nueva Cita | MediAppoint"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Citas',
        'href' => route('admin.appointments.index'),
    ],
    [
        'name' => 'Nueva',
    ],
]">

    @livewire('admin.appointments.appointments-create')

</x-admin-layout>
