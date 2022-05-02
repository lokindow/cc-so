<?php

namespace Src\Components\Coffee\Infrastructure\Persistences;

use Illuminate\Database\Eloquent\Model;

class CoffeeModel extends Model
{
    protected $table = 'coffee';
    protected $primaryKey = 'id';
    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;


    public static $arrProperties = [
        'id',
        'beans',
        'water'
    ];

    public function __construct(array $attributes = [])
    {
        $this->fillable = array_values(self::$arrProperties);
        parent::__construct($attributes);
    }

    public function getTable()
    {
        return $this->table;
    }
}
