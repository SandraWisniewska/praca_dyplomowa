<?php
$allInfo = filter_var($_GET['allInfo'], FILTER_VALIDATE_BOOLEAN);
$halfInfo = filter_var($_GET['halfInfo'], FILTER_VALIDATE_BOOLEAN);

// Dodano zabezpieczenie przed atakami XSS przy renderowaniu danych
$file_path = htmlspecialchars(dirname(__FILE__) . '/form-data.json', ENT_QUOTES, 'UTF-8');

function filterByInfo($data, $allInfo, $halfInfo)
{
    $tempArray = [];
    foreach ($data as $idx => $row) {
        // Dodano zabezpieczenie przed atakami XSS przy porównywaniu wartości
        if (filter_var($row->allInfo, FILTER_VALIDATE_BOOLEAN) == $allInfo 
            && filter_var($row->halfInfo, FILTER_VALIDATE_BOOLEAN) == $halfInfo) {
            array_push($tempArray, $row);
        }
    }
    return $tempArray;
}

// Dodano sprawdzenie typu zawartości pliku
if (file_exists($file_path) && is_file($file_path) && pathinfo($file_path, PATHINFO_EXTENSION) === 'json') {
    $file_content = file_get_contents($file_path);
    $data = json_decode($file_content);

    // Dodano sprawdzenie czy $data jest tablicą
    if (is_array($data)) {
        $contact_data = filterByInfo($data, $allInfo, $halfInfo);

        if (count($contact_data) > 0) {
            include '../SCRIPTS/contact-table.php';
        }
    }
}
?>