# Fix 405 POST on Vehicule Edit

## Status: Investigating

**Error**: POST /admin/vehicules/36 not allowed (only PUT/PATCH)

**Cause**: Form _method=PUT not received (body only _token)

**Code status**: Routes/form/controller/policy ALL CORRECT

### Steps:
1. [ ] Clear caches: php artisan route:clear; config:clear; view:clear; cache:clear  
2. [ ] Restart `php artisan serve`
3. [ ] Inspect edit page source: confirm `<input name="_method" value="PUT">`
4. [ ] Test edit flow
5. [ ] If fails, check middleware PermissionMiddleware.php

**Test**:
- Go /admin/vehicules/36/edit
- Submit form
- Check Network tab for _method=PUT in payload

