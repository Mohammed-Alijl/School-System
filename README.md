# 🎓 EduCore ERP & LMS (Work In Progress)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)

EduCore is a modern, enterprise-grade School Enterprise Resource Planning (ERP) and Learning Management System (LMS) built with Laravel. It is designed with a focus on **Clean Architecture, SOLID principles, and scalable database design** to handle high-traffic school environments.

## 🚀 Project Vision
The goal of this project is to create a seamless, frictionless educational ecosystem with dedicated dashboards for Admins, Teachers, and Students, topped with a fully documented RESTful API for mobile integrations.

## 🏗️ Architecture & Backend Highlights
This is not a standard CRUD application. It features complex business logic and advanced database relationship handling:
* **Dynamic Random Exam Engine:** A custom-built exam module where questions are pulled randomly from a central Question Bank, securely locked to a student's session to survive internet disconnections.
* **Disaster Recovery (Admin Override):** Built-in fail-safes allowing administrators to gracefully reset stuck exam attempts and manage exceptions.
* **Smart Virtual Classrooms:** Dual-integration logic supporting both automated Zoom API meetings and manual external links (Google Meet/Teams) seamlessly.
* **Skinny Controllers & Service Pattern:** Heavy business logic is decoupled into dedicated Service classes, ensuring controllers remain clean and strictly handle HTTP requests.
* **Strict Data Integrity:** Custom FormRequests and localized middleware constraints prevent dirty data and secure all administrative endpoints.

## ✨ Features Roadmap

### 🛡️ Admin Dashboard (Completed)
- [x] Global Academic Year Management
- [x] Grades, Classrooms, and Sections mapping
- [x] Advanced Filters & DataTables Integration
- [x] Exam Global Monitoring & Disaster Recovery
- [x] Online Classes Overseeing & Inspection

### 👨‍🏫 Teacher Dashboard (In Development ⏳)
- [ ] Centralized Question Bank Management
- [ ] Custom Exam Creation (Max attempts, Grading methods, Time windows)
- [ ] Zoom API Integration for one-click Virtual Classes
- [ ] Real-time Student Evaluation

### 👨‍🎓 Student Dashboard (Upcoming)
- [ ] Smart Exam taking interface
- [ ] Dynamic schedule and join buttons for Virtual Classes
- [ ] Automated Grading and Results

### 📱 RESTful API (Upcoming)
- [ ] JWT Authentication
- [ ] Mobile-ready endpoints for students and parents

## 💻 Tech Stack
* **Backend:** Laravel 11, PHP 8.2
* **Frontend:** Blade Templates, Bootstrap 4/5 (Valex Theme), jQuery, DataTables, SweetAlert2
* **Database:** MySQL
* **Permissions:** Spatie Permission Package

## ⚙️ Installation (Local Development)

```bash
# 1. Clone the repository
git clone [https://github.com/YourUsername/educore-erp.git](https://github.com/YourUsername/educore-erp.git)

# 2. Install Dependencies
composer install
npm install

# 3. Environment Setup
cp .env.example .env
php artisan key:generate

# 4. Database Setup (Ensure MySQL is running)
php artisan migrate --seed

# 5. Serve the application
php artisan serve
