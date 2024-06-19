<?php
require_once '../vendor/autoload.php';

// Konfiguracja bazy danych
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kalkulator";

// Klucz API
$api_key = "4n4euQrx-TzM5V6wZ81hnTnpL6H75W7l3MpVjIHVCpI";

// Funkcja do pobierania współrzędnych geograficznych
function getCoordinates($address, $api_key) {
    $url = "https://geocode.search.hereapi.com/v1/geocode?q=" . urlencode($address) . "&apiKey=" . $api_key;
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    if (!empty($data['items'])) {
        return $data['items'][0]['position'];
    }
    return null;
}

// Funkcja do wyliczania odległości
function calculateDistance($coords1, $coords2) {
    $earthRadius = 6371000; // promień Ziemi w metrach

    $latFrom = deg2rad($coords1['lat']); // konwersja szerokości geograficznej pierwszego punktu
    $lonFrom = deg2rad($coords1['lng']); // konwersja długości geograficznej pierwszego punktu
    $latTo = deg2rad($coords2['lat']); // konwersja szerokości geograficznej drugiego punktu
    $lonTo = deg2rad($coords2['lng']); // konwersja długości geograficznej drugiego punktu

    $latDelta = $latTo - $latFrom; // różnica szerokości geograficznej między dwoma punktami
    $lonDelta = $lonTo - $lonFrom; // różnica długości geograficznej między dwoma punktami

    // obliczenie kąta centralnego między dwoma punktami na powierzchni kuli
    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

    return $angle * $earthRadius; // zwrócenie odległości w metrach
}
// Połączenie z bazą danych
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ustawienie kodowania na utf8
$conn->set_charset("utf8");

// Pobieramy adres Shoper z bazy danych
$sql = "SELECT address FROM headquarters WHERE id = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $shoper_address = $row['address'];
} else {
    die("Nie udało się pobrać adresu siedziby.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_address = $_POST['address'];

    // Pobierz współrzędne siedziby Shoper.pl
    $shoper_coords = getCoordinates($shoper_address, $api_key);
    if ($shoper_coords === null) {
        die("Nie udało się pobrać współrzędnych siedziby Shoper.pl.");
    }

    // Pobieramy współrzędne adresu użytkownika
    $user_coords = getCoordinates($user_address, $api_key);
    if ($user_coords === null) {
        die("Nie udało się pobrać współrzędnych podanego adresu.");
    }

    // Wyliczamy odległość
    $distance = calculateDistance($shoper_coords, $user_coords);

    // Zapisujemy wynik do bazy danych
    $stmt = $conn->prepare("INSERT INTO calculations (user_address, distance) VALUES (?, ?)");
    $stmt->bind_param("sd", $user_address, $distance);
    $stmt->execute();
    $stmt->close();

    // Pobieramy historię z bazy
    $sql = "SELECT user_address, distance, calculation_date FROM calculations ORDER BY calculation_date DESC LIMIT 10";
    $result = $conn->query($sql);

    $calculations = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $calculations[] = $row;
        }
    }

    // Inicjalizujemy Twig
    $loader = new \Twig\Loader\FilesystemLoader('../templates');
    $twig = new \Twig\Environment($loader);

    // Renderujemy templatke
    echo $twig->render('result.twig', [
        'distance' => $distance,
        'calculations' => $calculations
    ]);
}

$conn->close();