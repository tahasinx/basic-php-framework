<?php
// log_middleware(): Logs the current request URI to error log
function log_middleware()
{
    error_log("Request to: " . $_SERVER['REQUEST_URI']);
    return true;
}
