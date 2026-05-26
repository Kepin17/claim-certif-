# Certificate Claim System

A complete Laravel-based certificate claim system with approval workflow, PDF generation, email notifications, and QR code verification.

## Features

### User Side
- **Claim Form**: Users can submit certificate claims with name, email, participant number, event, and optional proof file
- **Status Tracking**: Users can track their claim status using participant number and email
- **Certificate Download**: Download generated certificates via secure link
- **QR Verification**: Verify certificate authenticity through QR code scanning

### Admin Side
- **Dashboard**: Overview of pending, generated, rejected stats with quick action buttons
- **Pending Claims by Event**: Pending claims categorized and grouped by event
- **Rejected Claims by Event**: Rejected claims categorized and grouped by event
- **Generated Certificates by Event**: Generated certificates grouped by event
- **Claim Review**: Review pending claims with proof file preview and quick-select rejection reasons
- **Approval System**: Approve or reject claims with custom or preset rejection reasons
- **Certificate Management**: Regenerate certificates, resend emails
- **Responsive Navigation**: Mobile-friendly admin navbar

### Technical Features
- **Queue-Based Processing**: Async PDF generation using Laravel Queue
- **Email Notifications**: Automatic email delivery for approvals and rejections
- **PDF Generation**: Professional certificate templates with DOMPDF
- **QR Code Verification**: Secure certificate validation
- **Anti-Duplicate Check**: Prevent duplicate claims
- **Audit Trail**: Track who approved/rejected and when
- **Unique Key Downloads**: Certificates downloaded via `unique_key` for correct retrieval
- **Optional Certificate Number Prefix**: Events can have a fixed prefix for certificate numbers
- **Custom Error Pages**: Branded 403, 404, 500 error pages matching the admin theme
- **Custom Pagination**: Themed pagination view without Tailwind CSS dependency

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
   - Select an event from the grid
   - Click "Review Claim" on any individual claim
   - View details and proof file
   - Approve or Reject (use quick-select for common rejection reasons)

3. **View Rejected Claims**
   - Navigate to `/admin/rejected`
   - Select an event from the grid
   - View rejected claims with rejection reason per claim

4. **Manage Generated Certificates**
   - Navigate to `/admin/generated`
   - Select an event from the grid
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
- `GET /admin/pending` - Pending claims (events grid)
- `GET /admin/pending/event/{eventId}` - Pending claims for specific event
- `GET /admin/rejected` - Rejected claims (events grid)
- `GET /admin/rejected/event/{eventId}` - Rejected claims for specific event
- `GET /admin/generated` - Generated certificates (events grid)
- `GET /admin/generated/event/{eventId}` - Generated certificates for specific event
- `GET /admin/certificate/{id}` - View/review claim details
- `POST /admin/certificate/{id}/approve` - Approve claim
- `POST /admin/certificate/{id}/reject` - Reject claim with reason
- `GET /admin/certificate/{id}/preview` - Preview certificate
- `POST /admin/certificate/{id}/regenerate` - Regenerate PDF
- `POST /admin/certificate/{id}/resend-email` - Resend email
- `GET /admin/events` - List all events
- `GET /admin/events/create` - Create new event
- `POST /admin/events` - Store new event
- `GET /admin/events/{event}` - View event
- `GET /admin/events/{event}/edit` - Edit event
- `PUT /admin/events/{event}` - Update event
- `DELETE /admin/events/{event}` - Delete event

## Status Flow

```
PENDING → GENERATED → SENT
    ↓
 REJECTED
```

Admin can approve (→ GENERATED) or reject (→ REJECTED) any PENDING claim.

## Database Schema

### Certificates Table
- `id` - Primary key
- `name` - Participant full name
- `email` - Participant email
- `participant_number` - Unique participant ID
- `event_id` - Foreign key to events table
- `event` - Event name (denormalized)
- `proof_file` - Optional proof file path
- `status` - Current status (`pending`, `rejected`, `generated`, `sent`)
- `certificate_number` - Generated certificate number (format: `PREFIX-YEAR-SEQ` or event prefix)
- `unique_key` - Unique UUID key used for secure certificate downloads
- `pdf_path` - PDF file path
- `qr_code` - QR code URL
- `rejection_reason` - Reason for rejection
- `approved_by` - Admin who processed the claim
- `approved_at` - Processing timestamp
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

### Events Table
- `id` - Primary key
- `name` - Event name
- `slug` - URL-friendly name
- `date` - Event date
- `description` - Event description
- `certificate_template` - PDF template path
- `certificate_number_prefix` - Optional fixed prefix for certificate numbers
- `is_active` - Whether the event is open for claims
- `created_at`, `updated_at` - Timestamps

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
Certificate numbers are generated in `app/Services/CertificateService.php`:
- **Auto format**: `EVT-2026-0001` (derived from event name + year + sequence)
- **Fixed prefix**: If the event has `certificate_number_prefix` set, it is used directly as the certificate number without auto-generation

Set the prefix in the event creation/edit form (optional field).

### Certificate Download
Downloads use `unique_key` (UUID) for secure, unambiguous retrieval:
```
GET /download-certificate?key={unique_key}
```
This ensures the correct certificate is always returned even when `certificate_number` values are duplicated across events.

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
