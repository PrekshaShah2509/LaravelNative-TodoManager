# 📝 Laravel Todo App with NativePHP

A desktop Todo application built with Laravel 11 and [NativePHP](https://nativephp.com), using SQLite.

---

## 🚀 Features

- ✅ Create, read, update, delete todo items
- 🔁 Mark todos as completed/incomplete
- 🖥️ Native desktop app (cross-platform)
- 🧩 Native menus and window settings

---
## 📸 Screenshot

This screenshot shows the main dashboard of a simple, responsive Todo app built with Laravel 11 and NativePHP. You can add, edit, mark complete, or delete tasks—all from a clean, mobile-friendly interface inside a native desktop window.

![Todo App Screenshot](/public/assets/screenshots/todo-app-screenshot.png)

---

## ⚙️ Requirements

- PHP 8.1 or higher
- Composer
- Laravel 11.x
- Node.js and npm
- SQLite
- NativePHP CLI tools

---

## 🛠️ Installation

### 1. Clone the repository

```bash
git clone https://github.com/yourusername/todo-native.git
cd todo-native
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install NativePHP and Electron

```bash
composer require nativephp/laravel
php artisan native:install
composer require nativephp/electron
```

> ⚠️ Electron is required for native builds.

### 4. Copy and configure `.env`

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure your database

**For SQLite:**

```env
DB_CONNECTION=sqlite
DB_DATABASE=./database/database.sqlite
```

Create the file:

```bash
touch database/database.sqlite
```
---

## 🗃️ Database Migrations

```bash
# Standard migration
php artisan migrate

# For native context
php artisan migrate:native
```

---

## 💻 Running the App

### Launch in development:

```bash
php artisan native:serve
```

### Launch with debug mode:

```bash
php artisan native:serve --debug
```

---

## 📦 Build for Distribution

```bash
php artisan native:build
```

Builds are saved in the `dist/` directory.

---

## 🧩 NativePHP Setup

Your native menu and window config lives in `app/Providers/NativeAppServiceProvider.php`:
---
---

## 🗂️ Project Structure

- `app/Models/Todo.php` – Eloquent model
- `app/Http/Controllers/TodoController.php` – Controller logic
- `resources/views/todos/` – Blade views
- `routes/web.php` – App routes
- `app/Providers/NativeAppServiceProvider.php` – NativePHP config
- `database/` – SQLite or migrations
- `public/` – Public assets

---

## 🐞 Troubleshooting

### NativePHP issues

- Ensure NativePHP is installed and linked properly
- Electron must be installed (`composer require nativephp/electron`)
- Restart if changes to the menu don’t reflect

### App won’t launch

- Check logs: `storage/logs/laravel.log`
- Ensure named routes like `todos.index` and `todos.create` exist

---

## 🤝 Contributing

1. Fork the repo
2. Create a branch: `git checkout -b feature/my-feature`
3. Commit your changes: `git commit -am 'Add feature'`
4. Push to GitHub: `git push origin feature/my-feature`
5. Submit a Pull Request

---

## 🪪 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file.