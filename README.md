# Certificate Claim System

A modern Laravel-based certificate management and verification system with OTP authentication, event management, and secure certificate generation.

## Features

### For Users
- **Event Browsing**: View available events and certificate programs
- **Certificate Claiming**: Claim certificates for events attended
- **Status Tracking**: Track certificate approval status in real-time
- **Certificate Verification**: Verify certificate authenticity via certificate number
- **Certificate Download**: Download generated certificates in PDF format

### For Administrators
- **Dashboard**: Overview of pending, generated, rejected stats and quick actions
- **Event Management**: Create, edit, and manage certificate events with optional certificate number prefix
- **Pending Claims by Event**: Review pending claims grouped and categorized by event
- **Rejected Claims by Event**: View rejected claims grouped and categorized by event
- **Generated Certificates by Event**: Browse generated certificates grouped by event
- **Certificate Approval**: Review and approve/reject claims with quick-select rejection reasons
- **Bulk Approve/Reject**: Select multiple pending claims and approve or reject them in one action
- **Allow Re-claim**: Reset a rejected claim back to pending and notify the user via email
- **Activity Log**: Full history of all admin actions (approved, rejected, reset, regenerated, etc.)
- **Global Search**: Search all claims by name, email, certificate number, or event from the navbar
- **Export CSV**: Download claim lists per event and status as CSV files
- **Claim Deadline per Event**: Set a deadline date/time after which the claim form auto-closes
- **Custom Certificate Templates**: Upload custom certificate templates and overlay settings
- **Poster Management**: Upload event posters
- **Certificate Generation**: Generate certificates with customizable templates
- **OTP Authentication**: Secure two-factor authentication for admin access
- **Email Notifications**: Automatic email notifications for approvals, rejections, and re-opens
- **Responsive Navbar**: Mobile-friendly admin navigation with inline search

## Security Features

### OTP Authentication
- Two-factor authentication for admin login
- 6-digit OTP code sent via email
- OTP expires after 10 minutes
- Session-based verification tracking
- Automatic OTP cleanup after successful verification

### CORS Configuration
- Restricted CORS to specific origins only
- Limited allowed methods (GET, POST, PUT, PATCH, DELETE, OPTIONS)
- Specific allowed headers (Content-Type, X-Requested-With, Authorization, Accept)
- Preflight request caching (24 hours)

### Additional Security
- Rate limiting on sensitive endpoints
- CSRF protection
- Session management with regeneration
- Secure password hashing

## Requirements

- PHP >= 8.2
- Composer
- MySQL >= 5.7 or MariaDB >= 10.3
- Node.js >= 18 (for asset compilation)

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Kepin17/claim-certif-.git
   cd claim-certif-
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   
   Edit `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Create admin user**
   ```bash
   php artisan tinker
   ```
   ```php
   \App\Models\User::create([
       'name' => 'Admin Name',
       'email' => 'admin@example.com',
       'password' => bcrypt('your_password')
   ]);
   ```

7. **Configure mail settings**
   
   Edit `.env` file for email notifications:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=your_smtp_host
   MAIL_PORT=587
   MAIL_USERNAME=your_email
   MAIL_PASSWORD=your_email_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your_email@example.com
   MAIL_FROM_NAME="${APP_NAME}"
   ```

8. **Compile assets**
   ```bash
   npm run build
   ```

9. **Start development server**
   ```bash
   php artisan serve
   ```

## Configuration

### CORS Configuration

Update `config/cors.php` to add your frontend URL:
```php
'allowed_origins' => [
    'http://your-frontend-domain.com',
    'https://your-frontend-domain.com',
],
```

### OTP Configuration

OTP settings are configured in `app/Http/Controllers/Admin/AuthController.php`:
- OTP length: 6 digits
- OTP expiry: 10 minutes
- Email delivery via Laravel Mail

### Certificate Template

Upload certificate templates in the admin event management:
- Supported formats: PDF
- Recommended dimensions: A4 size (210mm x 297mm)
- Overlay settings for participant name, certificate number, and event details

## Usage

### User Flow
1. Browse available events on the homepage
2. Click on an event to view details
3. Fill out the certificate claim form with participant details
4. Submit for approval
5. Track certificate status using the certificate number
6. Download approved certificate from the verification page

### Admin Flow
1. Login with email and password
2. Enter OTP code sent to email
3. Access admin dashboard (shows Pending / Generated / Rejected / Events stats)
4. Click **Pending** → select event → review individual claims
5. Use checkboxes to select multiple claims → **Approve Selected** or **Reject Selected** (bulk action)
6. Or click **Review Claim** on a single claim to approve/reject individually
7. Certificates are auto-generated and emailed upon approval
8. Click **Rejected** → select event → optionally click **Allow Re-claim** to reset and notify user
9. Click **Generated** → select event → view, regenerate, or resend email, or **Export CSV**
10. Use the **Search** bar in the navbar to find any claim instantly
11. Check **Activity Log** to audit all admin actions
12. Manage events (including Claim Deadline) under **Events**

## Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── CertificateAdminController.php
│   │   │   │   └── EventController.php
│   │   │   └── CertificateController.php
│   │   └── Middleware/
│   │       └── CheckOTPVerification.php
│   └── Models/
│       ├── User.php
│       ├── Certificate.php
│       └── Event.php
├── config/
│   └── cors.php
├── database/
│   └── migrations/
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── pending.blade.php            # Events grid for pending claims
│       │   ├── pending-by-event.blade.php   # Pending claims list per event
│       │   ├── rejected.blade.php           # Events grid for rejected claims
│       │   ├── rejected-by-event.blade.php  # Rejected claims list per event
│       │   ├── generated.blade.php          # Events grid for generated certs
│       │   ├── generated-by-event.blade.php # Generated certs list per event
│       │   ├── show.blade.php               # Review a single claim
│       │   └── events/
│       ├── certificates/
│       │   ├── status.blade.php
│       │   └── claim.blade.php
│       ├── emails/
│       │   ├── certificate-approved.blade.php
│       │   └── certificate-rejected.blade.php
│       ├── errors/
│       │   ├── 403.blade.php
│       │   ├── 404.blade.php
│       │   └── 500.blade.php
│       ├── admin/
│       │   ├── activity-log.blade.php       # Admin activity log page
│       │   └── search.blade.php             # Global search results
│       ├── vendor/pagination/
│       │   └── tailwind.blade.php           # Custom themed pagination
│       └── layouts/
│           ├── admin-layout.blade.php
│           └── user-layout.blade.php
└── routes/
    └── web.php
```

## Dependencies

### PHP Packages
- Laravel 11.x
- pragmarx/google2fa-laravel (for OTP generation)

### Node.js Packages
- Vite (for asset compilation)

## License

This project is open-sourced software licensed under the MIT license.

## Support

For support, please contact:
- Email: support@kevienstudio.my.id
- Website: https://kevienstudio.my.id

## Credits

- Developed by Kevien Studio
- Built with Laravel 11
