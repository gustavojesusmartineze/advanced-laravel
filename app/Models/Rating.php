<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Pivot
{
    use HasFactory;

    // we have auto incrementing fields.
    public $incrementing = true;

    protected $table = 'ratings';

    public function rateable()
    {
        return $this->morphTo();
    }

    public function qualifier()
    {
        return $this->morphTo();
    }

    public function approve() {
        $this->approved_at = Carbon::now();
    }
}
