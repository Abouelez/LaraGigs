<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'user_id', 'logo', 'company', 'email', 'website', 'location', 'tags', 'description'];

    public function scopeFilter($query, array $filters)
    {
        if ($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . $filters['tag'] . '%');
        }
        if ($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . $filters['search'] . '%')
                ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                ->orWhere('tags', 'like', '%' . $filters['search'] . '%')
                ->orWhere('company', 'like', '%' . $filters['search'] . '%')
                ->orWhere('location', 'like', '%' . $filters['search'] . '%');
        }
    }

    //Relationship to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
