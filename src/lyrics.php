<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = getenv('GENIUS_API_KEY');

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://genius-song-lyrics1.p.rapidapi.com/search/?q=" . urlencode($query) . "&per_page=10&page=1",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "X-RapidAPI-Host: genius-song-lyrics1.p.rapidapi.com",
        "X-RapidAPI-Key: $apiKey"
    ], // Corrected the use of $apiKey here
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $data = json_decode($response, true);
    if(isset($data['hits'])) {
        foreach ($data['hits'] as $hit) {
            $result = $hit['result'];
            $title = $result['full_title'];
            $artist = $result['primary_artist']['name'];
            $url = $result['url'];
            echo '<div class="box">';
            echo "<h2>$title</h2>";
            echo "<p>Artist: $artist</p>";
            echo "<a href='$url'>View Lyrics</a>";
            echo '</div>';
        }
    } else {
        echo "No results found.";
    }
}
?>
