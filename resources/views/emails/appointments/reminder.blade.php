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
            background-color: #f59e0b;
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
            background-color: #fffbeb;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border: 1px solid #fcd34d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Recordatorio de Cita</h1>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $appointment->patient->name }}</strong>,</p>
            <p>Te recordamos que tienes una cita médica programada para <strong>MAÑANA</strong>.</p>

            <div class="details">
                <p><strong>Doctor:</strong> {{ $appointment->doctor->name }}</p>
                <p><strong>Fecha:</strong> {{ $appointment->date }}</p>
                <p><strong>Hora:</strong> {{ $appointment->time }}</p>
            </div>

            <p>Si no puedes asistir, por favor cancela tu cita con al menos 24 horas de antelación.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sistema de Citas Médicas. No respondas a este correo.</p>
        </div>
    </div>
</body>

</html>