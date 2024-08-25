<?php

namespace App\Nova;

use Matrix\Matrix;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MorphMany;
use App\Nova\Actions\AssignBiometric;
use App\Nova\Actions\AssignSmartPhone;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Biometric as ModelsBiometric;

class Biometric extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Biometric>
     */
    public static $model = \App\Models\Biometric::class;


    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'uid';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'uid',
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
            ID::make()->sortable()->hide(),

            Text::make('UID', 'uid')->showWhenPeeking()
                ->exceptOnForms()
                ->sortable()
                ->filterable()
                ->readonly(),

            BelongsTo::make('Manufacturer')->sortable()->showWhenPeeking(),
            BelongsTo::make('version')->sortable()->showWhenPeeking(),
            Text::make('IP Address', 'ip_address')->showWhenPeeking(),
            Text::make('Mac Address', 'mac_address')->showWhenPeeking(),
            Text::make('Device Id', 'device_id')->showWhenPeeking(),
            Text::make('Remarks', 'remark'),
            Boolean::make('Assigned', 'is_assigned')->onlyOnIndex()
                ->onlyOnIndex()
                ->trueValue(1)
                ->filterable()
                ->falseValue(0)
                ->sortable(),
            HasMany::make('assetdetail'),
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
        return [
            (new AssignBiometric)->sole()->canSee(function ($request) {

                return ModelsBiometric::assigned()->whereIn('id', $request->selectedResourceIds()->toArray())->count() == 0;
            }),
        ];
    }
}
