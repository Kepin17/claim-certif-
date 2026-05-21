# Certificate Claim System

A complete Laravel-based certificate claim system with approval workflow, PDF generation, email notifications, and QR code verification.

## Features

### User Side
- **Claim Form**: Users can submit certificate claims with name, email, participant number, event, and optional proof file
- **Status Tracking**: Users can track their claim status using participant number and email
- **Certificate Download**: Download generated certificates via secure link
- **QR Verification**: Verify certificate authenticity through QR code scanning

### Admin Side
- **Dashboard**: Overview of pending, approved, rejected, and generated certificates
- **Claim Review**: Review pending claims with proof file preview
- **Approval System**: Approve or reject claims with rejection reasons
- **Certificate Management**: Regenerate certificates, resend emails
- **Bulk Operations**: Process multiple claims efficiently

### Technical Features
- **Queue-Based Processing**: Async PDF generation using Laravel Queue
- **Email Notifications**: Automatic email delivery for approvals and rejections
- **PDF Generation**: Professional certificate templates with DOMPDF
- **QR Code Verification**: Secure certificate validation
- **Anti-Duplicate Check**: Prevent duplicate claims
- **Audit Trail**: Track who approved/rejected and when

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- Laravel 11
- Database (MySQL, PostgreSQL, or SQLite)

### Setup Steps

1. **Install Dependencies**
```bash
composer install
```

2. **Install DOMPDF Package**
```bash
composer require barryvdh/laravel-dompdf
```

3. **Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=certificate_system
DB_USERNAME=your_username
DB_PASSWORD=your_password

QUEUE_CONNECTION=database
```

4. **Run Migrations**
```bash
php artisan migrate
```

5. **Link Storage**
```bash
php artisan storage:link
```

6. **Start Queue Worker**
```bash
php artisan queue:work
```

7. **Start Development Server**
```bash
php artisan serve
```

## Usage

### User Workflow

1. **Submit Claim**
   - Navigate to `/claim-certificate`
   - Fill in the form with required information
   - Upload optional proof file
   - Submit the claim

2. **Track Status**
   - Navigate to `/track-certificate`
   - Enter participant number and email
   - View current status

3. **Download Certificate**
   - Once approved and generated, download via email link
   - Or use the download link on status page

4. **Verify Certificate**
   - Scan QR code on certificate
   - Or visit `/verify/{certificate_number}`

### Admin Workflow

1. **Access Dashboard**
   - Navigate to `/admin/dashboard`
   - View statistics and quick actions

2. **Review Pending Claims**
   - Navigate to `/admin/pending`
   - Click "Review" on a claim
   - View details and proof file
   - Approve or Reject with reason

3. **Manage Generated Certificates**
   - Navigate to `/admin/generated`
   - Regenerate certificates if needed
   - Resend emails to users

## API Endpoints

### User Routes
- `GET /claim-certificate` - Claim form
- `POST /claim-certificate` - Submit claim
- `GET /track-certificate` - Track status form
- `POST /track-certificate` - Submit tracking
- `GET /certificate-status/{id}` - View status
- `GET /download-certificate/{certificateNumber}` - Download PDF
- `GET /verify/{certificateNumber}` - Verify certificate

### Admin Routes
- `GET /admin/dashboard` - Dashboard
- `GET /admin/pending` - Pending claims
- `GET /admin/approved` - Approved claims
- `GET /admin/rejected` - Rejected claims
- `GET /admin/generated` - Generated certificates
- `GET /admin/certificate/{id}` - View claim details
- `POST /admin/certificate/{id}/approve` - Approve claim
- `POST /admin/certificate/{id}/reject` - Reject claim
- `GET /admin/certificate/{id}/preview` - Preview certificate
- `POST /admin/certificate/{id}/regenerate` - Regenerate PDF
- `POST /admin/certificate/{id}/resend-email` - Resend email

## Status Flow

```
PENDING → UNDER_REVIEW → APPROVED → GENERATED → SENT
                           ↓
                         REJECTED
```

## Database Schema

### Certificates Table
- `id` - Primary key
- `name` - Participant full name
- `email` - Participant email
- `participant_number` - Unique participant ID
- `event` - Event name
- `proof_file` - Optional proof file path
- `status` - Current status (pending, under_review, approved, rejected, generated, sent)
- `certificate_number` - Generated certificate number
- `pdf_path` - PDF file path
- `qr_code` - QR code URL
- `rejection_reason` - Reason for rejection
- `approved_by` - Admin who approved/rejected
- `approved_at` - Approval/rejection timestamp
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

## Configuration

### Queue Configuration
The system uses database queue for async processing. Configure in `.env`:
```env
QUEUE_CONNECTION=database
```

Run queue worker:
```bash
php artisan queue:work
```

### Email Configuration
Configure mail settings in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Storage Configuration
Certificates are stored in `storage/app/public/certificates/`.
Proof files in `storage/app/public/proofs/`.

## Customization

### Certificate Template
Edit `resources/views/certificate/template.blade.php` to customize certificate design.

### Email Templates
- Approval: `resources/views/emails/certificate-approved.blade.php`
- Rejection: `resources/views/emails/certificate-rejected.blade.php`

### Certificate Number Format
Modify in `app/Http/Controllers/Admin/CertificateAdminController.php`:
```php
$eventCode = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $certificate->event), 0, 3));
$year = date('Y');
$sequence = Certificate::whereYear('created_at', $year)->count() + 1;
$certificateNumber = sprintf('%s-%s-%04d', $eventCode, $year, $sequence);
```

## Troubleshooting

### PDF Generation Not Working
- Ensure DOMPDF is installed: `composer require barryvdh/laravel-dompdf`
- Check storage permissions
- Verify queue worker is running

### Queue Jobs Not Processing
- Run: `php artisan queue:work`
- Check queue connection in `.env`
- Monitor failed jobs: `php artisan queue:failed`

### Email Not Sending
- Verify mail configuration in `.env`
- Check mail logs
- Test with `php artisan tinker`: `Mail::raw('Test', fn($msg) => $msg->to('test@example.com'));`

### Storage Link Issues
- Run: `php artisan storage:link`
- Check public/storage symlink

## Security Considerations

- Add authentication middleware to admin routes
- Implement rate limiting on claim submission
- Validate file uploads strictly
- Use HTTPS in production
- Add CSRF protection (enabled by default)
- Implement proper authorization checks

## Future Enhancements

- [ ] Add user authentication
- [ ] Implement role-based access control
- [ ] Add bulk approval/rejection
- [ ] Implement certificate expiration
- [ ] Add digital signatures
- [ ] Implement certificate revocation
- [ ] Add analytics dashboard
- [ ] Implement webhook notifications
- [ ] Add multi-language support
- [ ] Implement certificate templates system

## License

This project is open-source and available under the MIT License.

## Support

For issues and questions, please contact the development team.
