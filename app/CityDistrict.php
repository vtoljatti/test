<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityDistrict extends Model
{
    protected $table = 'cities_districts';
    protected $fillable = ['*'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function streets()
    {
        return $this->hasMany(CityStreets::class, 'district_id', 'id');
    }
}
