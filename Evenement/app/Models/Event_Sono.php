<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_Sono extends Model
{
    use HasFactory;

    protected $table = 'event_sono';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['id', 'id_event','id_sono','duree_sono'];

    public function event()
    {
        return $this->belongsTo(Evenement::class,'id_event');
    }

    public function sono()
    {
        return $this->belongsTo(Sonorisation::class,'id_sono');
    }
}
