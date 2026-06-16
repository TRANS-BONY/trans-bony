$layoutFiles = Get-ChildItem -Path "c:\xampp\htdocs\trans-bony\resources\views\layouts" -Filter "*.blade.php" | Select-Object -ExpandProperty FullName

$jsSnippet = @"
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('invalid', function(e) {
                if (this.validity.valueMissing) {
                    this.setCustomValidity('Veuillez renseigner ce champ.');
                } else if (this.validity.typeMismatch) {
                    if (this.type === 'email') {
                        this.setCustomValidity('Veuillez saisir une adresse e-mail valide.');
                    } else if (this.type === 'url') {
                        this.setCustomValidity('Veuillez saisir une URL valide.');
                    } else {
                        this.setCustomValidity('Type invalide.');
                    }
                } else if (this.validity.patternMismatch) {
                    this.setCustomValidity(this.title ? 'Format requis : ' + this.title : 'Veuillez respecter le format requis.');
                } else if (this.validity.tooShort) {
                    this.setCustomValidity('Veuillez rallonger ce texte pour qu\'il comporte au moins ' + this.minLength + ' caractères.');
                } else {
                    this.setCustomValidity('Valeur invalide.');
                }
            });
            
            input.addEventListener('input', function(e) {
                this.setCustomValidity('');
            });
        });
    });
</script>
</body>
"@

foreach ($file in $layoutFiles) {
    if (Test-Path $file) {
        $content = Get-Content $file -Raw
        if ($content -notmatch "Veuillez renseigner ce champ") {
            $content = $content -replace "</body>", "$jsSnippet"
            Set-Content -Path $file -Value $content
            Write-Host "Updated $file"
        }
    }
}
