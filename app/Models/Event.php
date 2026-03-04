<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Event extends Model
{
    protected $fillable = [
        'category_id','title','description','event_date', 'jam', 'jam_selesai',
        'image','location','latitude','longitude'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
