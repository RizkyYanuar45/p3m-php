<?php
function render_component($path, $data = [])
{
    extract($data); // Mengubah ['title' => 'Halo'] menjadi $title
    ob_start();
    include __DIR__ . "/../views/layouts/{$path}.php";
    return ob_get_clean();
}
