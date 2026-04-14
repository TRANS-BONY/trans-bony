# Fix Mailpit Connection Error

## Steps:
- [x] 1. Edit app/Http/Controllers/DocumentController.php: Add try-catch around notification loop
- [ ] 2. Run `php artisan config:clear`
- [ ] 3. Test http://127.0.0.1:8000/documents (no crash)
- [ ] 4. Update .env MAIL_MAILER=log (recommended)
- [ ] 5. Move notifications to scheduler
