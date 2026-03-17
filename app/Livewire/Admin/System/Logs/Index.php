<?php

namespace App\Livewire\Admin\System\Logs;

use App\Livewire\Admin\AComponent;
use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Spatie\Activitylog\Models\Activity;

class Index extends AComponent
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $selectedLog = null;

    #[Url] public $adminId = '';
    #[Url] public $action = '';
    #[Url] public $search = '';
    #[Url] public $subjectType = '';
    #[Url] public $dateFrom = '';
    #[Url] public $dateTo = '';
    #[Url] public $ip = '';

    public $perPage = 20;

    protected $updatesQueryString = [
        'adminId',
        'action',
        'search',
        'subjectType',
        'dateFrom',
        'dateTo',
        'ip',
    ];


    public function updated($property)
    {
        if (in_array($property, [
            'adminId',
            'action',
            'search',
            'subjectType',
            'dateFrom',
            'dateTo',
            'ip'
        ])) {
            $this->resetPage();
        }
    }

    public function selectLog($id)
    {
        $this->selectedLog = Activity::with(['causer','subject'])->findOrFail($id);
    }

    public function closeModal()
    {
        $this->selectedLog = null;
    }


    public function clearLogs(): void
    {
        abort_unless(
            auth('admin')->user()?->hasRole('Super Admin'),
            403
        );

        DB::transaction(function () {
            Activity::query()->delete();
        });

        $this->resetPage();
        session()->flash('success', 'All system logs cleared successfully.');
    }


    public function render()
    {
        $query = Activity::query()
            ->with(['causer','subject'])
            ->latest();

        /* ------------------ FILTERS ------------------- */

        if ($this->adminId) {
            $query->where('causer_id', $this->adminId)
                ->where('causer_type', Employee::class);
        }

        if ($this->action) {
            $query->where('description', $this->action);
        }

        if ($this->subjectType) {
            $query->where('subject_type', $this->subjectType);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', "%{$this->search}%")
                    ->orWhere('properties', 'like', "%{$this->search}%")
                    ->orWhere('subject_id', 'like', "%{$this->search}%");
            });
        }

        if ($this->ip) {
            $query->where('properties->ip', $this->ip);
        }

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        /* --------------- Clone for count -------------- */
        $totalCount = (clone $query)->count();

        return view('livewire.admin.system.logs.index', [
            'items' => $query->paginate($this->perPage),
            'admins' => Employee::orderBy('name')->get(),
            'count' => $totalCount,
            'models' => Activity::select('subject_type')
                ->distinct()
                ->pluck('subject_type'),
            'stats' => [
                'today' => Activity::whereDate('created_at', today())->count(),
                'week' => Activity::whereBetween(
                    'created_at',
                    [now()->startOfWeek(), now()->endOfWeek()]
                )->count(),
                'month' => Activity::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'total' => Activity::count(),
            ],
        ]);
    }
}
