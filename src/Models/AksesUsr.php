<?php

namespace Egideailhami\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AksesUsr extends Model
{
    use SoftDeletes;

    protected $table = 'akses_usr';

    protected $guarded = ['id_uaks'];
    protected $primaryKey = 'id_uaks';

    protected $dates = ['deleted_at'];
    
    public function aksesDets()
    {
        return $this->hasMany('Egideailhami\Menu\Models\AksesDet', 'id_uaks', 'id_uaks');
    }
}
