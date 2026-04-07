<?php
echo "DIR: " . __DIR__ . "<br>";
echo "Uploads ada: " . (is_dir(__DIR__ . '/uploads/') ? 'YA' : 'TIDAK') . "<br>";
echo "Bisa tulis: " . (is_writable(__DIR__ . '/uploads/') ? 'YA' : 'TIDAK') . "<br>";
?>