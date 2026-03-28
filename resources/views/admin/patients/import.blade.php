<x-admin-layout title="Importar Pacientes"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Pacientes',
        'href' => route('admin.patients.index'),
    ],
    [
        'name' => 'Importar'
    ]
]">

    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Importar Pacientes Masivamente</h2>

        <p class="mb-4 text-gray-600">
            Sube un archivo CSV o Excel para registrar pacientes de forma automática en segundo plano. Esto no bloqueará el sistema y te permite cargar miles de registros al mismo tiempo.
        </p>

        <form action="{{ route('admin.patients.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <x-validation-errors class="mb-4" />

            <div class="mb-6">
                <x-label value="Seleccione el Archivo (CSV, XLSX, XLS)" class="mb-2" />
                <input type="file" name="file" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300" required accept=".csv, .xlsx, .xls">
                <div class="mt-3 text-sm text-gray-500 bg-gray-50 p-4 rounded-md border border-gray-200">
                    <p class="font-bold mb-1">Estructura del archivo requerida:</p>
                    <ul class="list-disc ml-5 space-y-1">
                        <li><strong>nombre_completo:</strong> Nombre del paciente (Requerido)</li>
                        <li><strong>correo:</strong> Correo electrónico único (Requerido)</li>
                        <li><strong>telefono:</strong> Número de contacto (Opcional)</li>
                        <li><strong>fecha_nacimiento:</strong> En formato AAAA-MM-DD (Opcional)</li>
                        <li><strong>tipo_sangre:</strong> Ej. O+, A- (Opcional)</li>
                        <li><strong>alergias:</strong> Lista de alergias separadas por comas (Opcional)</li>
                    </ul>
                </div>
            </div>

            <div class="flex justify-end">
                <x-button>
                    <i class="fa-solid fa-file-import mr-2"></i> Comenzar Importación
                </x-button>
            </div>
        </form>
    </div>

</x-admin-layout>
