# Troubleshooting Guide

## Common Issues and Solutions

### 1. ERR_TOO_MANY_REDIRECTS Error

**Problem**: After importing the SQL database, you get a redirect loop error when trying to login.

**Solution**: 
- The issue has been fixed in the `DashboardController.php`
- If you still experience this issue:
  1. Clear your browser cookies and cache
  2. Make sure you're using the correct login credentials
  3. Check that the database import was successful

### 2. Registration Not Saving to Database

**Problem**: When registering a new user, the user is not saved to the database.

**Solution**: 
- ✅ **FIXED**: The registration form now includes role selection
- ✅ **FIXED**: The `RegisteredUserController` now properly saves role and token
- New users must select a role (Tourist, Room Owner, or Vehicle Owner)
- The system automatically generates a unique token for each user

**To test registration**:
1. Visit: http://127.0.0.1:8000/register
2. Fill in all fields including role selection
3. Check database: http://127.0.0.1:8000/test-users

### 3. Database Connection Issues

**Problem**: Cannot connect to database after importing SQL.

**Solution**:
1. Check your `.env` file database configuration:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=smart_tourist
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

2. Run migrations to ensure all tables exist:
   ```bash
   php artisan migrate:fresh --seed
   ```

### 4. User Authentication Issues

**Problem**: Cannot login with provided credentials.

**Solution**:
1. Use these default credentials:
   - **Admin**: admin@gmail.com / password
   - **Tourist**: amal@gmail.com / password
   - **Room Owner**: kavindu@gmail.com / password
   - **Vehicle Owner**: rashmi@gmail.com / password

2. If still having issues, check the database:
   ```sql
   SELECT id, name, email, role FROM users;
   ```

### 5. Role-Based Access Issues

**Problem**: Users can't access their specific dashboards.

**Solution**:
1. Verify the user has a valid role in the database
2. Check that the RoleMiddleware is properly registered
3. Clear application cache:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   ```

### 6. Missing Dependencies

**Problem**: Application won't start or has errors.

**Solution**:
1. Install dependencies:
   ```bash
   composer install
   npm install
   ```

2. Generate application key:
   ```bash
   php artisan key:generate
   ```

3. Build assets:
   ```bash
   npm run build
   ```

### 7. Testing the Application

**To test if everything is working**:

1. Start the server:
   ```bash
   php artisan serve
   ```

2. Visit: http://127.0.0.1:8000

3. Test registration:
   - Visit: http://127.0.0.1:8000/register
   - Fill in all fields including role selection
   - Check if user is saved: http://127.0.0.1:8000/test-users

4. Test authentication:
   - Visit: http://127.0.0.1:8000/test-auth (after login)
   - This will show your user information

5. Login with any of the provided credentials

6. You should be redirected to the appropriate dashboard based on your role

### 8. Database Verification

**To verify your database is properly set up**:

1. Check if all tables exist:
   ```bash
   php artisan migrate:status
   ```

2. Verify sample data:
   ```bash
   php artisan tinker
   ```
   Then run:
   ```php
   App\Models\User::all();
   App\Models\Destination::all();
   App\Models\Accommodation::all();
   App\Models\Vehicle::all();
   App\Models\Booking::all();
   ```

3. Check users via web route:
   - Visit: http://127.0.0.1:8000/test-users

### 9. Common Error Messages

- **"Class not found"**: Run `composer dump-autoload`
- **"Route not found"**: Run `php artisan route:clear`
- **"View not found"**: Check if all Blade files exist in `resources/views/`
- **"Database connection failed"**: Check `.env` file and database server
- **"Role is required"**: Make sure to select a role during registration

### 10. Performance Issues

**If the application is slow**:

1. Clear all caches:
   ```bash
   php artisan optimize:clear
   ```

2. Check database indexes
3. Monitor server resources

### 11. Getting Help

If you're still experiencing issues:

1. Check the Laravel logs: `storage/logs/laravel.log`
2. Enable debug mode in `.env`: `APP_DEBUG=true`
3. Check the browser console for JavaScript errors
4. Verify all file permissions are correct

## Quick Fix Commands

```bash
# Clear all caches
php artisan optimize:clear

# Regenerate autoload files
composer dump-autoload

# Reset database
php artisan migrate:fresh --seed

# Generate new application key
php artisan key:generate

# Clear browser cache and cookies
# (Do this manually in your browser)
```

## Recent Fixes Applied

### ✅ Registration System Fixed
- Added role selection dropdown to registration form
- Updated `RegisteredUserController` to handle role and token generation
- New users now properly save to database with role and token

### ✅ Redirect Loop Fixed
- Fixed `DashboardController` to handle invalid roles properly
- Users with invalid roles are now logged out instead of causing redirect loops

### ✅ Database Seeding Fixed
- Added proper `BookingSeeder` with sample data
- All seeders now work correctly with proper relationships
