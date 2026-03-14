<x-admin-layout title="Citas | MediAppoint"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Citas',
    ],
]">

    <div class="mb-4 flex justify-end">
        <a href="{{ route('admin.appointments.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
            Nueva Cita
        </a>
    </div>

    @livewire('admin.appointments.appointments-index')

</x-admin-layout>
