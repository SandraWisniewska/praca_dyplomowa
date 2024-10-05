<?php
header('Content-Type: application/json');

// Połączenie z bazą danych
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "NUTRITION";

// Zabezpieczenie danych do połączenia z bazą
$servername = htmlspecialchars($servername, ENT_QUOTES, 'UTF-8');
$username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
$password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
$dbname = htmlspecialchars($dbname, ENT_QUOTES, 'UTF-8');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Załącz plik functions.php
include 'functions.php';

// Obsługa zapytań
if (isset($_GET['product'])) {
    // Zabezpieczenie danych wejściowych z parametru GET
    $productName = isset($_GET['product']) ? htmlspecialchars($_GET['product'], ENT_QUOTES, 'UTF-8') : '';
    // Zastosowanie prepared statements
    $productNutrition = getProductNutrition($productName, $conn);
    echo json_encode(['productNutrition' => $productNutrition]);
} elseif (isset($_GET['dailyRequirements'])) {
    $dailyRequirements = getDailyRequirements($conn);
    echo json_encode($dailyRequirements);
} elseif (isset($_GET['getProductsList'])) {
    // Pobierz dane produktów z bazy danych
    $products = getProductsFromDatabase($conn);
    echo json_encode(['products' => $products]);
} else {
    echo json_encode(['error' => 'Invalid request']);
}

// Zabezpieczenie przed ewentualnymi błędami podczas zamykania połączenia
try {
    $conn->close();
} catch (Exception $e) {
    // Obsługa błędu zamykania połączenia
}

?>
