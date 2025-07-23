# 📝 Microblogging Platform

A minimalist microblogging platform built with Laravel 12. Designed for programmers to share concise technical insights, code snippets, and development experiences. Focused on clarity, speed, and simplicity.

---

## 🚀 Features

- 🔐 **User Authentication** powered by Laravel Breeze
- ✍️ **Create & Read Microblogs** — fast posting of short developer-focused content
- 📦 **Markdown Support** via `league/commonmark` (write posts using clean markdown)
- 💾 **SQLite Database** — ideal for lightweight local or single-user usage
- 🖥️ **Blade UI** — fully server-rendered UI using Laravel Blade
- ⚡ **Alpine.js** — Dynamic UI elements, lightweight interactivity with no extra JS framework
- 📱 Responsive and minimal UI for clean reading experience

---

## 🧰 Tech Stack

| Layer           | Technology          |
| --------------- | ------------------- |
| Backend         | Laravel 12          |
| Authentication  | Laravel Breeze      |
| Database        | SQLite              |
| UI              | Blade UI            |
| Interactivty    | AlpineJS            |
| Markdown        | CommonMark          |
| Frontend Build  | Vite + Tailwind CSS |
| Package Manager | npm / yarn          |

---

## 📦 Requirements

- PHP 8.1 or higher
- Composer
- Node.js (see `.nvmrc` for version)
- npm or yarn
- SQLite (included on most systems)

---

## ⚙️ Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/rafael-miano/microblogging-platform.git
    cd microblogging-platform
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Install Node dependencies**

    ```bash
    npm install
    # or
    yarn install
    ```

4. **Set up your environment**
    ```Copy .env.example and rename to .env or use the command below```
    ```bash
    cp .env.example .env
    ```

    Then update your `.env` file with:

    ```env
    DB_CONNECTION=sqlite
    # DB_HOST=127.0.0.1
    # DB_PORT=3306
    # DB_DATABASE=laravel
    # DB_USERNAME=root
    # DB_PASSWORD=
    ```

5. **Generate the application key**

    ```bash
    php artisan key:generate
    ```
---

### 6. **Run migrations**

It will create the database tables **and seed initial data** like default categories and a user account.

```bash
php artisan migrate --seed
```

> ✅ A default user will be created:
>
> * **Email:** `rafael@miano.com`
> * **Password:** `password`
>
> ⚠️ Make sure to change this in production.


7. **Build frontend assets**

    ```bash
    npm run dev
    ```

8. **Serve the application**

    ```bash
    php artisan serve
    ```

Visit: http://localhost:8000

---

## 🙌 Contributing

Pull requests and issues are welcome. Please keep the code clean and aligned with Laravel best practices.

---

## 📄 License

This project is open-sourced under the [MIT license](LICENSE).

---

**Made for developers, by developers.**
=======