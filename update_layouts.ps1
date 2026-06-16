$layoutFiles = Get-ChildItem -Path "c:\xampp\htdocs\trans-bony\resources\views\layouts" -Filter "*.blade.php" | Select-Object -ExpandProperty FullName

$errorSnippet = @"
                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl flex items-center justify-between shadow-sm" x-data="{ show: true }" x-show="show">
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                            <button @click="show = false" class="text-red-500 hover:text-red-700">&times;</button>
                        </div>
                    @endif
"@

$successBlockEnd = "</div>`n                    @endif"

foreach ($file in $layoutFiles) {
    $content = Get-Content $file -Raw
    if ($content -match "session\('success'\)" -and $content -notmatch "session\('error'\)") {
        $content = $content.Replace($successBlockEnd, "$successBlockEnd`n$errorSnippet")
        Set-Content -Path $file -Value $content
        Write-Host "Updated $file"
    }
}
