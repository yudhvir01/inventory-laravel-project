<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class History extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Assign>
     */
    public static $model = \App\Models\Assign::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'User',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('User'),
            BelongsTo::make('Branch'),
            BelongsTo::make('Department'),
            MorphTo::make('Assignable')
                ->rules('unique:assigns,assignable_type')
                ->types([
                    Laptop::class,
                    CPU::class,
                    IpPhone::class,
                    SmartPhone::class,
                ]),
            Date::make('Assigned At')
                ->sortable()
                //->format('DD/MM/YYYY')
                ->filterable()
                ->exceptOnForms(),
            Date::make('Unassigned At')
                ->sortable()
                //->format('DD/MM/YYYY')
                ->filterable()
                ->nullable(),
            Badge::make('Status', function () {
                return $this->unassigned_at ? 'Unassigned' : 'Assigned';
            })->map([
                'Assigned' => 'success',
                'Unassigned' => 'danger',
            ]),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereNotNull('unassigned_at');
    }
}
