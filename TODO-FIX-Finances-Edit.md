# TODO: Fix Finances Edit Route Error

## Steps:
1. [x] Update resources/views/finances/index.blade.php: Change route('finances.edit', $recette) to route('recettes.edit', $recette)
2. [x] Complete app/Http/Controllers/RecetteController.php: Add store(), update(), destroy() methods
3. [x] Clear route cache: php artisan route:clear
4. [ ] Test: Visit http://127.0.0.1:8000/recettes and click "Éditer"
5. [ ] [ ] Update TODO.md with completion
