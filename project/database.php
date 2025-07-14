<?php
// DB: Singleton class for managing PDO database connection
class DB
{
    private static $instance = null; // Singleton instance
    private $pdo; // PDO connection

    // Private constructor: Establish PDO connection using environment variables
    private function __construct()
    {
        $host    = $_ENV['DB_HOST'] ?? 'localhost';
        $dbname  = $_ENV['DB_NAME'] ?? '';
        $user    = $_ENV['DB_USER'] ?? '';
        $pass    = $_ENV['DB_PASS'] ?? '';
        $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $this->pdo = new PDO($dsn, $user, $pass, $options);
    }

    // Get the singleton instance
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Get the PDO connection
    public function getConnection()
    {
        return $this->pdo;
    }
}
