$files = Get-ChildItem -Path "c:\xampp\htdocs\trans-bony\resources\views\comptable\recettes" -Filter "*.blade.php"
foreach ($f in $files) {
    $content = Get-Content $f.FullName -Raw
    $content = $content -replace '@extends\(''layouts\.comptable''\)', '@extends(''layouts.app'')'
    $content = $content -replace 'route\(''comptable\.recettes', 'route(''admin.recettes'
    $target = Join-Path "c:\xampp\htdocs\trans-bony\resources\views\admin\finances" $f.Name
    Set-Content -Path $target -Value $content
}
