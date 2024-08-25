<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Http\Requests\NovaRequest;

class UnassignAsset extends Action
{
    use InteractsWithQueue, Queueable;

    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $assign) {
            $assignable = $assign->assignable;
            if (method_exists($assignable, 'unassign')) {
                $assignable->unassign();
            }
            $assign->unassigned_at = now();
            $assign->save();
        }
        return Action::redirect('/nova/resources/histories');
        return Action::message('Assets have been unassigned.');
    }

    public function fields(NovaRequest $request)
    {
        return [];
    }
}
