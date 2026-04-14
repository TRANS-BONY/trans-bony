# Fix Document Silent Fail & PDF 403

## Status: 🔄 In Progress

### 1. ✅ Diagnosis: Silent validation/DB fail, PDF permission.

### 2. 🔧 Add explicit authorize & logging in DocumentController.store()

### 3. 🔧 Loosen type validation regex.

### 4. 🔧 Assign 'voir rapports' to admin role (PDF).

### 5. Test & check logs.

**Run after edits:**
```
php artisan route:cache
php artisan permission:cache-reset
tail -f storage/logs/laravel.log
```

