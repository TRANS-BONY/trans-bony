const fs = require('fs');
const path = require('path');

const viewsDir = path.join('c:', 'xampp', 'htdocs', 'trans-bony', 'resources', 'views');

function walkDir(dir, callback) {
    fs.readdirSync(dir).forEach(f => {
        let dirPath = path.join(dir, f);
        let isDirectory = fs.statSync(dirPath).isDirectory();
        if (isDirectory) {
            walkDir(dirPath, callback);
        } else {
            callback(dirPath);
        }
    });
}

const excludedFiles = [
    'admin/index.blade.php',
    'agent/index.blade.php',
    'comptable/index.blade.php',
    'gestionnaire/index.blade.php',
    'manager/index.blade.php',
    'technicien/index.blade.php',
    'admin/dashboard.blade.php',
    'gestionnaire/dashboard.blade.php',
    'manager/dashboard.blade.php',
    'technicien/dashboard.blade.php'
];

walkDir(viewsDir, function(filePath) {
    if (!filePath.endsWith('index.blade.php')) return;

    const relativePath = filePath.replace(viewsDir + path.sep, '').replace(/\\/g, '/');
    if (excludedFiles.includes(relativePath)) return;

    let content = fs.readFileSync(filePath, 'utf8');

    if (content.includes('module-index-wrapper')) return; // Already refactored

    // We will replace <div class="space-y-6"> or similar with the new wrapper class
    content = content.replace(/(@section\('content'\)\s*)<div class="space-y-[46]"/, 
`$1<style>
    /* Désactiver le scroll global */
    html, body { overflow: hidden !important; height: 100vh !important; }
    
    /* Scrollbar minimaliste */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; height: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.05); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.2); border-radius: 10px; }
    
    /* Wrapper Layout */
    .module-index-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        height: calc(100vh - 100px);
        overflow: hidden;
        padding-bottom: 0.5rem;
    }
    
    /* By default, all direct children shouldn't shrink (Headers, Stats, Pagination) */
    .module-index-wrapper > * {
        flex-shrink: 0;
    }
    
    /* The main list container gets flex-1 and scroll */
    .module-index-wrapper > .grid:not(.grid-cols-2.md\\:grid-cols-4), /* Match grids except the stats grid */
    .module-index-wrapper > .animate-fade-in-up > .grid:not(.grid-cols-2.md\\:grid-cols-4), /* Nested grid */
    .module-index-wrapper > .list-scroll-container {
        flex: 1 1 0% !important;
        min-height: 0 !important;
        overflow-y: auto !important;
        padding-right: 0.25rem;
    }
    
    /* Fix for nested list containers in some views */
    .module-index-wrapper > .animate-fade-in-up:nth-last-child(2) {
        flex: 1 1 0% !important;
        min-height: 0 !important;
        display: flex;
        flex-direction: column;
    }
    .module-index-wrapper > .animate-fade-in-up:nth-last-child(2) > .grid,
    .module-index-wrapper > .animate-fade-in-up:nth-last-child(2) > .hidden.lg\\:block {
        flex: 1 1 0% !important;
        overflow-y: auto !important;
        min-height: 0 !important;
    }
</style>
<div class="module-index-wrapper custom-scrollbar"`);

    // In some views, the list is nested inside a <div class="animate-fade-in-up">. We need to make sure that div also becomes flex-1 if it's the list wrapper.
    // The CSS rule above `.module-index-wrapper > .animate-fade-in-up:nth-last-child(2)` handles the standard admin views perfectly because:
    // Child 1: Header
    // Child 2: Search (optional)
    // Child 3: Stats
    // Child 4: List (nth-last-child(2))
    // Child 5: Pagination (last-child)
    
    // To be perfectly safe, let's explicitly add the class "list-scroll-container" to the main list container if we can identify it.
    // Pattern 1: Simple grid (manager/vehicules)
    if (content.match(/<div class="grid grid-cols-[^"]* gap-[^"]*">/)) {
        content = content.replace(/(<div class=")(grid grid-cols-[^"]* gap-[^"]*)(">\s*@forelse)/, '$1list-scroll-container custom-scrollbar $2$3');
    }

    // Pattern 2: The complex mobile/desktop view in admin (like admin/vehicule/index.blade.php)
    // It has: 
    // <div class="animate-fade-in-up" style="animation-delay: 0.3s">
    //     {{-- Vue Mobile
    // Let's replace the outer div to flex-1 and its desktop/mobile inner parts to overflow-auto
    content = content.replace(/(<div class="animate-fade-in-up"[^>]*>)\s*(\{\{-- Vue Mobile)/, '$1\n        <style>\n            .animate-fade-in-up[style*="0.3s"] { flex: 1; min-height: 0; display: flex; flex-direction: column; overflow: hidden; }\n            .animate-fade-in-up[style*="0.3s"] > div { flex: 1; overflow-y: auto; }\n        </style>\n        $2');
    
    fs.writeFileSync(filePath, content, 'utf8');
    console.log('Refactored: ' + relativePath);
});
