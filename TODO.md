# Document Interface Fix - Null Vehicule Crash

**Status**: Approved - Implementing null-safe fixes

## Steps:
- [ ] 1. Create TODO.md ✅
- [ ] 2. Edit resources/views/admin/document/index.blade.php - Null-safe vehicule access
- [ ] 3. Edit app/Http/Controllers/DocumentController.php - Filter valid docs
- [ ] 4. php artisan view:clear
- [ ] 5. Test /admin/documents

**Goal**: Handle orphaned documents (vehicule_id exists but vehicule deleted)
