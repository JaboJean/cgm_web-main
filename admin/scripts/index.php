<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <Title>Liturgical Calendar</Title>
    <!-- Favicon -->
    <link rel="icon" href="favicon.png" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.10.1/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@5.10.1/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@5.10.1/main.min.js'></script>
    <!-- Optional: Bootstrap JavaScript (for components like modals or tooltips) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
            background-color: #F1F3F4 !important;
        }
        #calendar {
            max-width: 900px;
            margin: 40px auto;
            background-color: #ffffff !important;
            padding: 20px !important;
        }

        .fc-daygrid-event {
            background-color: #D2E8CC; /* Example color - adjust as needed */
            color: #2C3E50 !important;
            border: none; /* Optional: Remove border */
            border-radius: 0px !important;
        }
        .fc-daygrid-event .fc-event-main {
            padding: 10px;
            color: #2C3E50 !important;
        }

        .fc-day-today {
            background-color: #0A8043 !important;
            color: #ffffff !important;
        }
    </style>
</head>
<body>
<div id='calendar'></div>

<?php
// Make the API call using cURL
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://litcal.johnromanodorazio.com/api/v3/LitCalEngine.php',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => 'locale=LA&epiphany=JAN6&ascension=THURSDAY&corpuschristi=THURSDAY&year=2024&nationalpreset=&diocesanpreset=&returntype=JSON',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
    ),
));

$response = curl_exec($curl);

if ($response === false) {
    echo 'cURL Error: ' . curl_error($curl);
    exit;
}

curl_close($curl);

// Decode JSON response
$data = json_decode($response, true);

// Check if data is valid
$events = [];
if (isset($data['Metadata']['Solemnities'])) {
    $solemnities = $data['Metadata']['Solemnities'];
    foreach ($solemnities as $event => $details) {
        $events[] = [
            'title' => $event,
            'start' => date('Y-m-d', strtotime($details['date'])) // Ensure date format is compatible with FullCalendar
        ];
    }
} else {
    echo '<p>Failed to retrieve the data.</p>';
    exit;
}
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: <?php echo json_encode($events); ?> // Make sure events are correctly passed here
        });
        calendar.render();
    });
</script>
</body>
</html>
