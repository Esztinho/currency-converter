<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter</title>
    <link rel="stylesheet" href="style.css">
</head>

    <div class="container">
        <h1>Simple Currency Converter</h1>
        
        <!-- Átváltó űrlap -->
        <form method="post" action="">
            <label for="amount">Amount:</label>
            <input type="number" step="0.01" name="amount" id="amount" required><br><br>
            
            <label for="from_currency">From:</label>
            <select name="from_currency" id="from_currency" required>
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
                <option value="HUF">HUF</option>
            </select><br><br>
            
            <label for="to_currency">To:</label>
            <select name="to_currency" id="to_currency" required>
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
                <option value="HUF">HUF</option>
            </select><br><br>
            
            <input type="submit" name="convert" value="Convert">
        </form>

        <?php

$api_key = '7bee7616c098ea15ee886e6b70343b3a';  


$api_url = 'http://data.fixer.io/api/latest?access_key=' . $api_key . '&symbols=USD,EUR,HUF';

// Lekérjük az adatokat
$response = file_get_contents($api_url);

// JSON válasz dekódolása
$data = json_decode($response, true);

// Ellenőrizzük, hogy sikerült-e lekérni az adatokat
if($data && isset($data['rates'])) {
    $rates = $data['rates'];
    echo "1 EUR = " . $rates['USD'] . " USD<br>";
    echo "1 EUR = " . $rates['HUF'] . " HUF<br>";
} else {
    echo "Hiba történt az árfolyamok lekérésekor.";
}


if (isset($_POST['convert'])) {
    $amount = $_POST['amount'];
    $from_currency = $_POST['from_currency'];
    $to_currency = $_POST['to_currency'];

    // Ha az árfolyamok elérhetők
    if ($rates) {
        if ($from_currency == $to_currency) {
            $result = $amount; // Ha ugyanabba a valutába konvertálunk, nincs változás
        } else {
            $result = $amount * ($rates[$to_currency] / $rates[$from_currency]);
        }
        $result = round($result, 2); 
    } else {
        $result = "Hiba történt az árfolyamok lekérésekor.";
    }
}
if (isset($result)) {
    echo "<p>Converted Amount: $result $to_currency</p>";
}
    ?>
   </div> 
</body>
</html>
