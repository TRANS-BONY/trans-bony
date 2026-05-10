const fs = require('fs');
const path = require('path');

const viewsDir = path.join('c:', 'xampp', 'htdocs', 'trans-bony', 'resources', 'views');

function walkDir(dir, callback) {
    fs.readdirSync(dir).forEach(f => {
        let dirPath = path.join(dir, f);
        if (fs.statSync(dirPath).isDirectory()) {
            walkDir(dirPath, callback);
        } else {
            callback(dirPath);
        }
    });
}

const searchHtml = `
    <!-- Barre de recherche injectée -->
    <div class="mb-4">
        <form method="GET" class="relative shadow-sm rounded-xl overflow-hidden">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}"
                   class="w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 outline-none">
        </form>
    </div>
`;

walkDir(viewsDir, (filePath) => {
    if (!filePath.endsWith('index.blade.php')) return;
    if (filePath.includes('dashboard')) return;
    if (filePath.includes('admin/index.blade.php') || filePath.includes('comptable/index.blade.php') || filePath.includes('manager/index.blade.php') || filePath.includes('gestionnaire/index.blade.php') || filePath.includes('technicien/index.blade.php') || filePath.includes('agent/index.blade.php')) return;

    let content = fs.readFileSync(filePath, 'utf8');

    if (content.includes('name="search"')) return; // Already has a search input

    // Strategy: inject the search bar right before the first major list container.
    // The list container is usually:
    // <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    // OR <div class="grid grid-cols-
    // Let's find the first matching table wrapper or grid.
    
    // Pattern 1: Table wrapper in manager/gestionnaire
    if (content.includes('<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border')) {
        content = content.replace(/(<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border)/, searchHtml + '$1');
        fs.writeFileSync(filePath, content, 'utf8');
        console.log('Added search to (Table pattern): ' + filePath);
        return;
    }
    
    // Pattern 2: Grid container in manager/gestionnaire
    if (content.includes('<div class="grid grid-cols-1 md:grid-cols-2')) {
        content = content.replace(/(<div class="grid grid-cols-1 md:grid-cols-2)/, searchHtml + '$1');
        fs.writeFileSync(filePath, content, 'utf8');
        console.log('Added search to (Grid pattern): ' + filePath);
        return;
    }

    // Pattern 3: <div class="overflow-x-auto"> (Fallback for tables)
    if (content.includes('<div class="overflow-x-auto">')) {
        content = content.replace(/(<div class="overflow-x-auto">)/, searchHtml + '$1');
        fs.writeFileSync(filePath, content, 'utf8');
        console.log('Added search to (Fallback table pattern): ' + filePath);
        return;
    }
});
