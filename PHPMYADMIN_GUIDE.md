# PHPMyAdmin Usage Guide for FREE2SLEEP

## Introduction

PHPMyAdmin is a web-based interface for managing MySQL databases. This guide shows you how to use PHPMyAdmin to manage the FREE2SLEEP database.

## Accessing PHPMyAdmin

### Local Development
- **XAMPP**: `http://localhost/phpmyadmin`
- **MAMP**: `http://localhost:8888/phpmyadmin`
- **Linux**: `http://localhost/phpmyadmin`

### Login Credentials
- **Username**: `root` (or your configured username)
- **Password**: (leave blank for default XAMPP/MAMP, or use your MySQL password)

## Database Overview

### FREE2SLEEP Database Structure

The `free2sleep_db` database contains the following tables:

1. **client_intakes** - Client intake form submissions
2. **bed_intakes** - Emergency shelter bed requests
3. **shower_signups** - Shower program registrations
4. **laundry_registrations** - Laundry service signups
5. **service_referrals** - Service referral requests
6. **messages** - Messaging system data
7. **documents** - Document metadata and file references
8. **case_notes** - Case management notes
9. **admin_users** - Administrator accounts
10. **admin_sessions** - Active admin sessions
11. **user_preferences** - User language and display preferences

## Common Tasks

### 1. Viewing Data

#### View All Records in a Table
1. Click on `free2sleep_db` in the left sidebar
2. Click on the table name (e.g., `client_intakes`)
3. Click the "Browse" tab to see all records

#### Search for Specific Records
1. Select the table
2. Click the "Search" tab
3. Enter search criteria (name, phone, date, etc.)
4. Click "Go"

Example searches:
- Find client by name: `last_name = 'Smith'`
- Find recent intakes: `timestamp > '2025-01-01'`
- Find active beds: `status = 'active'`

### 2. Exporting Data

#### Export to Excel/CSV
1. Select the database or table
2. Click "Export" tab
3. Choose format:
   - **CSV for MS Excel** - Best for Excel
   - **Microsoft Excel** - Direct Excel format
   - **PDF** - For reports
4. Click "Go" to download

#### Export for Backup
1. Select `free2sleep_db`
2. Click "Export"
3. Select "SQL" format
4. Choose "Quick" export method
5. Click "Go"
6. Save the `.sql` file securely

### 3. Viewing Reports and Statistics

#### Total Counts
```sql
SELECT 
    (SELECT COUNT(*) FROM client_intakes) as total_clients,
    (SELECT COUNT(*) FROM bed_intakes WHERE status='active') as active_beds,
    (SELECT COUNT(*) FROM shower_signups) as shower_signups,
    (SELECT COUNT(*) FROM service_referrals WHERE status='pending') as pending_referrals;
```

#### Recent Activity (Last 7 Days)
```sql
SELECT 
    first_name, 
    last_name, 
    phone, 
    timestamp 
FROM client_intakes 
WHERE timestamp >= DATE_SUB(NOW(), INTERVAL 7 DAY)
ORDER BY timestamp DESC;
```

#### Bed Availability Report
```sql
SELECT 
    COUNT(*) as occupied_beds,
    (24 - COUNT(*)) as available_beds
FROM bed_intakes 
WHERE status = 'active';
```

### 4. Running Custom Queries

1. Click on `free2sleep_db`
2. Click the "SQL" tab
3. Enter your SQL query
4. Click "Go"

Example queries:

**Find clients who need mental health support:**
```sql
SELECT 
    first_name, 
    last_name, 
    phone, 
    mental_health_support 
FROM client_intakes 
WHERE mental_health_support = 'Yes';
```

**List upcoming shower appointments:**
```sql
SELECT 
    first_name, 
    last_name, 
    preferred_date, 
    preferred_time 
FROM shower_signups 
WHERE preferred_date >= CURDATE() 
ORDER BY preferred_date, preferred_time;
```

**Count referrals by service type:**
```sql
SELECT 
    service_type, 
    COUNT(*) as count 
FROM service_referrals 
GROUP BY service_type 
ORDER BY count DESC;
```

### 5. Editing Data

⚠️ **Warning**: Be careful when editing data directly. Always backup first.

1. Browse to the record you want to edit
2. Click the pencil icon (Edit) in the row
3. Modify the values
4. Click "Go" to save changes

### 6. Deleting Data

⚠️ **Warning**: Deletion is permanent. Always backup before deleting.

1. Browse to the record
2. Click the X icon (Delete) in the row
3. Confirm deletion

## Useful Reports

### Daily Summary Report
```sql
SELECT 
    DATE(timestamp) as date,
    COUNT(*) as new_clients,
    SUM(CASE WHEN housing_status = 'Homeless' THEN 1 ELSE 0 END) as homeless
FROM client_intakes
WHERE timestamp >= DATE_SUB(NOW(), INTERVAL 30 DAY)
GROUP BY DATE(timestamp)
ORDER BY date DESC;
```

### Active Services Summary
```sql
SELECT 
    'Client Intakes' as service, COUNT(*) as total FROM client_intakes
UNION ALL
SELECT 'Active Beds', COUNT(*) FROM bed_intakes WHERE status='active'
UNION ALL
SELECT 'Shower Signups', COUNT(*) FROM shower_signups
UNION ALL
SELECT 'Laundry Registrations', COUNT(*) FROM laundry_registrations
UNION ALL
SELECT 'Pending Referrals', COUNT(*) FROM service_referrals WHERE status='pending';
```

### Messages by Conversation
```sql
SELECT 
    conversation_id,
    COUNT(*) as message_count,
    SUM(CASE WHEN is_read = FALSE THEN 1 ELSE 0 END) as unread_count,
    MAX(timestamp) as last_message
FROM messages
GROUP BY conversation_id
ORDER BY last_message DESC;
```

## Database Maintenance

### 1. Backup Database

**Automated Backup (Recommended)**
1. Click "Export" on `free2sleep_db`
2. Use "Custom" method
3. Select all tables
4. Choose "Add DROP TABLE" option
5. Save file as `free2sleep_backup_YYYYMMDD.sql`

**Schedule**: Create weekly backups and store in a secure location.

### 2. Optimize Tables

Improves performance by reorganizing data:

1. Select `free2sleep_db`
2. Check all tables
3. In "With selected" dropdown, choose "Optimize table"
4. Click "Go"

Run monthly or when database becomes slow.

### 3. Check for Errors

1. Select `free2sleep_db`
2. Check all tables
3. In "With selected" dropdown, choose "Check table"
4. Click "Go"

Run after any database crashes or unexpected shutdowns.

### 4. Clean Old Data

**Archive old bed intakes (completed > 6 months ago):**
```sql
-- First, export the data
SELECT * FROM bed_intakes 
WHERE status = 'completed' 
AND check_out_time < DATE_SUB(NOW(), INTERVAL 6 MONTH);

-- Then delete (after confirming backup)
DELETE FROM bed_intakes 
WHERE status = 'completed' 
AND check_out_time < DATE_SUB(NOW(), INTERVAL 6 MONTH);
```

## Security Best Practices

### 1. Change Default Credentials

Never use `root` with no password in production:

```sql
-- Create dedicated user for application
CREATE USER 'free2sleep_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT SELECT, INSERT, UPDATE, DELETE ON free2sleep_db.* TO 'free2sleep_user'@'localhost';
FLUSH PRIVILEGES;
```

Update `api/config.php` with new credentials.

### 2. Restrict PHPMyAdmin Access

Edit PHPMyAdmin config to allow only localhost:
```php
// In config.inc.php
$cfg['Servers'][$i]['AllowDeny']['order'] = 'deny,allow';
$cfg['Servers'][$i]['AllowDeny']['rules'] = array('allow localhost');
```

### 3. Regular Backups

Create a backup schedule:
- **Daily**: Automated backup of database
- **Weekly**: Full backup including files
- **Monthly**: Off-site backup archive

### 4. Monitor Database Size

Check database size regularly:
```sql
SELECT 
    table_name,
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS "Size (MB)"
FROM information_schema.TABLES
WHERE table_schema = 'free2sleep_db'
ORDER BY (data_length + index_length) DESC;
```

## Troubleshooting

### Can't Access PHPMyAdmin
- Verify MySQL is running
- Check if PHPMyAdmin is installed: `dpkg -l | grep phpmyadmin`
- Check Apache/web server logs

### "Access Denied" Error
- Verify username and password
- Check user permissions: `SHOW GRANTS FOR 'username'@'localhost';`
- Reset MySQL root password if needed

### Slow Queries
1. Enable slow query log in MySQL
2. Run EXPLAIN on slow queries
3. Add indexes to frequently searched columns
4. Optimize tables regularly

### Database Too Large
1. Archive old data
2. Delete unnecessary records
3. Optimize tables
4. Consider data retention policies

## Additional Resources

- [PHPMyAdmin Official Documentation](https://docs.phpmyadmin.net/)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- FREE2SLEEP: [DATABASE_SETUP.md](DATABASE_SETUP.md)
- FREE2SLEEP: [API_REFERENCE.md](API_REFERENCE.md)

## Support

For issues specific to FREE2SLEEP database:
1. Check error logs in `api/config.php`
2. Review PHP error logs
3. Contact system administrator

---

*Last Updated: 2025-01-14*
