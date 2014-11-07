<?php
namespace TypiCMS\Modules\History\Models;

use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;

class History extends Base
{

    use PresentableTrait;

    protected $table = 'history';
    protected $presenter = 'TypiCMS\Modules\History\Presenters\ModulePresenter';

    protected $fillable = array(
        'historable_id',
        'historable_type',
        'historable_table',
        'title',
        'user_id',
        'action',
    );

    protected $appends = ['user_name', 'href'];

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'history';

    /**
     * lists
     */
    public $order = 'id';
    public $direction = 'desc';

    /**
     * History item morph to model
     */
    public function historable()
    {
       return $this->morphTo();
    }

    /**
     * History item belongs to a user
     */
    public function user()
    {
       return $this->belongsTo('TypiCMS\Modules\Users\Models\User');
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getUserNameAttribute()
    {
        if ($this->user) {
            return $this->user->first_name . ' ' . $this->user->last_name;
        }
        return null;
    }

    /**
     * Get title (overwrite Base model method)
     * 
     * @param  string $value
     * @return string
     */
    public function getTitleAttribute($value)
    {
        return $value;
    }

    /**
     * Get title (overwrite Base model method)
     * 
     * @return string
     */
    public function getHrefAttribute()
    {
        return route('admin.' . $this->historable_table . '.edit', $this->historable_id);
    }
}
