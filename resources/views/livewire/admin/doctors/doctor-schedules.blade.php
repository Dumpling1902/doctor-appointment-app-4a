<div>
    <div class="max-w-5xl mx-auto space-y-6">
        
        <!-- Header / Doctor Info -->
        <div class="bg-white p-6 shadow rounded-lg flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="h-16 w-16 rounded-full bg-indigo-100 border-2 border-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-xl shadow-sm">
                    {{ strtoupper(substr($doctor->user->name, 0, 2)) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Dr. {{ $doctor->user->name }}</h2>
                    <p class="text-sm font-medium text-gray-500">{{ $doctor->speciality?->name ?? 'Médico General' }}</p>
                </div>
            </div>
            
            <a href="{{ route('admin.doctors.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-100 active:bg-gray-200 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                <i class="fa-solid fa-arrow-left mr-2"></i> Volver a Doctores
            </a>
        </div>

        <!-- Schedules Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($schedules as $day => $times)
                <div class="bg-white p-6 shadow rounded-lg border-t-4 border-indigo-500">
                    <div class="flex items-center mb-4 pb-3 border-b border-gray-100">
                        <i class="fa-regular fa-calendar-days text-indigo-500 text-xl mr-3"></i>
                        <h3 class="text-lg font-bold text-gray-800">{{ $day }}</h3>
                    </div>
                    
                    @if(count($times) > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($times as $time)
                                <span class="px-3 py-1.5 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-md font-medium text-sm shadow-sm hover:bg-indigo-100 transition cursor-default">
                                    <i class="fa-regular fa-clock mr-1 opacity-75"></i> {{ $time }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 bg-gray-50 rounded-md border border-dashed border-gray-200">
                            <p class="text-sm text-gray-500 font-medium">Sin horarios</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </div>
</div>
