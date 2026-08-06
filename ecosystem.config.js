module.exports = {
    apps: [
        {
            // ─── Laravel Queue Worker ───────────────────────────────
            name: 'certif-queue',
            script: 'artisan',
            interpreter: 'php',
            args: 'queue:work --sleep=3 --tries=3 --max-time=3600',

            // Restart otomatis jika crash
            autorestart: true,
            watch: false,

            // Memory limit (restart jika melebihi 256MB)
            max_memory_restart: '256M',

            // Environment variables
            env: {
                APP_ENV: 'production',
            },

            // Log files
            error_file: './storage/logs/pm2-queue-error.log',
            out_file:   './storage/logs/pm2-queue-out.log',
            log_date_format: 'YYYY-MM-DD HH:mm:ss',
        },

        // ─── (Opsional) Laravel Scheduler ──────────────────────────
        // Uncomment jika butuh scheduler (cron artisan schedule:run)
        // {
        //     name: 'certif-scheduler',
        //     script: 'artisan',
        //     interpreter: 'php',
        //     args: 'schedule:work',
        //     autorestart: true,
        //     watch: false,
        //     error_file: './storage/logs/pm2-scheduler-error.log',
        //     out_file:   './storage/logs/pm2-scheduler-out.log',
        // },
    ],
};
