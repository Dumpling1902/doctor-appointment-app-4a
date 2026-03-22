<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmación de Cita</title>
</head>
<body>
    <h3>Hola {{ $appointment->patient->user->name ?? 'Paciente' }},</h3>
    <p>Le confirmamos que su cita médica ha sido agendada exitosamente.</p>
    
    <ul>
        <li><strong>Doctor:</strong> {{ $appointment->doctor->user->name ?? 'N/A' }}</li>
        <li><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</li>
        <li><strong>Hora:</strong> {{ $appointment->start_time }}</li>
    </ul>

    <p>Hemos adjuntado el comprobante de su cita en un archivo PDF en este correo.</p>

    <p>Saludos,</p>
    <p><strong>El equipo médico</strong></p>
</body>
</html>
