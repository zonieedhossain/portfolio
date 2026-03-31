<?php
// Simple PHP wrapper to serve the HTML template
$template_path = __DIR__ . '/templates/index.html';

if (file_exists($template_path)) {
    readfile($template_path);
} else {
    header('HTTP/1.1 500 Internal Server Error');
    echo "Error: Template file not found at " . htmlspecialchars($template_path);
}
?>
