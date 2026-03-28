<x-admin-layout title="Pacientes | MediAppoint"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Pacientes',
    ],
]">

<div class="mb-4 flex justify-end">
    <a href="{{ route('admin.patients.import') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
        <i class="fa-solid fa-file-import mr-2"></i> Importar Masivo
    </a>
</div>

@livewire('admin.datatables.patient-table')

</x-admin-layout>