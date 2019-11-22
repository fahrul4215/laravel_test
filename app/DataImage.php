<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataImage extends Model
{
    protected $fillable = [
        'id', 'title', 'image', 'status'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'data_images';
}
