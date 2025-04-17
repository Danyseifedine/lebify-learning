# Lebify Learning

A modern e-learning platform built with Laravel that connects Lebanese instructors with students seeking quality education resources.

## 🚀 Features

- **User Authentication**: Secure registration and login system for students and instructors
- **Course Management**: Create, update, and manage comprehensive courses with multiple modules
- **Interactive Learning**: Embedded videos, quizzes, and assignments to enhance learning experience
- **Payment Integration**: Secure payment processing for course purchases
- **Progress Tracking**: Monitor student progress through course materials
- **Certificate Generation**: Automatic certificate generation upon course completion
- **Responsive Design**: Mobile-friendly interface for learning on any device

## 💻 Tech Stack

- **Backend**: Laravel 10.x
- **Frontend**: Blade templates, Tailwind CSS, Alpine.js
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **File Storage**: AWS S3
- **Payment Processing**: Stripe

## 📋 Prerequisites

- PHP 8.1+
- Composer
- Node.js and npm
- MySQL

## 🔧 Installation

1. Clone the repository:
```bash
git clone https://github.com/Danyseifedine/lebify-learning.git
cd lebify-learning
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in the `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lebify_learning
DB_USERNAME=root
DB_PASSWORD=
```

7. Run migrations:
```bash
php artisan migrate
```

8. Compile assets:
```bash
npm run dev
```

9. Start the development server:
```bash
php artisan serve
```

## 🔍 Usage

- Visit `http://localhost:8000` to access the application
- Register as a student or instructor
- Browse available courses or create your own as an instructor
- Purchase courses using the integrated payment system
- Track your progress and earn certificates

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/amazing-feature`)
3. Commit your Changes (`git commit -m 'Add some amazing feature'`)
4. Push to the Branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📧 Contact

Dany Seifedine - [@DanySeifedine](https://github.com/Danyseifedine)

Project Link: [https://github.com/Danyseifedine/lebify-learning](https://github.com/Danyseifedine/lebify-learning)