<?php

$controllersDir = __DIR__ . '/app/Http/Controllers';

$searchFields = [
    'Vehicule' => ['immatriculation', 'marque', 'modele'],
    'Chauffeur' => ['nom', 'prenom', 'permis'],
    'Voyage' => ['destination', 'statut'],
    'Maintenance' => ['type', 'description'],
    'Document' => ['type', 'reference'],
    'RecetteMensuelle' => ['montant'],
    'Rapport' => ['titre'],
    'User' => ['name', 'email'],
    '\App\Models\Audit' => ['action', 'description'],
    '\App\Models\User' => ['name', 'email']
];

$files = glob($controllersDir . '/*.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    $originalContent = $content;

    // We look for any method that does Model::...paginate()
    // e.g. Vehicule::orderBy('immatriculation')->paginate(12)
    // We need to inject Request $request if not present.
    
    // First, let's fix method signatures. We need to ensure `Request $request` is in the signature of index methods.
    $content = preg_replace_callback('/public function ([a-zA-Z0-9_]*Index|index)\(\)/', function($m) {
        return 'public function ' . $m[1] . '(\Illuminate\Http\Request $request)';
    }, $content);
    
    // Some index methods might already have Request $request
    // public function index(Request $request)
    
    // Now let's replace the pagination calls.
    // Pattern: $var = Model::(some chain)->paginate($num);
    // Or $var = Model::latest()->paginate($num);
    // Or $var = Model::with(...)->orderBy(...)->paginate($num);
    
    foreach ($searchFields as $model => $fields) {
        // e.g. Chauffeur::orderBy('nom')->paginate(12);
        // We match: ($var) = (Model)::(chain)->paginate((num));
        $pattern = '/(\$[a-zA-Z0-9_]+)\s*=\s*' . str_replace('\\', '\\\\', $model) . '::([a-zA-Z0-9_>\'\"(),\[\]\s:-]+)->paginate\(([0-9]+)\);/s';
        
        $content = preg_replace_callback($pattern, function($m) use ($model, $fields) {
            $varName = $m[1];
            $chain = $m[2];
            $paginateNum = $m[3];
            
            $searchLogic = "    \$query = " . $model . "::query();\n";
            
            // If chain has `with(...)` or `orderBy(...)`, we apply it to query.
            // We can just use the chain directly on the query if we do: $query = Model::{$chain}; Wait, Model::with(...)->orderBy(...) is fine.
            // Actually: $query = Model::{$chain}; doesn't work if chain is `with('a')->orderBy('b')`.
            // Instead: $query = $model::{$chain}; wait, no.
            
            // The best is:
            $searchLogic = "\$search = request('search');\n";
            $searchLogic .= "        {$varName} = " . $model . "::when(\$search, function(\$q) use (\$search) {\n";
            $searchLogic .= "            return \$q->where(function(\$q2) use (\$search) {\n";
            
            foreach ($fields as $i => $field) {
                if ($i == 0) {
                    $searchLogic .= "                \$q2->where('{$field}', 'like', \"%{\$search}%\")\n";
                } else {
                    $searchLogic .= "                   ->orWhere('{$field}', 'like', \"%{\$search}%\")\n";
                }
            }
            $searchLogic .= "                ;\n            });\n        })";
            
            // append the rest of the chain
            if (!empty(trim($chain))) {
                if (str_starts_with(trim($chain), 'query()')) {
                    $searchLogic .= "->" . substr(trim($chain), 7);
                } else {
                    $searchLogic .= "->" . trim($chain);
                }
            }
            
            $searchLogic .= "->paginate({$paginateNum})->appends(request()->query());";
            
            return $searchLogic;
        }, $content);
    }

    if ($content !== $originalContent) {
        file_put_contents($file, $content);
        echo "Updated $file\n";
    }
}
