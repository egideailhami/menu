<?php

namespace GritTekno\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UsrWeb extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'usr_web';

    protected $guarded = ['id_usr'];
    protected $primaryKey = 'id_usr';

    protected $dates = ['deleted_at'];
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function role()
    {
        return $this->belongsTo('GritTekno\Menu\Models\AksesUsr', 'id_uaks');
    }
}
