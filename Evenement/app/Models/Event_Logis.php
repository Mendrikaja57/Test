<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_Logis extends Model
{
    use HasFactory;

    protected $table = 'event_logis';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['id', 'id_event','id_logis','duree_logis'];

    public function event()
    {
        return $this->belongsTo(Evenement::class,'id_event');
    }

    public function logis()
    {
        return $this->belongsTo(Logistique::class,'id_logis');
    }
}
