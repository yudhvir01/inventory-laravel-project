<?php

namespace App\Nova;


use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\MorphTo;
use App\Nova\Filters\StatusFilter;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Filters\AssetTypeFilter;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;


class Assign extends Resource
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
        'User.name', 'User.email'

    ];
    public static function perPageOptions()
    {
        return [100, 200, 300];
    }
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
            // Text::make('User Email', function () {
            //     if ($this->user) {
            //         return $this->user->email;
            //     }
            //     return '';
            // })->onlyOnIndex()->sortable(),

            BelongsTo::make('Company'),
            BelongsTo::make('Branch')->dependsOn(['company'], function (BelongsTo $field, NovaRequest $request, $formData) {
                if (isset($formData->company)) {
                    $field->relatableQueryUsing(function (NovaRequest $request, Builder $query)  use ($formData) {
                        $query->where('company_id', $formData->company);
                    });
                } else {
                    $field->readonly();
                }
            }),
            BelongsTo::make('Department')->dependsOn(['branch'], function (BelongsTo $field, NovaRequest $request, $formData) {
                if (isset($formData->branch)) {
                    $field->relatableQueryUsing(function (NovaRequest $request, Builder $query)  use ($formData) {
                        $query->where('branch_id', $formData->branch);
                    });
                } else {
                    $field->readonly();
                }
            }),
            MorphTo::make('Assignable')
                ->rules('unique:assigns,assignable_type')
                ->types([
                    Laptop::class,
                    CPU::class,
                    IpPhone::class,
                    SmartPhone::class,
                    AccessPoint::class,
                    Biometric::class,
                    Firewall::class,
                    NetworkNVR::class,
                    NetworkSwitch::class,
                    Printer::class,
                ]),
            Boolean::make('Keyboard', function () {
                if ($this->assignable_type === \App\Models\Laptop::class) {
                    return $this->assignable->keyboard;
                }
                return 0;
            })->onlyOnIndex()->sortable(),

            Boolean::make('Mouse', function () {
                if ($this->assignable_type === \App\Models\Laptop::class) {
                    return $this->assignable->mouse;
                }
                return 0;
            })->onlyOnIndex()->sortable(),


            Date::make('Assigned At')
                ->sortable()
                ->exceptOnForms(),
            Date::make('Unassigned At')
                ->sortable()
                ->exceptOnForms()
                ->nullable(),
            Badge::make('Status', function () {
                return $this->unassigned_at ? 'Unassigned' : 'Assigned';
            })->map([
                'Assigned' => 'success',

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
        return [
            new StatusFilter,
            new AssetTypeFilter,
        ];
    }
    public static function searchableColumns()
    {
        return [

            'user.name', 'user.email',
        ];
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
            new Actions\UnassignAsset,
            new Actions\TransferAsset,
            new Actions\DownloadAssignDetails,

        ];
    }
}
