<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use App\Nova\Actions\AssignNvr;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MorphMany;
use App\Nova\Actions\AssignSmartPhone;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\NetworkNVR as ModelsNetworkNVR;

class NetworkNVR extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\AccessPoint>
     */
    public static $model = \App\Models\NetworkNVR::class;

    public static function label()
    {
        return 'Network NVR';
    }
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

            Select::make('Storage', 'storage')->sortable()->showWhenPeeking()
                ->options([
                    '4 TB' => '4 TB',
                    '8 TB' => '8 TB',
                ]),
            Text::make('Serial Number', 'serial_number')->showWhenPeeking(),
            Text::make('Channel', 'channel')->showWhenPeeking(),
            Text::make('Remarks', 'remarks')->showWhenPeeking(),
            Boolean::make('Assigned', 'is_assigned')->onlyOnIndex()
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
            (new AssignNvr)->sole()->canSee(function ($request) {

                return ModelsNetworkNVR::assigned()->whereIn('id', $request->selectedResourceIds()->toArray())->count() == 0;
            }),
        ];
    }
}
