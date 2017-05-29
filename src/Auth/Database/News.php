<?php

namespace Kizi\Admin\Auth\Database;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Menu.
 *
 * @property int $id
 *
 * @method where($parent_id, $id)
 */
class News extends Model
{
    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.news_table'));

        parent::__construct($attributes);
    }
}
