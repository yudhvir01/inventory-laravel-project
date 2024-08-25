<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DownloadAssignDetails extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Download Assign Details';

    public function handle(ActionFields $fields, Collection $models)
    {
        $model = $models->first();

        // Return a response that will open the assign details in a new tab
        return Action::openInNewTab(route('view.assign.details', ['id' => $model->id]));
    }

    public function authorizedToSee(Request $request)
    {
        return true;
    }

    public function authorizedToRun(Request $request, $model)
    {
        return true;
    }
}
