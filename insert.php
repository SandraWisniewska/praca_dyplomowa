<?php

// Zabezpieczenie danych wejściowych z formularza
$params = $_POST;
$params['id'] = uniqid();

foreach ($params as &$param) {
    $param = htmlspecialchars($param, ENT_QUOTES, 'UTF-8');
}

if (isset($params['allInfo'])) {
    $params['allInfo'] = true;
} else {
    $params['allInfo'] = false;
}

if (isset($params['halfInfo'])) {
    $params['halfInfo'] = true;
} else {
    $params['halfInfo'] = false;
}

$file_path = dirname(__FILE__) . '/form-data.json';
$tempArray = [];

if (file_exists($file_path)) {
    // Zabezpieczenie przed niebezpiecznymi plikami JSON
    $file_content = @file_get_contents($file_path);

    if ($file_content !== false) {
        // Zabezpieczenie przed atakami związanymi z manipulacją plikiem JSON
        $tempArray = json_decode($file_content);

        if ($tempArray === null) {
            $tempArray = [];
        }
    }
}

// Walidacja danych przed zapisem do pliku JSON
array_push($tempArray, $params);
$json = json_encode($tempArray);

// Zapis do pliku
file_put_contents($file_path, $json);

?>

<?php include '../INCLUDES/head.html'; ?>
<div class="content">
  <p>Wysłano!</p>
</div>
<?php include '../INCLUDES/footer.html'; ?>
