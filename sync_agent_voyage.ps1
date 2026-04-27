New-Item -ItemType Directory -Force -Path "c:\xampp\htdocs\trans-bony\resources\views\agent\voyage" | Out-Null
$content = Get-Content "c:\xampp\htdocs\trans-bony\resources\views\admin\voyage\index.blade.php" -Raw
$content = $content -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.agent'')'
$content = $content -replace '/admin/voyages', '/agent/voyages'
$content = $content -replace 'admin\.voyages', 'agent.voyages'
Set-Content -Path "c:\xampp\htdocs\trans-bony\resources\views\agent\voyage\index.blade.php" -Value $content
