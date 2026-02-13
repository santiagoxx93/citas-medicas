<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .header {
            background-color: #2563eb;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 20px;
        }

        .footer {
            text-align: center;
            font-size: 0.8em;
            color: #777;
            margin-top: 20px;
        }

        .details {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Cita Confirmada</h1>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $appointment->patient->name }}</strong>,</p>
            <p>Tu cita médica ha sido agendada exitosamente. Aquí están los detalles:</p>

            <div class="details">
                <p><strong>Doctor:</strong> {{ $appointment->doctor->name }} ({{ $appointment->doctor->specialty }})</p>
                <p><strong>Fecha:</strong> {{ $appointment->date }}</p>
                <p><strong>Hora:</strong> {{ $appointment->time }}</p>
                <p><strong>Motivo:</strong> {{ $appointment->observation ?? 'Chequeo general' }}</p>
            </div>

            <p>Por favor llega 10 minutos antes de tu hora programada.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sistema de Citas Médicas. Todos los derechos reservados.</p>
        </div>
    </div>
</body>

</html>