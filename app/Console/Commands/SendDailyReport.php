<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\User;
use App\Mail\ReporteMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendDailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía el reporte diario de citas a los doctores y administradores.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->format('Y-m-d');
        
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
                            ->whereDate('date', $today)
                            ->orderBy('start_time')
                            ->get();

        if ($appointments->isEmpty()) {
            $this->info('No hay citas para hoy.');
            return;
        }

        // Enviar al Administrador
        $admins = User::role('Administrador')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new ReporteMail($appointments, 'Reporte Diario de Citas - Administrador'));
        }

        // Enviar a cada doctor (evitando duplicados agrupando por doctor)
        $appointmentsByDoctor = $appointments->groupBy('doctor_id');

        foreach ($appointmentsByDoctor as $doctorId => $doctorAppointments) {
            $doctor = $doctorAppointments->first()->doctor;
            if ($doctor && $doctor->user && $doctor->user->email) {
                Mail::to($doctor->user->email)->send(new ReporteMail($doctorAppointments, 'Tus Citas de Hoy'));
            }
        }

        $this->info('Reportes enviados correctamente.');
    }
}
