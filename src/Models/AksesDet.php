<?php

namespace GritTekno\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AksesDet extends Model
{
    use SoftDeletes;

    protected $table = 'akses_det';

    protected $guarded = ['id_uad'];
    protected $primaryKey = 'id_uad';

    protected $dates = ['deleted_at'];
    
    public function menu()
    {
        return $this->belongsTo('GritTekno\Menu\Models\Menu', 'id_mnu', 'id_mnu');
    }
}
