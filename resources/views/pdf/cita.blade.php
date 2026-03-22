<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Cita</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .details { margin-top: 20px; line-height: 1.6; }
        .details strong { width: 150px; display: inline-block; }
        .footer { margin-top: 50px; text-align: center; font-size: 0.9em; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Comprobante de Cita Médica</h2>
    </div>
    
    <div class="details">
        <p><strong>Paciente:</strong> {{ $appointment->patient->user->name ?? 'N/A' }}</p>
        <p><strong>Doctor:</strong> {{ $appointment->doctor->user->name ?? 'N/A' }}</p>
        <p><strong>Fecha de la cita:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</p>
        <p><strong>Hora:</strong> {{ $appointment->start_time }} - {{ $appointment->end_time }}</p>
        <p><strong>Motivo:</strong> {{ $appointment->reason }}</p>
    </div>

    <div class="footer">
        <p>Por favor, preséntese al menos 15 minutos antes de su cita.</p>
        <p>Gracias por su preferencia.</p>
    </div>
</body>
</html>
