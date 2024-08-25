<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Select;
use App\Models\CPU as ModelsCPU;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MorphMany;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;

class CPU extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\CPU>
     */
    public static function label()
    {
        return 'CPU';
    }

    public static $model = \App\Models\CPU::class;
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
        'system_serial_number',
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
                    '256GB' => '256GB',
                    '512GB' => '512GB',
                    '1TB' => '1TB',
                ]),
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
            (new Actions\AssignCPU)->sole()->canSee(function ($request) {

                return ModelsCPU::assigned()->whereIn('id', $request->selectedResourceIds()->toArray())->count() == 0;
            }),
        ];
    }
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->orderBy('UID', 'asc');
    }
}
