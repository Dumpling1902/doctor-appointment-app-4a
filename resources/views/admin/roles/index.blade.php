<x-admin-layout title="Roles | MediAppoint"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
    ]
]">

@livewire('admin.datatables.role-table')

</x-admin-layout>