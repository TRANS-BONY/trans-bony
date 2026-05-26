<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'table_name',
        'record_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 📝 Description lisible de l'action
     */
    public function getDescriptionAttribute()
    {
        $actionMap = [
            'CREATE' => 'Création',
            'UPDATE' => 'Modification',
            'DELETE' => 'Suppression',
        ];

        $action = $actionMap[$this->action] ?? $this->action;
        $module = ucfirst($this->table_name);
        
        return "{$action} dans le module {$module}" . ($this->record_id ? " (#{$this->record_id})" : "");
    }
}
