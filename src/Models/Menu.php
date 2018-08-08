<?php

namespace Egideailhami\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $table = 'menu';

    protected $guarded = ['id_mnu'];
    protected $primaryKey = 'id_mnu';

    protected $dates = ['deleted_at'];
    
    public function aksesDets()
    {
        return $this->hasMany('App\Models\AksesDet', 'id_mnu', 'id_mnu');
    }
}
