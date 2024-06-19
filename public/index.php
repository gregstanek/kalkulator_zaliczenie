<?php
require_once '../vendor/autoload.php';

// Konfiguracja bazy danych
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kalkulator";

// Połączenie z bazą danych
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ustawienie kodowania na utf8
$conn->set_charset("utf8");

// Pobierz historię obliczeń
$sql = "SELECT user_address, distance, calculation_date FROM calculations ORDER BY calculation_date DESC LIMIT 10";
$result = $conn->query($sql);

$calculations = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $calculations[] = $row;
    }
}

$conn->close();

// Inicjalizacja Twig
$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

// Renderowanie szablonu
echo $twig->render('index.twig', ['calculations' => $calculations]);