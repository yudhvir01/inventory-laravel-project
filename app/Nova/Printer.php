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
use App\Nova\Actions\AssignPrinter;
use App\Nova\Actions\AssignSmartPhone;
use App\Models\Printer as ModelsPrinter;
use Laravel\Nova\Http\Requests\NovaRequest;

class Printer extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Printer>
     */
    public static $model = \App\Models\Printer::class;


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

            Text::make('Printer Type', 'printer_type')->showWhenPeeking(),
            Text::make('Ip Address', 'ip_address')->showWhenPeeking(),
            Text::make('Serial Number', 'serial_number')->showWhenPeeking(),
            Text::make('Ink Code', 'ink_code')->showWhenPeeking(),
            Text::make('Maintenance Box', 'maintenance_box')->showWhenPeeking(),

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
            (new AssignPrinter)->sole()->canSee(function ($request) {

                return ModelsPrinter::assigned()->whereIn('id', $request->selectedResourceIds()->toArray())->count() == 0;
            }),
        ];
    }
}
