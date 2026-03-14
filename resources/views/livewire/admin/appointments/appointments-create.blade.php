<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Columna Izquierda (2/3) -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Buscar disponibilidad -->
        <div class="bg-white p-6 shadow rounded-lg">
            <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Buscar disponibilidad</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block font-medium text-sm text-gray-700">Fecha</label>
                    <input type="date" wire:model="search_date" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700">Rango de horas</label>
                    <input type="time" wire:model="search_time" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700">Especialidad (Opcional)</label>
                    <select wire:model="search_specialty" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-white">
                        <option value="">Todas</option>
                        @foreach($specialities as $speciality)
                            <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button wire:click="searchAvailability" type="button" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent text-white font-semibold rounded-md shadow hover:bg-indigo-700 active:bg-indigo-800 transition">
                    <i class="fa-solid fa-magnifying-glass mr-2"></i> Buscar disponibilidad
                </button>
            </div>
        </div>

        <!-- Resultados -->
        @if($searched)
        <div class="bg-white p-6 shadow rounded-lg">
            <h3 class="text-md font-bold text-gray-800 mb-4 border-b pb-2">Doctores Disponibles</h3>
            <div class="space-y-4">
                @forelse($availableDoctors as $doc)
                    <div class="border rounded-lg p-5 flex flex-col md:flex-row gap-5 items-start md:items-center bg-gray-50 hover:bg-indigo-50 transition duration-150">
                        <div class="flex-shrink-0">
                            <!-- Avatar con iniciales -->
                            <div class="h-16 w-16 rounded-full bg-white border-2 border-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-xl shadow-sm">
                                {{ strtoupper(substr($doc->user->name, 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-lg font-bold text-gray-900">Dr. {{ $doc->user->name }}</h4>
                            <p class="text-sm text-gray-500 font-medium">{{ $doc->speciality?->name ?? 'Médico General' }}</p>
                        </div>
                        <div class="w-full md:w-3/5">
                            <p class="text-xs text-gray-600 mb-2 font-semibold tracking-wide uppercase">Horarios disponibles:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($dummy_slots as $slot)
                                    <button type="button" wire:click="selectSlot({{ $doc->id }}, '{{ $slot }}')" 
                                            class="px-3 py-1.5 border rounded-md shadow-sm font-medium transition text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 
                                            {{ ($doctor_id == $doc->id && $start_time == $slot) 
                                                ? 'bg-indigo-600 text-white border-indigo-600' 
                                                : 'bg-white text-indigo-700 border-indigo-300 hover:bg-indigo-100 hover:border-indigo-400' }}">
                                        {{ $slot }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6">
                        <i class="fa-solid fa-user-doctor text-4xl text-gray-300 mb-2"></i>
                        <p class="text-gray-500 text-sm font-medium">No se encontraron doctores con esa especialidad para la fecha actual.</p>
                    </div>
                @endforelse
            </div>
        </div>
        @else
        <div class="bg-gray-50 border border-dashed border-gray-300 p-8 rounded-lg flex flex-col items-center justify-center text-gray-400">
            <i class="fa-solid fa-calendar-alt text-5xl mb-3"></i>
            <p>Realiza una búsqueda para ver los doctores y horarios disponibles.</p>
        </div>
        @endif

    </div>

    <!-- Columna Derecha (1/3) Resumen -->
    <div class="lg:col-span-1">
        <div class="bg-white shadow rounded-lg sticky top-24 overflow-hidden border border-gray-100">
            <div class="bg-indigo-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white"><i class="fa-solid fa-notes-medical mr-2"></i> Resumen de la cita</h2>
            </div>
            
            <form wire:submit.prevent="save" class="p-6">
                <div class="space-y-5">
                    <!-- Valores Seleccionados -->
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 shadow-sm">
                        <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1"><i class="fa-solid fa-stethoscope mr-1"></i> Doctor seleccionado:</p>
                        <p class="text-sm font-bold text-indigo-900">{{ $selectedDoctorName ? 'Dr. ' . $selectedDoctorName : 'Ninguno' }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 shadow-sm">
                            <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1"><i class="fa-solid fa-calendar-day mr-1"></i> Fecha:</p>
                            <p class="text-sm font-bold text-indigo-900">{{ $date ? \Carbon\Carbon::parse($date)->format('d/m/Y') : '--/--/----' }}</p>
                            <input type="hidden" wire:model="date">
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 shadow-sm">
                            <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mb-1"><i class="fa-solid fa-clock mr-1"></i> Horario:</p>
                            <p class="text-sm font-bold text-indigo-900">{{ $start_time ? $start_time . ' - ' . $end_time : '--:--' }}</p>
                            <input type="hidden" wire:model="start_time">
                            <input type="hidden" wire:model="end_time">
                        </div>
                    </div>
                    @error('date') <span class="text-red-500 text-xs font-semibold block">{{ $message }}</span> @enderror
                    @error('start_time') <span class="text-red-500 text-xs font-semibold block">Debes seleccionar un horario disponible.</span> @enderror
                    @error('end_time') <span class="text-red-500 text-xs font-semibold block">{{ $message }}</span> @enderror
                    @error('doctor_id') <span class="text-red-500 text-xs font-semibold block">Debes seleccionar un doctor disponible.</span> @enderror

                    <!-- Campos del formulario -->
                    <div class="pt-2">
                        <label class="block font-medium text-sm text-gray-700">Paciente</label>
                        <div class="relative mt-1 border-gray-300 border rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-user text-gray-400"></i>
                            </div>
                            <select wire:model="patient_id" class="pl-10 block w-full border-transparent focus:border-indigo-500 focus:ring-indigo-500 rounded-md sm:text-sm bg-transparent py-2">
                                <option value="">Seleccione un paciente</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->user?->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('patient_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Duración estimada</label>
                        <div class="mt-1 flex justify-between items-center shadow-sm rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-600">
                            <span>Consulta General</span>
                            <span class="font-bold text-gray-800">15 min</span>
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Motivo de la consulta</label>
                        <textarea wire:model="reason" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm sm:text-sm" placeholder="Describe brevemente el motivo..."></textarea>
                        @error('reason') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-5 border-t border-gray-200">
                        <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-md shadow-md text-sm font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out disabled:opacity-50">
                            <i class="fa-solid fa-check mr-2"></i> Confirmar Cita
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
