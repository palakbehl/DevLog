# DevLog CMS & Portfolio Workstation

DevLog CMS is a modern, minimalist developer CMS and portfolio gateway built using **Laravel 12**, **Tailwind CSS v4**, and **Alpine.js**. The user interface has been designed with a high-fidelity SaaS dashboard aesthetic inspired by Linear, Vercel, and GitHub.

---

## 🚀 Key Features

* **Role-Based Workspaces**: Scoped dashboard capabilities for **Administrators** (who can manage all resources) and **Authors** (who can write diaries, manage their own posts, and track their own showcase items).
* **Blog Posts Management**: Clean, responsive layout to write, edit, and delete blog articles. Includes custom Alpine.js modal confirmations, image upload support, and a draft/published status toggle.
* **Portfolio Showcase**: Index and highlight software projects, repositories, technology tags, and live demos in a grid of cards.
* **Public Gateway Hub**: A public landing page displaying a developer homepage, a portfolio grid (`?view=portfolio`), and high-typography blog reader details (`?post=slug`).
* **SaaS Profile Settings**: Unified, theme-compliant pages to update profile information, change passwords, and request account deletion.
* **Optimized dark & light mode**: Systematically audited color configurations using Tailwind CSS standard weights to ensure legibility and contrast.

---

## 🛠️ Technology Stack

* **Core**: Laravel 12 (PHP 8.2+)
* **Frontend templating**: Blade Templates & Laravel Breeze
* **Styling**: Tailwind CSS v4 & Google Font "Inter"
* **Interactivity**: Alpine.js
* **Asset bundler**: Vite (using `@tailwindcss/vite` plugin)
* **Database**: MySQL

---

## 💻 Installation & Setup

1. **Clone the Repository**:
   ```bash
   git clone <repository-url>
   cd DevLog2
   ```

2. **Install Composer Dependencies**:
   ```bash
   composer install
   ```

3. **Install NPM Dependencies**:
   ```bash
   npm install
   ```

4. **Environment Configuration**:
   Copy the example environment file and configure your database settings:
   ```bash
   cp .env.example .env
   # Generate application key
   php artisan key:generate
   ```

5. **Run Migrations & Seed Database**:
   Seed the database with pre-configured Admin and Author test accounts:
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Build Frontend Assets**:
   Run the Vite development server or build production bundles:
   ```bash
   # For local hot reloading
   npm run dev

   # For production build
   npm run build
   ```

7. **Start Laravel Server**:
   ```bash
   php artisan serve
   ```
   Access the application at `http://127.0.0.1:8000`.

---

## 🔐 Seeder & Test Accounts

Running `php artisan db:seed` registers two pre-configured profiles so you can immediately inspect role-based scopes:

| Profile | Email Address | Password | Scopes |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@example.com` | `password` | Reads and manages all posts & projects inside CMS |
| **Author** | `author@example.com` | `password` | Creates and manages only their own posts & projects |

---

## 📂 Directory Structure Highlights

* `resources/views/layouts/app.blade.php`: The main layout wrapper with desktop sidebar, Alpine-driven mobile drawer, and active links mapping.
* `resources/views/components/`: Reusable custom UI components (`card`, `button`, `form-input`, `textarea`, `stat-card`, `alert`).
* `resources/views/welcome.blade.php`: Public-facing router loading homepage widgets, portfolio card grids, and single article pages.
* `database/seeders/DatabaseSeeder.php`: Wipes old data and populates fresh test accounts with custom posts/projects.
