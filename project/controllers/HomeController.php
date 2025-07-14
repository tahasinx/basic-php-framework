<?php
require_once 'BaseController.php';

// HomeController: Handles requests for the home page and user-related actions
class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); // Initialize DB connection
    }

    // Show the home page
    public function index()
    {
        view('home', ['title' => 'Home Page']);
    }

    // Show a specific user by ID
    public function show($id)
    {
        view('user', ['id' => $id]);
    }

    // Render an example view, supports AJAX (JSON) and normal rendering
    public function render_example($id)
    {
        $html = render('user', ['id' => $id], 'app/views');
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'html' => $html,
                'id' => $id
            ]);
            exit;
        }
        view('renders/example', ['html' => $html]);
    }

    // Handle POST request to create a user (demo only)
    public function store()
    {
        $name  = $_POST['name'] ?? 'Unknown';
        $email = $_POST['email'] ?? 'No email';
        // You can add validation or saving logic here
        echo "User created: Name = " . htmlspecialchars($name) . ", Email = " . htmlspecialchars($email);
    }

    // Example: Fetch all users from the database and show them
    public function db_example()
    {
        // Example: fetch all users from a 'users' table
        $stmt = $this->db->query("SELECT id, name, email FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Render the results in a view (create app/views/users.php if needed)
        view('users', ['users' => $users]);
    }
}
