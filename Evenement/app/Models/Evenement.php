<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;
    protected $table = 'evenement';
    public $timestamps = false;
    protected $fillable = ['id', 'id_type_event','label', 'daty','id_lieu','prix_vip','prix_reserve','prix_normal','tarif_lieu'];

    public function typeevent()
    {
       return $this->belongsTo(TypeEvent::class,'id_type_event');
    }

    public function lieuevent()
    {
       return $this->belongsTo(Lieu::class,'id_lieu');
    }
}
