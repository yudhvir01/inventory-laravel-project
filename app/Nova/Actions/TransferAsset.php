<?php

namespace App\Nova\Actions;

use App\Models\User;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\Boolean;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Http\Requests\NovaRequest;

class TransferAsset extends Action
{
    use InteractsWithQueue, Queueable;

    public function handle(ActionFields $fields, Collection $models)
    {
        $user = User::findOrFail($fields->user);
        $company = Company::findOrFail($fields->company);
        $branch = Branch::findOrFail($fields->branch);
        $department = Department::findOrFail($fields->department);

        foreach ($models as $assign) {
            $assignable = $assign->assignable;

            // Unassign
            if (method_exists($assignable, 'unassign')) {
                $assignable->unassign();
            }
            $assign->unassigned_at = now();
            $assign->save();

            // Reassign
            $assignable->assign($user, $branch, $department, $company, $fields->keyboard, $fields->mouse);
        }
        return Action::redirect('/nova/resources/assigns');
        return Action::message('Assets have been transferred.');
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
