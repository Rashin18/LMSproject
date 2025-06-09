<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MaterialUserPivot extends Pivot
{
    protected $table = 'material_user';

    protected $casts = [
        'progress' => 'integer',
        'is_watched' => 'boolean',
    ];
}
