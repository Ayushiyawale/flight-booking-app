<?php
require 'middleware.php';
authenticate();

$data = json_decode(file_get_contents('php://input'), true);
$flights = json_decode(file_get_contents('data/flights.json'), true);

foreach ($flights as &$flight) {
    // Use 'flightNumber' instead of 'id'
    // Use 'availableSeats' instead of 'seatsAvailable'
    if ($flight['flightNumber'] == $data['flightNumber'] && $flight['availableSeats'] >= $data['passengers']) {
        $flight['availableSeats'] -= $data['passengers'];
        // Save updated flights JSON back to file
        file_put_contents('data/flights.json', json_encode($flights, JSON_PRETTY_PRINT));
        echo json_encode($flight);
        exit;
    }
}

http_response_code(400);
echo json_encode(['error' => 'Booking failed']);
