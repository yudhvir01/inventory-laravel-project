<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MorphMany;
use Illuminate\Notifications\Action;
use App\Models\IpPhone as ModelsIpPhone;
use Laravel\Nova\Http\Requests\NovaRequest;

class IpPhone extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\IpPhone>
     */
    public static $model = \App\Models\IpPhone::class;

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
            BelongsTo::make('Version')->sortable()->showWhenPeeking(),
            Text::make('Serial Number', 'system_serial_number')->showWhenPeeking(),
            // Select::make('Model', 'model')->sortable()->showWhenPeeking()
            //     ->options([
            //         'Grand Stream-GRP2601P' => 'Grand Stream-GRP2601P',
            //         'Cisco-CP3905' => 'Cisco-CP3905',
            //     ]),
            Text::make('Extension Number', 'extension_number')->showWhenPeeking(),

            Boolean::make('Assigned', 'is_assigned')
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
            (new Actions\AssignIpPhone)->sole()->canSee(function ($request) {

                return ModelsIpPhone::assigned()->whereIn('id', $request->selectedResourceIds()->toArray())->count() == 0;
            }),
        ];
    }
}
