<?php
// view(): Render a PHP view file with provided data
function view($name, $data = [])
{
    global $router;
    extract($data);
    require __DIR__ . "/app/views/{$name}.php";
}

// render(): Render a PHP file to a string (for AJAX or partials)
function render($file, $data = [], $dir = 'renders')
{
    global $router;
    ob_start();
    extract($data);
    require __DIR__ . "/$dir/{$file}.php";
    return ob_get_clean();
}
