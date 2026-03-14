<div class="space-y-6">
    <!-- Header Controls -->
    <div class="flex justify-between items-center bg-white p-4 shadow rounded-lg">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Atender Cita: {{ $appointment->patient?->user?->name }}</h2>
            <p class="text-sm text-gray-500">Fecha: {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }} | Motivo: {{ $appointment->reason }}</p>
        </div>
        <div class="flex flex-wrap gap-2 justify-end">
            <button wire:click="$set('showMedicalHistoryModal', true)" class="inline-block bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">
                <i class="fas fa-notes-medical mr-2"></i> Ver / Editar Historia Médica
            </button>
            <button wire:click="$set('showHistoryModal', true)" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700 transition">
                <i class="fas fa-history mr-2"></i> Consultas Anteriores
            </button>
        </div>
    </div>

    <!-- Main Consultation Area -->
    <div class="bg-white p-6 shadow rounded-lg">
        
        <!-- Tabs -->
        <div class="mb-4 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" role="tablist">
                <li class="mr-2" role="presentation">
                    <button wire:click="setTab('consulta')" class="inline-block p-4 border-b-2 rounded-t-lg {{ $tab === 'consulta' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-600 hover:border-gray-300' }}">
                        Consulta
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button wire:click="setTab('receta')" class="inline-block p-4 border-b-2 rounded-t-lg {{ $tab === 'receta' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-600 hover:border-gray-300' }}">
                        Receta
                    </button>
                </li>
            </ul>
        </div>

        <form wire:submit.prevent="save">
            <!-- Consulta Tab -->
            <div class="{{ $tab === 'consulta' ? 'block' : 'hidden' }} space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Diagnóstico</label>
                    <textarea wire:model="diagnosis" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    @error('diagnosis') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tratamiento</label>
                    <textarea wire:model="treatment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    @error('treatment') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Notas Adicionales</label>
                    <textarea wire:model="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                </div>
            </div>

            <!-- Receta Tab -->
            <div class="{{ $tab === 'receta' ? 'block' : 'hidden' }} space-y-6">
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Medicamentos</h3>
                        <button type="button" wire:click="addMedication" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Añadir Medicamento
                        </button>
                    </div>

                    @foreach($medications as $index => $medication)
                        <div class="flex items-end space-x-4 mb-4 bg-gray-50 p-4 rounded border border-gray-200">
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-700">Nombre</label>
                                <input type="text" wire:model="medications.{{ $index }}.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-700">Dosis</label>
                                <input type="text" wire:model="medications.{{ $index }}.dosage" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-700">Frecuencia</label>
                                <input type="text" wire:model="medications.{{ $index }}.frequency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-700">Duración</label>
                                <input type="text" wire:model="medications.{{ $index }}.duration" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <button type="button" wire:click="removeMedication({{ $index }})" class="mb-1 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-6 flex justify-end border-t border-gray-200 pt-4">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Finalizar Consulta
                </button>
            </div>
        </form>
    </div>

    <!-- Modal Consultas Anteriores -->
    @if($showHistoryModal)
    <div class="fixed inset-0 overflow-y-auto" z-index="50">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>
            <!-- Hack para centrado vertical -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-gray-50 rounded-lg text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 border-b border-gray-100 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-4 border-b pb-4">
                        <h3 class="text-xl leading-6 font-bold text-gray-800" id="modal-title">
                            <i class="fa-solid fa-clock-rotate-left text-indigo-600 mr-2"></i> Historial de Consultas Anteriores
                        </h3>
                        <button type="button" wire:click="$set('showHistoryModal', false)" class="text-gray-400 hover:text-gray-600 transition">
                            <i class="fa-solid fa-xmark text-xl focus:outline-none"></i>
                        </button>
                    </div>

                    <div class="mt-4 space-y-4 max-h-[60vh] overflow-y-auto pr-2">
                        @forelse($this->pastConsultations as $past)
                            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm mb-4 hover:shadow-md transition">
                                <div class="flex justify-between items-center mb-4 border-b pb-3 border-gray-100">
                                    <span class="font-bold text-gray-800 text-md">
                                        <i class="fa-regular fa-calendar-check mr-2 text-indigo-500"></i>
                                        {{ \Carbon\Carbon::parse($past->date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($past->start_time)->format('H:i') }}
                                    </span>
                                    <span class="text-sm font-semibold text-indigo-800 bg-indigo-50 border border-indigo-100 px-3 py-1 rounded-full">
                                        Dr. {{ $past->doctor?->user?->name }}
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-1 gap-4 mb-4">
                                    <div class="text-sm text-gray-700">
                                        <strong class="text-gray-900 block mb-1">Diagnóstico:</strong>
                                        <div class="bg-gray-50 border border-gray-100 p-3 rounded-md min-h-[50px]">{{ $past->diagnosis ?? 'No registrado' }}</div>
                                    </div>
                                    <div class="text-sm text-gray-700">
                                        <strong class="text-gray-900 block mb-1">Tratamiento:</strong>
                                        <div class="bg-gray-50 border border-gray-100 p-3 rounded-md min-h-[50px]">{{ $past->treatment ?? 'No registrado' }}</div>
                                    </div>
                                    <div class="text-sm text-gray-700">
                                        <strong class="text-gray-900 block mb-1">Notas médicas:</strong>
                                        <div class="bg-gray-50 border border-gray-100 p-3 rounded-md min-h-[50px]">{{ $past->notes ?? 'Sin notas adicionales' }}</div>
                                    </div>
                                </div>

                                <div class="flex justify-end pt-2">
                                    <a href="{{ route('admin.consultation', $past->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                        Consultar Detalle <i class="fa-solid fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col justify-center items-center py-10 text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <i class="fa-solid fa-folder-open text-5xl mb-3 text-gray-300"></i>
                                <p class="text-lg font-medium">No hay consultas anteriores registradas.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-end items-center border-t border-gray-200">
                    <button type="button" wire:click="$set('showHistoryModal', false)" class="w-full sm:w-auto inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:text-sm transition">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal Historia Médica -->
    @if($showMedicalHistoryModal)
    <div class="fixed inset-0 overflow-y-auto" z-index="50">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-100">
                    <div class="flex justify-between items-center mb-4 border-b pb-4">
                        <h3 class="text-xl leading-6 font-bold text-gray-800" id="modal-title">
                            <i class="fa-solid fa-notes-medical text-indigo-600 mr-2"></i> Historia Médica 
                        </h3>
                        <button type="button" wire:click="$set('showMedicalHistoryModal', false)" class="text-gray-400 hover:text-gray-600 transition">
                            <i class="fa-solid fa-xmark text-xl focus:outline-none"></i>
                        </button>
                    </div>

                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                            <p class="text-xs uppercase tracking-wider text-gray-500 font-bold mb-1"><i class="fa-solid fa-droplet text-red-500 mr-1"></i> Tipo de Sangre</p>
                            <p class="text-gray-900 font-medium">{{ $appointment->patient?->bloodType?->name ?? 'No especificado' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                            <p class="text-xs uppercase tracking-wider text-gray-500 font-bold mb-1"><i class="fa-solid fa-allergies text-yellow-500 mr-1"></i> Alergias</p>
                            <p class="text-gray-900 font-medium">{{ $appointment->patient?->allergies ?? 'No registradas' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100 sm:col-span-2">
                            <p class="text-xs uppercase tracking-wider text-gray-500 font-bold mb-1"><i class="fa-solid fa-lungs-virus text-purple-500 mr-1"></i> Enfermedades Crónicas</p>
                            <p class="text-gray-900 font-medium">{{ $appointment->patient?->chronic_conditions ?? 'Ninguna' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100 sm:col-span-2">
                            <p class="text-xs uppercase tracking-wider text-gray-500 font-bold mb-1"><i class="fa-solid fa-scalpel text-blue-500 mr-1"></i> Antecedentes Quirúrgicos</p>
                            <p class="text-gray-900 font-medium">{{ $appointment->patient?->surgical_history ?? 'Ninguno' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-4 border-t border-gray-200 sm:px-6 flex flex-col sm:flex-row-reverse justify-between items-center gap-3">
                    <a href="{{ route('admin.patients.edit', $appointment->patient_id) }}" target="_blank" class="w-full sm:w-auto inline-flex justify-center items-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Ver / Editar Historia Médica
                    </a>
                    <button type="button" wire:click="$set('showMedicalHistoryModal', false)" class="w-full sm:w-auto inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
