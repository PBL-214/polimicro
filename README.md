# Polimicro - Tech Scholar Platform 🎓

Polimicro is a premium, high-performance Microcredential learning platform designed with a modern "Tech Scholar" identity. It provides a seamless experience for Students, Lecturers, and Administrators to manage academic progress and certifications.

![Banner](https://img.shields.io/badge/Status-Development-blueviolet?style=for-the-badge)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

## ✨ Key Features

### 👨‍🎓 Student Experience
- **Visual Learning Roadmap**: Courses displayed as an interactive connected path.
- **Achievement Badges**: Gamified "Lencana Keahlian" that unlocks upon program completion.
- **Radial Progress Tracking**: Real-time program completion monitoring.
- **Mobile-First Navigation**: Optimized bottom navigation bar for a native app feel.

### 👨‍🏫 Lecturer Dashboard
- **Emerald Theme**: Specialized UI for monitoring student submissions.
- **Real-time Grading**: Directly evaluate assignments with feedback.
- **Course Management**: Full control over materials and tasks.

### 🛡️ Admin & Control
- **Dual Admin Roles**: Specialized dashboards for PIC (Verifications) and Akademik (Master Data).
- **Notification Center**: Functional, database-driven notification system for all roles.
- **Glassmorphism UI**: High-end visual aesthetic with subtle blur and transparency effects.

## 🛠️ Tech Stack
- **Framework**: Laravel 11
- **Styling**: Tailwind CSS & Vanilla CSS (Custom Design Tokens)
- **Database**: MySQL
- **Icons**: FontAwesome 6
- **Charts**: Chart.js 4

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/PBL-214/polimicro.git
   cd polimicro
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment**
   - Rename `.env.example` to `.env`
   - Set your database credentials
   - Generate app key: `php artisan key:generate`

4. **Run Migrations**
   ```bash
   php artisan migrate
   ```

5. **Start the server**
   ```bash
   php artisan serve
   ```

## 🎨 Design Identity
Polimicro uses a **Cyan-Slate** color palette for students, **Emerald** for lecturers, and **Indigo** for administration, creating a distinct yet harmonious user experience.

---
Developed with ❤️ by the PBL-214 Team.
