# Khumba Framework (PHP Framework)

Lightweight. Pragmatic. Stable. Long-term.

Khumba is a lightweight PHP framework designed to be pragmatic, stable, and long-lasting.
It focuses on balancing modern structure, simplicity, performance, and backward compatibility.

Khumba is not an experimental or hyper-modern framework.
It is built for real-world production use in:

Small to medium applications
Internal systems
Lightweight SaaS products
Long-term maintainable projects

Key Features
1. Lightweight MVC Core

Flat 2-level directory structure
Simple Router
Minimal Base Controller
Native PHP Views (no Blade / Twig)
No external dependencies
No service container
No magic abstractions

2. PDO-Based Database Core

✔ Singleton PDO Connection
Centralized connection management
Portable across drivers
Exception-based error handling

✔ Lightweight Fluent Query Builder
Supports:
where()
orderBy()
limit()
get()
first()
insert()
update()
delete()

3. Minimal Hybrid Model Layer

4. Design Philosophy
Khumba follows these principles:
Pragmatic over Trendy
Simple but Powerful
Backward Friendly
Fast by Default
Stability over Fancy Features

Khumba intentionally avoids:
Heavy service containers
Mandatory Composer dependencies
Over-abstracted architecture
Rapid breaking changes

Requirements
PHP 5.6+
PDO extension
MySQL / MariaDB / PostgreSQL / SQLite
