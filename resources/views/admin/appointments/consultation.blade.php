<x-admin-layout title="Consulta | MediAppoint"
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
        'name' => 'Atender Consulta',
    ],
]">

    @livewire('admin.consultation-manager', ['appointment' => $appointment])

</x-admin-layout>
