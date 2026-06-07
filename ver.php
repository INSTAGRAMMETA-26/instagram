<?php
if (file_exists("usernames.txt")) {
    echo "<pre>" . file_get_contents("usernames.txt") . "</pre>";
} else {
    echo "El archivo usernames.txt todavía no se creó. ¡Hacé una prueba primero!";
}
?>
