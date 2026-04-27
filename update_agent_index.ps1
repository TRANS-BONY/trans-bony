$path = "c:\xampp\htdocs\trans-bony\resources\views\agent\voyage\index.blade.php"
$content = Get-Content $path -Raw

# 1. Update header to add Create Button
$searchHeader = '            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-lg backdrop-blur-sm">'
$replaceHeader = '            <div class="flex items-center gap-3">
                <a href="{{ route(''agent.voyages.create'') }}" class="px-4 py-2 bg-white text-orange-600 font-medium rounded-lg hover:bg-orange-50 transition-colors shadow-sm flex items-center gap-2">
                    <i class="fas fa-plus"></i> Nouveau voyage
                </a>
                <div class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-lg backdrop-blur-sm">'
$content = $content.Replace($searchHeader, $replaceHeader)

# 2. Make Calendar take full width
$searchCalendarWidth = '<div class="lg:w-3/4 animate-fade-in-up"'
$replaceCalendarWidth = '<div class="w-full animate-fade-in-up"'
$content = $content.Replace($searchCalendarWidth, $replaceCalendarWidth)

# 3. Remove Formulaire D'Ajout Block
# We use Regex to remove everything from <!-- ➕ FORMULAIRE D'AJOUT --> up to just before <!-- 📋 LISTE DETAILLEE DES VOYAGES -->
$content = $content -replace '(?s)<!-- ➕ FORMULAIRE D''AJOUT -->.*?<!-- 📋 LISTE DETAILLEE DES VOYAGES -->', '<!-- 📋 LISTE DETAILLEE DES VOYAGES -->'

Set-Content -Path $path -Value $content
