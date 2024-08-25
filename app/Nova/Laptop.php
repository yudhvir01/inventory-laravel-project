<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MorphMany;
use Illuminate\Support\Facades\Log;
use App\Models\Laptop as ModelsLaptop;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;



class Laptop  extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Laptop>
     */
    public static $model = \App\Models\Laptop::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function title()
    {
        return $this->uid; // . ' ' . $this->system_serial_number;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id'
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
            ID::make()->hidden()->sortable()->hide(),


            Text::make('UID', 'uid')->showWhenPeeking()
                ->exceptOnForms()
                ->sortable()
                ->readonly(),


            BelongsTo::make('Manufacturer')->sortable()->showWhenPeeking(),


            BelongsTo::make('Processor')->sortable()->showWhenPeeking()
                ->dependsOn(['manufacturer'], function (BelongsTo $field, NovaRequest $request, $formData) {
                    if (isset($formData->manufacturer)) {
                        $field->relatableQueryUsing(function (NovaRequest $request, Builder $query)  use ($formData) {
                            $query->where('manufacturer_id', $formData->manufacturer);
                        });
                    } else {
                        $field->readonly();
                    }
                }),

            BelongsTo::make('Version')
                ->sortable()
                ->showWhenPeeking()
                ->dependsOn(['manufacturer'], function (BelongsTo $field, NovaRequest $request, $formData) {
                    if (isset($formData->manufacturer)) {
                        $field->relatableQueryUsing(function (NovaRequest $request, Builder $query)  use ($formData) {
                            $query->where('manufacturer_id', $formData->manufacturer);
                        });
                    } else {
                        $field->readonly();
                    }
                }),

            Text::make('System Serial Number', 'system_serial_number')
                ->sortable(),

            Select::make('RAM', 'ram')->sortable()->showWhenPeeking()
                ->options([
                    '2GB' => '2GB',
                    '4GB' => '4GB',
                    '8GB' => '8GB',
                    '16GB' => '16GB',
                ]),
            Select::make('Memory Type', 'memory_type')->sortable()
                ->options([
                    'HDD' => 'HDD',
                    'SSD' => 'SSD',
                    'NVME' => 'NVME',
                ]),
            Select::make('Memory Size', 'memory_size')->sortable()->showWhenPeeking()
                ->options([
                    '120GB' => '120GB',
                    '240GB' => '240GB',
                    '256GB' => '256GB',
                    '512GB' => '512GB',
                    '1TB' => '1TB',
                ]),
            Boolean::make('Keyboard', 'keyboard')->hideFromIndex()
                ->trueValue(1)
                ->filterable()
                ->falseValue(0)
                ->sortable(),
            Boolean::make('Mouse', 'mouse')->hideFromIndex()
                ->trueValue(1)
                ->filterable()
                ->falseValue(0)
                ->sortable(),
            Boolean::make('Assigned', 'is_assigned')->onlyOnIndex()
                ->trueValue(1)
                ->filterable()
                ->falseValue(0)
                ->sortable(),


            Text::make('Remarks', 'remarks')->sortable(),

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
            (new Actions\AssignAsset)->sole()->canSee(function ($request) {

                return ModelsLaptop::assigned()->whereIn('id', $request->selectedResourceIds()->toArray())->count() == 0;
            })
        ];
    }
}
