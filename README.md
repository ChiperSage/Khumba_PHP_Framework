# Khumba PHP Framework

> **Lightweight. Pragmatic. Stable. Long-term.**

Khumba is a lightweight PHP framework designed to be pragmatic, stable, and built for the long haul. It balances modern structure with simplicity and performance — without chasing trends or piling on complexity.

Built for real production use: small-to-medium applications, internal company systems, lightweight SaaS, government projects, and any system where **stability matters more than shiny features**.

---

## Why Khumba?

Most modern PHP frameworks evolve rapidly — new features, new architectures, new dependencies, and short support windows. But not every project needs that.

Many systems need to:
- Run for 5–10 years without a major refactor
- Stay maintainable by a small team
- Perform reliably without heavy dependencies
- Avoid frequent major-version upgrades

Khumba is built for exactly that. It combines the clean structure and productivity of Laravel with the simplicity and speed of CodeIgniter — while keeping a firm boundary against unnecessary complexity.

**Core principle: Explicit over Magic.** Every flow is visible. No hidden lifecycles.

---

## Requirements

- PHP 5.6+
- MySQL / MariaDB / PostgreSQL / SQLite
- A web server (Apache or Nginx) with URL rewriting enabled

---

## Installation

**1. Clone the repository**
```bash
git clone https://github.com/chipersage/khumba.git
cd khumba
```

**2. Configure your environment**
```bash
cp .env.example .env
```

Edit `.env` with your settings:
```env
APP_NAME=Khumba
APP_ENV=development
APP_DEBUG=true

DB_HOST=localhost
DB_NAME=your_database
DB_USER=your_username
DB_PASS=your_password
```

**3. Configure your web server**

Point the document root to the `/public` directory.

**Apache** — ensure `mod_rewrite` is enabled, then add a `.htaccess` in `/public`:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
```

**Nginx:**
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

---

## Project Structure

```
/app
    /controller       # Application controllers
    /model            # Application models
    /view             # PHP template views
        /error        # Error pages (404, 500)
/config               # App and database configuration
/public               # Web root (index.php + assets)
/system
    /core             # Framework core classes
    /db               # Database and QueryBuilder
    /middleware       # Middleware classes
    /routes           # Route definitions
.env                  # Environment variables
khumba                # CLI tool
```

Flat, 2-level depth. Easy to navigate. Easy to understand.

---

## Routing

Define routes in `system/routes/web.php`:

```php
Router::get('', 'HomeController@index');
Router::get('about', 'PageController@about');
Router::post('login', 'AuthController@login');

// Dynamic parameters
Router::get('user/{id}', 'UserController@profile');
Router::get('post/{slug}', 'PostController@show');
```

---

## Controllers

```php
class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        $this->view('posts/index', ['posts' => $posts]);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        $this->view('posts/show', ['post' => $post]);
    }
}
```

---

## Models

```php
class Post extends Model
{
    protected static $table = 'posts';
}
```

**Usage:**
```php
// Get all records
$posts = Post::all();

// Find with condition
$post = Post::where('slug', 'hello-world')->first();

// Chained query
$recent = Post::query()
    ->where('status', 'published')
    ->orderBy('created_at', 'DESC')
    ->limit(10)
    ->get();

// Insert
Post::query()->insert([
    'title' => 'Hello World',
    'slug'  => 'hello-world',
]);

// Update
Post::where('id', 1)->update(['title' => 'Updated']);

// Delete
Post::where('id', 1)->delete();
```

---

## Views

Views are plain PHP files — no template engine, no extra parsing, no overhead.

```php
// Render a view
$this->view('home');

// Pass data to a view
$this->view('user/profile', ['user' => $user]);
```

**Example view (`app/view/user/profile.php`):**
```php
<h1>Hello, <?= SecurityHelper::e($user['name']) ?></h1>
```

---

## Forms & CSRF Protection

Always include the CSRF field in your forms:

```php
<form method="POST" action="/login">
    <?= SecurityHelper::csrf_field() ?>
    <input type="text" name="username">
    <button type="submit">Login</button>
</form>
```

Verify on the POST handler:

```php
public function login()
{
    SecurityHelper::verify_csrf();
    // ... handle login
}
```

---

## Session & Auth

```php
// Set a session value
Session::set('key', 'value');

// Get a session value
$value = Session::get('key');

// Destroy session
Session::destroy();

// Auth helpers
Auth::login($userId);   // Store user in session
Auth::check();          // Returns true if logged in
Auth::logout();         // Destroy session
```

---

## Request & Response

```php
// Reading input
$name  = Request::post('name');
$page  = Request::get('page');
$method = Request::method();

// Responses
Response::redirect('/dashboard');
Response::json(['status' => 'ok'], 200);
```

---

## Validation

```php
$v = Validate::check($_POST, [
    'username' => ['required'],
    'email'    => ['required', 'email'],
]);

if ($v->hasError()) {
    $errors = $v->errors();
    // handle errors
}
```

---

## Configuration

**`config/app.php`**
```php
return [
    'name' => 'Khumba',
    'env'  => 'production',
];
```

**`config/database.php`**
```php
return [
    'driver'   => 'mysql',
    'host'     => '127.0.0.1',
    'database' => 'khumba',
    'username' => 'root',
    'password' => '',
    'charset'  => 'utf8',
];
```

Access config values:
```php
$name = Config::get('name');
```

---

## CLI Tool

Generate boilerplate files from the command line:

```bash
# Create a controller
php khumba make:controller Post

# Create a model
php khumba make:model Post
```

---

## Middleware

```php
class AuthMiddleware
{
    public function handle()
    {
        if (!Auth::check()) {
            Response::redirect('/login');
        }
    }
}
```

Call it manually at the top of a controller method:
```php
public function dashboard()
{
    (new AuthMiddleware)->handle();
    $this->view('dashboard');
}
```

---

## Security

Khumba includes essential security out of the box:

| Feature | Implementation |
|---|---|
| CSRF Protection | `SecurityHelper::verify_csrf()` |
| XSS Escaping | `SecurityHelper::e($value)` |
| Secure Headers | Set in `public/index.php` |
| Error Mode | Controlled via `APP_ENV` in `.env` |
| PDO Prepared Statements | All queries use bound parameters |

---

## Design Philosophy

Khumba follows 10 core rules:

1. Don't be more complex than necessary
2. Don't be slower than necessary
3. Don't break old technology without strong reason
4. Stability over new features
5. Stay readable for mid-level developers
6. Minimal external dependencies
7. Configuration where needed, convention everywhere else
8. Fast first-load
9. Flat structure over deep hierarchy
10. New features must preserve performance and simplicity

---

## Who Is Khumba For?

✅ Internal company systems  
✅ Government and public sector applications  
✅ Lightweight SaaS products  
✅ ERP / CRM custom builds  
✅ Admin panels and dashboards  
✅ Projects that need to run reliably for 5–10 years  
✅ Small teams who value clarity over cleverness  

---

## License

MIT License. Free to use, modify, and distribute.

---

> *Khumba doesn't try to be the most modern framework. It tries to be the most consistent.*
