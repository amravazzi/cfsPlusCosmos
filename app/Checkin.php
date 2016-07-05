<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'checkins';

    /**
     * Relationship: User
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Relationship: Place
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function place()
    {
        return $this->belongsTo('App\Place');
    }
}