# Talunton RIASEC System

Web application for career matching and educational guidance based on John Holland's RIASEC framework. Built with PHP, MySQL, Apache, Tailwind CSS, and Vue.js.

---

## 🚀 Local Setup Instructions (XAMPP)

Follow these steps to run this project on another computer:

### 1. Requirements
- **XAMPP** (with Apache and MySQL / MariaDB, PHP 8.1+)
- Web browser (Chrome, Edge, Firefox, etc.)

---

### 2. Copy the Project Folder
1. Copy or clone the `riasec` project directory into your XAMPP web root:
   ```
   C:\xampp\htdocs\riasec
   ```

---

### 3. Configure the Environment (`.env`)
1. Ensure a `.env` file exists in the root folder (`C:\xampp\htdocs\riasec\.env`).
2. If missing, copy `.env.example` to `.env`:
   ```env
   DB_HOST=localhost
   DB_USER=root
   DB_PASS=
   DB_NAME=riasec_db

   SMTP_HOST=smtp.gmail.com
   SMTP_PORT=587
   SMTP_ENCRYPTION=tls
   SMTP_USERNAME=your_gmail_here@gmail.com
   SMTP_APP_PASSWORD=your_google_app_password
   SMTP_FROM_EMAIL=your_gmail_here@gmail.com
   SMTP_FROM_NAME="Talunton RIASEC"
   ```
   *(For standard XAMPP, `DB_USER=root` and `DB_PASS=` empty are default).*

---

### 4. Import the Database
1. Open the **XAMPP Control Panel** and start **Apache** and **MySQL**.
2. Open your browser and go to phpMyAdmin:
   ```
   http://localhost/phpmyadmin
   ```
3. Click the **Import** tab.
4. Choose the file located at:
   ```
   C:\xampp\htdocs\riasec\database\riasec_db.sql
   ```
5. Click **Import** (or **Go**) at the bottom.
   > The SQL dump automatically creates the `riasec_db` database, all 12 tables, all RIASEC assessment questions, course quizzes, colleges, degrees, and the initial admin account.

---

### 5. Access the Application
Open your web browser:
- **Public / Student Portal**:
  [http://localhost/riasec](http://localhost/riasec)
- **Admin Portal**:
  [http://localhost/riasec/admin](http://localhost/riasec/admin) or [http://localhost/riasec/admin/login.php](http://localhost/riasec/admin/login.php)

#### Default Admin Credentials:
- **Username**: `admin`
- **Password**: `admin 123`

---

### 6. Apache `.htaccess` Verification
Ensure Apache `mod_rewrite` is enabled in XAMPP (enabled by default in XAMPP) so clean routing (`/assessment`, `/degrees`, `/results`, `/login`, etc.) works seamlessly.
