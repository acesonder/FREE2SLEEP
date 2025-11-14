# FREE2SLEEP
## Cobourg's First Crisis Centre

FREE2SLEEP is Northumberland County's premier crisis centre providing comprehensive support services for individuals experiencing homelessness or crisis situations.

### 🌟 Features

- **Emergency Shelter** - 24/7 bed intake and accommodation
- **Support Services** - Case management and personalized planning
- **Hygiene Programs** - Free shower and laundry facilities
- **Service Referrals** - Connections to community resources
- **Crisis Support** - Immediate assistance when needed
- **Instant Messaging** - Real-time communication with staff
- **Document Sharing** - Secure file exchange
- **Admin Dashboard** - Comprehensive management system (passcode: 079777)

### 🌐 Website Pages

- **Landing Page** (`index.html`) - Main entry point with services overview
- **Admin Dashboard** (`admin.html`) - Staff management portal
- **Bed Intake** (`bed-intake.html`) - Emergency shelter requests
- **Client Assessment** (`client-intake.html`) - Comprehensive intake form
- **Shower Program** (`shower-program.html`) - Hygiene facility signup
- **Laundry Program** (`laundry-program.html`) - Laundry service registration
- **Service Referrals** (`referral.html`) - Community resource connections
- **Service Providers** (`service-providers.html`) - Local resource directory
- **Case Management** (`case-management.html`) - Support coordination
- **Messaging** (`messaging.html`) - Instant communication
- **Documents** (`documents.html`) - Secure file sharing

### 📱 Accessibility & Features

- ✅ Bilingual support (English/French)
- ✅ Fully responsive design (mobile, tablet, desktop)
- ✅ WCAG 2.1 Level AA compliant
- ✅ Keyboard navigation support
- ✅ Screen reader compatible
- ✅ High contrast mode support
- ✅ Reduced motion support

### 🚀 Quick Start

1. Set up the MySQL database (see [DATABASE_SETUP.md](DATABASE_SETUP.md))
2. Configure database connection in `api/config.php`
3. Open the application in a web browser
4. Navigate through the services
5. Access admin dashboard with passcode: **079777**
6. All forms save to MySQL database via PHP API

### 📞 Contact

**24/7 Crisis Line:** 1-866-995-9933

**Location:** Cobourg, Ontario - Northumberland County

**Hours:** Open 24/7 - Always here for you

### 📚 Documentation

- **Welcome Guide** - `docs/WELCOME_GUIDE.md`
- **Feature Descriptions** - `docs/FEATURES.md`
- **Screenshots & Visual Guide** - `docs/SCREENSHOTS.md`

### 🛠️ Technical Details

- **Frontend:** HTML5, CSS3, Vanilla JavaScript
- **Backend:** PHP 7.4+ with MySQL 5.7+
- **Database:** MySQL with PHPMyAdmin support
- **Icons:** Font Awesome 6.4.0
- **API:** RESTful PHP endpoints
- **Hosting:** Requires PHP-enabled web server (Apache/Nginx)

### 🔒 Security

- Passcode-protected admin area
- Session-based authentication via PHP
- SQL injection prevention with prepared statements
- XSS protection through HTML escaping
- CORS configuration for API security
- Secure password hashing with bcrypt
- HTTPS required for production

### 🎯 Built From Durham Policy

This crisis centre implementation follows the Durham policy framework for comprehensive support services.

### 💾 Database Setup

The application uses MySQL with PHP for data persistence. See [DATABASE_SETUP.md](DATABASE_SETUP.md) for detailed setup instructions.

**Quick Setup:**
1. Install XAMPP, MAMP, or LAMP stack
2. Import `database/schema.sql` via PHPMyAdmin
3. Configure `api/config.php` with your database credentials
4. Access application through your web server

**Database Features:**
- Complete client intake management
- Bed availability tracking
- Program registration (shower/laundry)
- Service referral system
- Messaging and document management
- Case management notes
- User preferences storage
- Secure admin authentication

### 📊 PHPMyAdmin Integration

Access and manage data through PHPMyAdmin:
- View all submissions and registrations
- Export data to Excel/CSV/PDF
- Run custom queries and reports
- Manage user accounts
- Database backup and restore
- Real-time data monitoring

---

*Developed for the Cobourg community - 2025 Winter Warming Room*
