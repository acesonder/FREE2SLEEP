# FREE2SLEEP Database Setup Guide

This guide will help you set up the MySQL database backend for the FREE2SLEEP crisis centre application.

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher (or MariaDB 10.2+)
- Web server (Apache, Nginx, or PHP built-in server)
- PHPMyAdmin (optional but recommended)

## Installation Steps

### 1. Install Required Software

#### On Windows (using XAMPP)
1. Download and install [XAMPP](https://www.apachefriends.org/)
2. XAMPP includes: Apache, MySQL, PHP, and PHPMyAdmin
3. Start Apache and MySQL from the XAMPP Control Panel

#### On macOS (using MAMP)
1. Download and install [MAMP](https://www.mamp.info/)
2. MAMP includes: Apache, MySQL, PHP, and PHPMyAdmin
3. Start servers from MAMP application

#### On Linux (Ubuntu/Debian)
```bash
sudo apt update
sudo apt install apache2 mysql-server php php-mysql phpmyadmin
sudo systemctl start apache2
sudo systemctl start mysql
```

### 2. Create the Database

#### Option A: Using PHPMyAdmin (Recommended)
1. Open PHPMyAdmin in your browser:
   - XAMPP: `http://localhost/phpmyadmin`
   - MAMP: `http://localhost:8888/phpmyadmin`
   - Linux: `http://localhost/phpmyadmin`

2. Click on "Import" tab
3. Click "Choose File" and select `database/schema.sql`
4. Click "Go" to execute the SQL script
5. Verify that `free2sleep_db` database has been created with all tables

#### Option B: Using MySQL Command Line
```bash
mysql -u root -p < database/schema.sql
```

### 3. Configure Database Connection

Edit the file `api/config.php` and update the database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');          // Change if needed
define('DB_PASS', '');              // Add your MySQL password
define('DB_NAME', 'free2sleep_db');
define('DB_CHARSET', 'utf8mb4');
```

### 4. Set Up File Permissions

Ensure the web server has write permissions to the uploads directory:

```bash
# Linux/macOS
chmod 755 uploads/
chown www-data:www-data uploads/

# Windows (XAMPP)
# Grant full permissions to the uploads folder through Windows Explorer
```

### 5. Configure Web Server

#### Apache (.htaccess already included)
Make sure `mod_rewrite` is enabled:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### PHP Built-in Server (for testing only)
```bash
cd /path/to/FREE2SLEEP
php -S localhost:8000
```

Access the application at: `http://localhost:8000`

### 6. Test the Setup

1. Open `http://localhost/FREE2SLEEP/` in your browser
2. Fill out any form (e.g., Bed Intake)
3. Go to Admin panel (passcode: 079777)
4. Verify that the submitted data appears in the dashboard

## Database Structure

### Tables Created

- **client_intakes** - Client intake form submissions
- **bed_intakes** - Emergency bed requests
- **shower_signups** - Shower program registrations
- **laundry_registrations** - Laundry service signups
- **service_referrals** - Service referral requests
- **messages** - Messaging system data
- **documents** - Document metadata
- **case_notes** - Case management notes
- **admin_users** - Admin user accounts
- **admin_sessions** - Admin session management
- **user_preferences** - User preferences (language, etc.)

## Using PHPMyAdmin

### Viewing Data
1. Open PHPMyAdmin
2. Select `free2sleep_db` from the left sidebar
3. Click on any table name to view its data
4. Use the "Browse" tab to see all records
5. Use the "Search" tab to find specific records

### Exporting Data
1. Select the database or table
2. Click "Export" tab
3. Choose format (SQL, CSV, Excel, etc.)
4. Click "Go" to download

### Importing Data
1. Select the database
2. Click "Import" tab
3. Choose file to import
4. Click "Go"

### Managing Users
1. Click "User accounts" at the top
2. Add new users with specific privileges
3. Recommended: Create a user with limited permissions for the application

## Security Recommendations

### Production Deployment

1. **Change Default Credentials**
   ```php
   // In api/config.php
   define('DB_USER', 'free2sleep_user'); // Don't use 'root'
   define('DB_PASS', 'secure_password'); // Use a strong password
   ```

2. **Disable Error Display**
   ```php
   // In api/config.php (for production)
   error_reporting(0);
   ini_set('display_errors', 0);
   ```

3. **Enable HTTPS**
   - Get an SSL certificate (Let's Encrypt is free)
   - Configure your web server to use HTTPS
   - Update CORS settings in `config.php`

4. **Restrict File Permissions**
   ```bash
   chmod 600 api/config.php  # Only readable by web server
   chmod 750 database/       # No public access
   ```

5. **Regular Backups**
   - Schedule daily database backups
   - Store backups in a secure location
   - Test restoration process regularly

### Database User Creation

Create a dedicated MySQL user for the application:

```sql
CREATE USER 'free2sleep_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON free2sleep_db.* TO 'free2sleep_user'@'localhost';
FLUSH PRIVILEGES;
```

## Troubleshooting

### Database Connection Errors
- Verify MySQL is running
- Check credentials in `api/config.php`
- Ensure database `free2sleep_db` exists
- Check PHP MySQL extension is installed: `php -m | grep mysql`

### Permission Errors
- Check file permissions on `api/` and `uploads/` directories
- Verify web server user (www-data, apache, or _www)
- Grant appropriate permissions

### API Not Working
- Check PHP error logs: `/var/log/apache2/error.log` (Linux)
- Enable error display temporarily in `config.php`
- Verify `.htaccess` is being read (Apache)
- Check browser console for CORS errors

### PHPMyAdmin Access Issues
- Check if PHPMyAdmin is installed: `dpkg -l | grep phpmyadmin`
- Verify PHPMyAdmin configuration: `/etc/phpmyadmin/config.inc.php`
- Clear browser cache and cookies

## Migrating Existing Data

If you have data in localStorage that you want to migrate to MySQL:

1. Open browser console on the application page
2. Export localStorage data:
```javascript
const exportData = {
    clientIntakes: JSON.parse(localStorage.getItem('client-intake-form') || '[]'),
    bedIntakes: JSON.parse(localStorage.getItem('bed-intake-form') || '[]'),
    showerSignups: JSON.parse(localStorage.getItem('shower-signup-form') || '[]'),
    laundryRegistrations: JSON.parse(localStorage.getItem('laundry-registration-form') || '[]'),
    referrals: JSON.parse(localStorage.getItem('referral-form') || '[]')
};
console.log(JSON.stringify(exportData, null, 2));
```
3. Copy the JSON output
4. Use the migration script (contact developer for script)

## Support

For issues or questions:
- Check the [GitHub Issues](https://github.com/acesonder/FREE2SLEEP/issues)
- Review PHP error logs
- Verify database schema matches `database/schema.sql`

## Backup and Restore

### Manual Backup
```bash
mysqldump -u root -p free2sleep_db > backup_$(date +%Y%m%d).sql
```

### Restore from Backup
```bash
mysql -u root -p free2sleep_db < backup_20250114.sql
```

### Automated Backups (Linux Cron)
```bash
# Add to crontab: crontab -e
0 2 * * * mysqldump -u root -p'password' free2sleep_db > /backups/free2sleep_$(date +\%Y\%m\%d).sql
```

## Next Steps

1. Configure your web server for production
2. Set up SSL/HTTPS
3. Create database backups schedule
4. Monitor application logs
5. Test all forms and features
6. Train staff on PHPMyAdmin usage

---

*Last Updated: 2025-01-14*
