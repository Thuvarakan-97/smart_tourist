# 🌍 Smart Tourist - Laravel Application

A comprehensive travel booking platform built with Laravel that connects tourists with local accommodation and vehicle owners. The application supports 4 different user roles: Admin, Tourist, Room Owner, and Vehicle Owner.

## 🚀 Features

### For Tourists
- Browse and book accommodations and vehicles
- View popular destinations with ratings and descriptions
- Manage booking history and status
- Real-time booking confirmations

### For Accommodation Owners
- List and manage accommodation properties
- View and respond to booking requests
- Track earnings and availability
- Manage property details and pricing

### For Vehicle Owners
- List and manage vehicle rentals
- Handle booking requests and confirmations
- Set availability dates and pricing
- Track rental history

### For Administrators
- Monitor all bookings and users
- View system statistics and analytics
- Manage destinations and content
- Oversee platform operations

## 🛠️ Technology Stack

- **Backend**: Laravel 11.x
- **Frontend**: Blade Templates with Tailwind CSS
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Breeze
- **Styling**: Tailwind CSS

## 📋 Prerequisites

Before running this application, make sure you have the following installed:

- PHP 8.2 or higher
- Composer
- MySQL/PostgreSQL
- Node.js and NPM (for frontend assets)

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd smart_tourist
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Edit `.env` file and update database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=smart_tourist
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

## 👥 Default Users

The application comes with pre-seeded users for testing:

### Admin
- **Email**: admin@gmail.com
- **Password**: password
- **Role**: Admin

### Tourist
- 
- **Password**: password
- **Role**: Tourist

### Room Owner
- **Email**: kavindu@gmail.com
- **Password**: password
- **Role**: Room Owner

### Vehicle Owner
- **Email**: rashmi@gmail.com
- **Password**: password
- **Role**: Vehicle Owner

## 🗄️ Database Structure

### Core Tables

1. **users** - User accounts with role-based access
2. **destinations** - Tourist destinations with ratings and coordinates
3. **accommodations** - Accommodation listings by room owners
4. **vehicles** - Vehicle rentals by vehicle owners
5. **bookings** - Booking records for accommodations and vehicles

### Relationships

- Users can have multiple accommodations (room owners)
- Users can have multiple vehicles (vehicle owners)
- Users can have multiple bookings (tourists)
- Accommodations belong to destinations
- Bookings reference either accommodations or vehicles

## 🎨 Frontend Features

### Beautiful Landing Page
- Modern, responsive design with tourist imagery
- Feature highlights for each user role
- Call-to-action sections for registration

### Role-Based Dashboards
- **Admin Dashboard**: System statistics and recent bookings
- **Tourist Dashboard**: Available accommodations, vehicles, and booking history
- **Room Owner Dashboard**: Property management and booking requests
- **Vehicle Owner Dashboard**: Vehicle management and rental requests

### Responsive Design
- Mobile-friendly interface
- Tailwind CSS for consistent styling
- Modern UI components

## 🔐 Authentication & Authorization

- Laravel Breeze for authentication
- Role-based middleware for route protection
- Secure password hashing
- Session management

## 📱 API Endpoints

The application includes RESTful API endpoints for:

- User management
- Destination browsing
- Accommodation listings
- Vehicle rentals
- Booking management

## 🚀 Deployment

### Production Setup

1. **Environment Configuration**
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Database Migration**
   ```bash
   php artisan migrate --force
   ```

3. **Cache Configuration**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

4. **Storage Setup**
   ```bash
   php artisan storage:link
   ```

## 📊 Sample Data

The application includes sample data for:

- **3 Destinations**: Sigiriya Rock Fortress, Galle Fort, Ella
- **2 Accommodations**: Sigiriya View Hotel, Ella Paradise Inn
- **3 Vehicles**: Car, Tuk-tuk, Van
- **3 Sample Bookings**: Various statuses and types

## 🔧 Customization

### Adding New Roles
1. Update the `User` model's role constants
2. Add role middleware checks
3. Create corresponding dashboard views
4. Update the `DashboardController`

### Adding New Features
1. Create new models and migrations
2. Add controllers and routes
3. Create Blade views
4. Update seeders with sample data

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check `.env` database credentials
   - Ensure database server is running

2. **Permission Errors**
   - Set proper permissions on storage and bootstrap/cache directories
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

3. **Asset Compilation Issues**
   - Clear NPM cache: `npm cache clean --force`
   - Reinstall dependencies: `npm install`

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📞 Support

For support and questions, please contact the development team or create an issue in the repository.

---

**Smart Tourist** - Making travel booking smarter and more accessible! 🌍✈️
