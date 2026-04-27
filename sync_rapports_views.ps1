$files = Get-ChildItem -Path "c:\xampp\htdocs\trans-bony\resources\views\comptable\rapports" -Filter "*.blade.php"
foreach ($f in $files) {
    if ($f.Name -eq 'pdf.blade.php') { continue }
    $content = Get-Content $f.FullName -Raw
    $content = $content -replace '@extends\(''layouts\.comptable''\)', '@extends(''layouts.app'')'
    $content = $content -replace 'route\(''comptable\.rapports', 'route(''admin.rapports'
    $target = Join-Path "c:\xampp\htdocs\trans-bony\resources\views\admin\rapport" $f.Name
    Set-Content -Path $target -Value $content
}
