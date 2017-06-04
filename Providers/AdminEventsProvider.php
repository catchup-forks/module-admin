<?php

namespace App\Modules\Admin\Providers;

use App\Modules\Core\Providers\BaseEventsProvider;
use App\Modules\Core;
use App\Modules\Admin;
use Cache;

class AdminEventsProvider extends BaseEventsProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Modules\Admin\Events\ConfigWasSaved' => [
            'App\Modules\Admin\Events\Handlers\SetDebug',
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [

    ];

    /**
     * Register any other events for your application.
     */
    public function boot()
    {
        parent::boot();

        Core\Models\DBConfig::saved(function ($model) {
            Cache::forget('core.config_table');
            event(new Admin\Events\ConfigWasSaved($model->key, $model->value));
        });
    }
}
