<?php

if (isset($_GET['query'])) {
    $query = $_GET['query'];

   
    include 'lyrics.php';
} else {
    echo "No search query provided.";
}

?>
