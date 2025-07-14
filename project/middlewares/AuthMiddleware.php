<?php
// AuthMiddleware: Checks if the user is authenticated (session-based)
class AuthMiddleware
{
    // handle(): Returns false and outputs message if not authenticated
    public function handle()
    {
        if (!isset($_SESSION['user'])) {
            echo "Not authenticated!";
            return false;
        }
        return true;
    }
}
