<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_autre_depense extends Model
{
    use HasFactory;

    protected $table = 'event_autre_depense';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['id', 'id_event','id_autre_depense','tarif'];

    public function event()
    {
        return $this->belongsTo(Evenement::class,'id_event');
    }

    public function autre()
    {
        return $this->belongsTo(AutreDepense::class,'id_autre_depense');
    }
}
