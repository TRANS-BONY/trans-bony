$files = @(
    "c:\xampp\htdocs\trans-bony\resources\views\admin\document\create.blade.php",
    "c:\xampp\htdocs\trans-bony\resources\views\admin\document\edit.blade.php",
    "c:\xampp\htdocs\trans-bony\resources\views\gestionnaire\documents\create.blade.php",
    "c:\xampp\htdocs\trans-bony\resources\views\gestionnaire\documents\edit.blade.php"
)

$jsSnippet = @"

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.querySelector('input[type="file"][name="fichier"]');
        if (!fileInput) return;
        
        const previewContainer = fileInput.nextElementSibling;
        if (!previewContainer) return;
        
        const fileNameEl = previewContainer.querySelector('p.text-sm.text-gray-500') || previewContainer.querySelector('p.text-gray-500');
        const iconEl = previewContainer.querySelector('i');
        
        // Add error element
        const errorEl = document.createElement('p');
        errorEl.className = 'text-sm text-red-500 mt-2 font-semibold hidden';
        fileInput.parentElement.parentElement.appendChild(errorEl);

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Check size (5MB)
                const maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    errorEl.textContent = 'Le fichier selectionné est trop volumineux (Maximum 5MB).';
                    errorEl.classList.remove('hidden');
                    fileInput.value = ''; // clear
                    if(fileNameEl) fileNameEl.textContent = 'Cliquez ou glissez le fichier ici';
                    return;
                }
                
                errorEl.classList.add('hidden');
                if(fileNameEl) fileNameEl.textContent = file.name;
                if(iconEl) {
                    iconEl.className = 'fas fa-file-check text-3xl text-emerald-600 mb-2 transition-transform';
                }
            } else {
                errorEl.classList.add('hidden');
                if(fileNameEl) fileNameEl.textContent = 'Cliquez ou glissez le fichier ici';
                if(iconEl) iconEl.className = 'fas fa-file-upload text-3xl text-emerald-400 mb-2 group-hover:scale-110 transition-transform';
            }
        });
    });
</script>
@endpush
"@

foreach ($file in $files) {
    if (Test-Path $file) {
        $content = Get-Content $file -Raw
        if ($content -notmatch "fileInput.addEventListener") {
            $content = $content -replace "@endsection", "$jsSnippet`n@endsection"
            Set-Content -Path $file -Value $content
            Write-Host "Updated $file"
        }
    }
}
