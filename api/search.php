

<?php
require 'middleware.php';
authenticate();

$data = json_decode(file_get_contents('php://input'), true);

// Load flights from JSON
$flights = json_decode(file_get_contents('data/flights.json'), true);

$origin = $data['origin'];
$destination = $data['destination'];
$departureDate = $data['departureDate']; // Format: YYYY-MM-DD
$passengers = (int)$data['passengers'];
$searchDay = (int)date('w', strtotime($departureDate)); // 0 = Sunday, 6 = Saturday

// Filter flights based on criteria
$results = array_filter($flights, function ($f) use ($origin, $destination, $departureDate, $searchDay, $passengers) {
    $flightDate = substr($f['departure'], 0, 10); // "YYYY-MM-DD"
    return $f['origin'] === $origin &&
           $f['destination'] === $destination &&
           $flightDate === $departureDate &&
           in_array($searchDay, $f['operationalDays']) &&
           $f['availableSeats'] >= $passengers;
});

header('Content-Type: application/json');
echo json_encode(array_values($results));
