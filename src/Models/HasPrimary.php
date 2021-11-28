<?php

namespace JWCobb\LaravelToolkit\Models;

trait HasPrimary
{
    public function scopePrimary($query)
    {
        return $query->where('is_primary', 1);
    }
}
