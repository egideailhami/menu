<?php

namespace GritTekno\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AksesHak extends Model
{
    use SoftDeletes;

    protected $table = 'akses_hak';

    protected $guarded = ['id_akk'];
    protected $primaryKey = 'id_akk';

    protected $dates = ['deleted_at'];
    
    public function aksesDets()
    {
        return $this->hasMany('GritTekno\Menu\Models\AksesDet', 'id_akk', 'id_akk');
    }
}
