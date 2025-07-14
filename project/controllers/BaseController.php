<?php
// BaseController: Provides shared logic for all controllers (e.g., DB connection)
class BaseController
{
    // Database connection (PDO)
    protected $db;

    public function __construct()
    {
        // Get PDO connection from DB singleton
        $this->db = DB::getInstance()->getConnection();
    }
}
