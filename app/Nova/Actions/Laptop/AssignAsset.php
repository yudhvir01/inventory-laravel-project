<?php

namespace App\Nova\Actions;

use App\Models\User;
use App\Models\Assign;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\Boolean;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Http\Requests\NovaRequest;

class AssignAsset extends Action
{
    use InteractsWithQueue, Queueable;

    public function handle(ActionFields $fields, Collection $models)
    {

        $user = User::findOrFail($fields->user);
        $company = Company::findOrFail($fields->company);
        $branch = Branch::findOrFail($fields->branch);
        $department = Department::findOrFail($fields->department);


        foreach ($models as $asset) {
            $asset->assign($user, $branch, $department,$company, $fields->keyboard, $fields->mouse);
            $asset->save();
        }

        return Action::message('Asset has been assigned successfully.');
    }

    public function fields(NovaRequest $request)
    {
        return [

            Select::make('User')->searchable()->options(function () {
                return User::pluck('name', 'id');
            }),
            Select::make('Company')->searchable()->options(function () {
                return Company::pluck('name', 'id');
            }),
            Select::make('Branch')->searchable()->options(function () {
                return Branch::pluck('name', 'id');
            }),
            Select::make('Department')->searchable()->options(function () {
                return Department::pluck('name', 'id');
            }),
            Boolean::make('Keyboard', 'keyboard'),
            Boolean::make('Mouse', 'mouse'),
        ];
    }
}
