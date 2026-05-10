<?php
$file = 'resources/views/admin/users/index.blade.php';
$c = file_get_contents($file);

// 1. Replace `<div class="space-y-8">` with module wrapper
$c = str_replace('<div class="space-y-8">', '<div class="module-index-wrapper custom-scrollbar">', $c);

// 2. Wrap Header and Search in shrink-0
$c = str_replace('<!-- Header -->', '<div class="shrink-0 space-y-6">' . "\n" . '    <!-- Header -->', $c);

// 3. Before the cards, close shrink-0 and open list-scroll-container
// Search/Filter ends at `</div>` before `<!-- Users Cards -->`
$searchFilterEnd = "            </div>\n\n            <!-- Users Cards -->";
$c = str_replace($searchFilterEnd, "            </div>\n    </div>\n    <div class=\"list-scroll-container flex-1 overflow-y-auto pr-2 mt-4 pb-16\">\n            <!-- Users Cards -->", $c);

// 4. Close the list-scroll-container after pagination, and add the CSS
$paginationEnd = "        @endif\n    </div>\n</div>\n@endsection";

$css = <<<CSS
        @endif
    </div>
</div>

<style>
    html, body {
        overflow: hidden !important;
    }
    .module-index-wrapper {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 100px);
        overflow: hidden;
    }
    .list-scroll-container {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
    }
    .list-scroll-container::-webkit-scrollbar {
        width: 6px;
    }
    .list-scroll-container::-webkit-scrollbar-track {
        background: transparent;
    }
    .list-scroll-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .dark .list-scroll-container::-webkit-scrollbar-thumb {
        background: #475569;
    }
</style>
@endsection
CSS;

$c = str_replace($paginationEnd, $css, $c);

// 5. Change Buttons to Soft styles
$oldButtons = <<<HTML
                            <!-- Actions -->
                            <div class="flex flex-col sm:flex-row gap-3 mt-8 pt-6 border-t border-indigo-200 dark:border-indigo-700">
                                <a href="{{ route('admin.users.show', \$user->id) }}"
                                   class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2">
                                    <i class="fas fa-eye"></i>
                                    Voir détails
                                </a>
                                <a href="{{ route('admin.users.edit', \$user->id) }}"
                                   class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-3 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2">
                                    <i class="fas fa-edit"></i>
                                    Modifier
                                </a>
                                <form method="POST" action="{{ route('admin.users.destroy', \$user->id) }}" class="flex-1" onsubmit="return confirm('Supprimer {{ \$user->name }} ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white py-3 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
HTML;

$newButtons = <<<HTML
                            <!-- Actions -->
                            <div class="flex flex-col sm:flex-row gap-2 mt-8 pt-4 border-t border-indigo-200/50 dark:border-indigo-700/50">
                                <a href="{{ route('admin.users.show', \$user->id) }}"
                                   class="flex-1 py-2.5 bg-indigo-50 hover:bg-indigo-100 dark:bg-indigo-900/30 dark:hover:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-xl transition-colors font-medium text-sm flex items-center justify-center gap-2">
                                    <i class="fas fa-eye"></i>
                                    Voir
                                </a>
                                <a href="{{ route('admin.users.edit', \$user->id) }}"
                                   class="flex-1 py-2.5 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900/30 dark:hover:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 rounded-xl transition-colors font-medium text-sm flex items-center justify-center gap-2">
                                    <i class="fas fa-edit"></i>
                                    Éditer
                                </a>
                                <form method="POST" action="{{ route('admin.users.destroy', \$user->id) }}" class="flex-1" onsubmit="return confirm('Supprimer {{ \$user->name }} ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full py-2.5 bg-rose-50 hover:bg-rose-100 dark:bg-rose-900/30 dark:hover:bg-rose-900/50 text-rose-600 dark:text-rose-400 rounded-xl transition-colors font-medium text-sm flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
HTML;

$c = str_replace($oldButtons, $newButtons, $c);

file_put_contents($file, $c);
echo "Users fixed.\n";

// Fix literal \n in blade files
$allFiles = glob('resources/views/*/*/*.blade.php');
foreach ($allFiles as $f) {
    $content = file_get_contents($f);
    if (strpos($content, '\n') !== false) {
        // Only replace \n if it's literally written before an HTML tag, which indicates a formatting error
        $content = str_replace('\n                <a href', "\n                <a href", $content);
        $content = str_replace('</a>\n                @endif', "</a>\n                @endif", $content);
        $content = str_replace('</svg>\n                </a>', "</svg>\n                </a>", $content);
        $content = str_replace('</path>\n                    </svg>', "</path>\n                    </svg>", $content);
        file_put_contents($f, $content);
    }
}
echo "Literal backslash-n fixed.\n";
