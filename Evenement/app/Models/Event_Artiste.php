<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_Artiste extends Model
{
    use HasFactory;

    protected $table = 'event_artiste';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['id', 'id_event','id_artiste','duree_artiste'];

    public function event()
    {
        return $this->belongsTo(Evenement::class,'id_event');
    }

    public function artiste()
    {
        return $this->belongsTo(Artiste::class,'id_artiste');
    }
}
