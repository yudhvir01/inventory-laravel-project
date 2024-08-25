<?php
namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class StatusFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        if ($value === 'Assigned') {
            return $query->whereNull('unassigned_at');
        } elseif ($value === 'Unassigned') {
            return $query->whereNotNull('unassigned_at');
        }

        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Assigned' => 'Assigned',
            'Unassigned' => 'Unassigned',
        ];
    }

    /**
     * Get the default value for the filter.
     *
     * @return mixed
     */
    public function default()
    {
        return 'Assigned';
    }
}
