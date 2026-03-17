<?php

namespace App\Livewire\Admin\Jobs;

use App\Livewire\Admin\AComponent;
use App\Models\FailedJob;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;


class Index extends AComponent
{
    use withPagination;
    use WithoutUrlPagination;
    public $showExceptionModal = false;
    public $selectedException = null;

    public $search;
    public function updatedSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        $page = get_system_pagination();
        $items = FailedJob::query()
            ->when($this->search, function ($q) {
                $q->where('uuid', 'like', "%{$this->search}%")
                    ->orWhere('queue', 'like', "%{$this->search}%")
                    ->orWhere('exception', 'like', "%{$this->search}%");
            })

            ->paginate($page);

        $count = FailedJob::count();

        return view('livewire.admin.jobs.index', compact('items', 'count'));
    }


    public function showException($id)
    {
        $job = FailedJob::findOrFail($id);

        $this->selectedException = $job->exception;
        $this->showExceptionModal = true;
    }


}
