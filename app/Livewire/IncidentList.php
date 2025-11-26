<?php

namespace App\Livewire;

use App\Models\Incident;
use Livewire\Component;
use Livewire\WithPagination;

use App\Services\UserService;

class IncidentList extends Component
{
    use WithPagination;

    public function render(UserService $userService)
    {
        // 1. Get paginated incidents without the broken 'with()'
        $incidents = Incident::latest()->paginate(10);

        // 2. Eager load reporters manually to fix N+1 issue
        if ($incidents->isNotEmpty()) {
            // Get all unique reporter IDs from the current page of incidents
            $reporterIds = $incidents->pluck('reporter_id')->unique()->filter()->all();

            // Fetch all required reporters in a single query
            $reporters = $userService->findByIds($reporterIds);

            // Attach each reporter to its corresponding incident
            foreach ($incidents as $incident) {
                $incident->reporter = $reporters->get($incident->reporter_id);
            }
        }

        return view('livewire.incident-list', [
            'incidents' => $incidents,
        ]);
    }

    public function delete(Incident $incident)
    {
        abort_if(!auth()->user()->can('delete incident'), 403);
        $incident->delete();
    }
}