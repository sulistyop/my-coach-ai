# Habit Tracker Application

## Overview
This is a **Habit Tracker Application** designed to help users set goals, track habits, and monitor their progress. The application allows users to:
- Set personal goals with deadlines.
- Create and manage habits with customizable frequencies.
- Track daily or weekly check-ins for habits.
- View habit streaks and weekly progress.
- Stay motivated with daily motivational messages.

The application is built using **PHP** with the **Laravel framework**, and it uses **Blade templates** for the frontend. It also integrates with **Composer** and **npm** for dependency management.

---

## Features
- **Goal Management**: Users can create, edit, and track their goals.
- **Habit Tracking**: Users can define habits, set frequencies, and log check-ins.
- **Streak Calculation**: Automatically calculates habit streaks based on check-ins.
- **Motivational Messages**: Displays daily motivational messages to encourage users.
- **Responsive Design**: Optimized for both desktop and mobile devices.

---

## Requirements
Before installing, ensure you have the following installed on your system:
- PHP >= 8.0
- Composer
- Node.js and npm
- MySQL or any other supported database
- Laravel CLI

---

## Installation

Follow these steps to set up the application:

### 1. Clone the Repository
```bash
git clone https://github.com/sulistyop/my-coach-ai
cd my-coach-ai
```

### 2. Install PHP Dependencies
Run the following command to install Laravel dependencies:
```bash
composer install
```

### 3. Install JavaScript Dependencies
Use npm to install frontend dependencies:
```bash
npm install
```

### 4. Configure Environment
Copy the `.env.example` file to `.env` and configure your database and other environment variables:
```bash
cp .env.example .env
```
Update the `.env` file with your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 5. Generate Application Key
Run the following command to generate the application key:
```bash
php artisan key:generate
```

### 6. Run Migrations
Run the database migrations to set up the required tables:
```bash
php artisan migrate
```

### 7. Build Frontend Assets
Compile the frontend assets using npm:
```bash
npm run dev
```

### 8. Start the Development Server
Run the Laravel development server:
```bash
php artisan serve
```
The application will be available at `http://127.0.0.1:8000`.

---

## Usage
1. Register or log in to the application.
2. Navigate to the **Setup Goals** page to create your goals.
3. Go to the **Setup Habits** page to define your habits and their frequencies.
4. Log your daily or weekly check-ins to track progress.
5. View your habit streaks and weekly check-in stats on the dashboard.

---

## Contributing
Feel free to fork this repository and submit pull requests. Contributions are welcome!

---

## License
This project is open-source and available under the [MIT License](LICENSE).