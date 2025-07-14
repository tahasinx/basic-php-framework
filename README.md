# Basic PHP Framework

A lightweight, educational PHP framework for building simple web applications. This project demonstrates core concepts such as routing, controllers, middleware, and views, making it ideal for learning or as a starting point for custom PHP projects.

## Features
- Simple routing system (GET/POST, dynamic parameters, named routes)
- MVC-like structure (Controllers, Views)
- Middleware support (authentication, logging, etc.)
- Environment variable loading from `.env`
- PDO-based database connection (singleton)
- Helper functions for rendering views and partials

## Directory Structure
```
project/
  app/
    assets/           # Static assets (CSS, JS, images)
    views/            # View templates (PHP)
      renders/        # Partial views for AJAX or components
  controllers/        # Controller classes
  middlewares/        # Middleware (Auth, Logging, etc.)
  routes/
    web.php           # Route definitions
  database.php        # Database connection singleton
  env.php             # Environment loader
  helpers.php         # View/render helpers
  index.php           # Main entry point
  Router.php          # Routing and dispatch logic
```

## Getting Started

### Prerequisites
- PHP 7.2+
- MySQL (for database features)
- Composer (optional, for autoloading or extensions)

### Installation
1. **Clone the repository:**
   ```bash
   git clone <repo-url> your-app
   cd your-app
   ```
2. **Set up your environment:**
   - Copy or create a `.env` file in the project root:
     ```
     DB_HOST=localhost
     DB_NAME=your_db
     DB_USER=your_user
     DB_PASS=your_pass
     DB_CHARSET=utf8mb4
     ```
3. **Configure your web server:**
   - Point your document root to the `project/` directory.
   - If using Apache, the included `.htaccess` will route all requests to `index.php`.

4. **Create the database and tables:**
   - Example table for users:
     ```sql
     CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(100),
       email VARCHAR(100)
     );
     ```

## Usage
- Define routes in `routes/web.php`.
- Create controllers in `controllers/` and views in `app/views/`.
- Use middleware for authentication, logging, etc.
- Access the app in your browser at the configured URL.

## Example Routes
- `/` — Home page
- `/user/{id}` — Show user by ID
- `/render/{id}` — Render user view (AJAX or normal)
- `/user/store` — POST: Store user (demo)
- `/db-example` — List users from DB
- `/dashboard` — Protected by AuthMiddleware
- `/log` — Logs request via middleware

## Customization
- Add new controllers and methods for your app logic.
- Add new middleware in `middlewares/` and apply to routes.
- Extend the database logic in `database.php` as needed.
- Use the `view()` and `render()` helpers for flexible rendering.

## License
MIT or your preferred license.

---

*This project is for educational/demo purposes. For production use, consider established frameworks like Laravel, Symfony, or Slim.* 