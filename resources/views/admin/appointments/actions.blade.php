<div class="flex items-center space-x-2">
    <!-- Existing actions (you can add edit/delete here if needed later) -->
    
    <!-- New consultation button with stethoscope icon -->
    <a href="{{ route('admin.consultation', $appointment->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Atender Cita">
        <i class="fas fa-stethoscope"></i>
    </a>
</div>
