# Vehicle Requisition System - Laravel Application

A comprehensive vehicle requisition management system built with Laravel 10+ for Oxfam Bangladesh.

## Features

### User Roles
1. **Guest User**: Can view public information
2. **Authenticated User**: Can submit vehicle requisition forms and manage their profile
3. **Admin**: Full system access, can view all activities, export data to Excel/PDF

### Core Functionality
- Vehicle requisition form submission
- User profile management
- Admin dashboard with analytics
- Activity logging and monitoring
- Export data to Excel and PDF formats
- Multi-user authentication system

## Requirements

- PHP >= 8.1
- Composer
- MySQL >= 5.7 or PostgreSQL
- Node.js & NPM (for frontend assets)

## Installation

### 1. Clone or Extract the Project

```bash
cd your-project-directory
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vehicle_requisition
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Migrations and Seeders

```bash
php artisan migrate --seed
```

This will create:
- Admin user: admin@oxfam.org / password123
- Test user: user@oxfam.org / password123

### 6. Install Frontend Dependencies

```bash
npm install
npm run build
```

### 7. Start the Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

## User Credentials (Default)

### Admin Access
- Email: admin@oxfam.org
- Password: password123

### Regular User
- Email: user@oxfam.org
- Password: password123

## Project Structure

```
vehicle-requisition-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UserController.php
│   │   │   │   └── ExportController.php
│   │   │   ├── Auth/
│   │   │   ├── ProfileController.php
│   │   │   └── VehicleRequisitionController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── VehicleRequisition.php
│   │   ├── Passenger.php
│   │   └── ActivityLog.php
│   └── Exports/
│       └── RequisitionsExport.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── profile/
│       └── requisitions/
└── routes/
    └── web.php
```

## Usage Guide

### For Regular Users

1. **Register/Login**: Create an account or login
2. **Submit Requisition**: Fill out the vehicle requisition form
3. **View Profile**: Manage your personal information
4. **Track Submissions**: View your requisition history

### For Admins

1. **Dashboard**: View system statistics and recent activities
2. **User Management**: View and manage all users
3. **Requisition Management**: View, approve, or reject requisitions
4. **Export Data**: Download requisitions as Excel or PDF
5. **Activity Logs**: Monitor all user activities

## Export Features

### Excel Export
- Download all requisitions with full details
- Includes user information, journey details, and budget codes
- Supports filtering by date range

### PDF Export
- Generate formatted PDF reports
- Individual requisition forms
- Batch export multiple requisitions

## Security Features

- CSRF protection on all forms
- Password hashing with Bcrypt
- Role-based access control
- Activity logging
- Session management

## API Documentation

### Export Endpoints

```
GET /admin/export/excel - Export all requisitions to Excel
GET /admin/export/pdf - Export all requisitions to PDF
GET /admin/export/requisition/{id}/pdf - Export single requisition
```

## Customization

### Adding New Fields

1. Create migration:
```bash
php artisan make:migration add_field_to_vehicle_requisitions
```

2. Update model in `app/Models/VehicleRequisition.php`
3. Update form view in `resources/views/requisitions/create.blade.php`
4. Update controller validation

### Modifying User Roles

Edit `database/seeders/UserSeeder.php` to add more roles or permissions.

## Troubleshooting

### Common Issues

**Database Connection Error**
- Check `.env` database credentials
- Ensure MySQL/PostgreSQL is running
- Create database manually if it doesn't exist

**Permission Errors**
- Set proper permissions: `chmod -R 775 storage bootstrap/cache`
- Ensure web server user has access

**Export Not Working**
- Run: `composer require maatwebsite/excel`
- Run: `composer require barryvdh/laravel-dompdf`

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is proprietary software for Oxfam Bangladesh.

## Support

For issues or questions, contact your system administrator.

## Version History

- v1.0.0 (2025-01-01): Initial release
  - User authentication
  - Vehicle requisition forms
  - Admin dashboard
  - Excel/PDF export
  - Activity logging