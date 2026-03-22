<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h3>{{ $title }}</h3>
    <p>A continuación se detallan las citas programadas para el día de hoy:</p>
    
    @if($appointments->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Paciente</th>
                    <th>Doctor</th>
                    <th>Motivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->start_time }} - {{ $appointment->end_time }}</td>
                    <td>{{ $appointment->patient->user->name ?? 'N/A' }}</td>
                    <td>{{ $appointment->doctor->user->name ?? 'N/A' }}</td>
                    <td>{{ $appointment->reason }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay citas programadas para hoy.</p>
    @endif

    <p style="margin-top: 30px;">Saludos,<br><strong>Sistema de Citas</strong></p>
</body>
</html>
