<?php

namespace App\Http\Livewire\Tables;

use App\Models\Contracts;
use Livewire\Component;
use Livewire\WithPagination;

class ContractsTable extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $search = '';
    public $sortField = 'contract_no';
    public $sortAsc = false;

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function render()
    {
        return view('livewire.tables.contracts-table', [
            'contracts' => Contracts::where("user_id", auth()->id())
                ->with('supplier')
                ->search($this->search)
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]);
    }
}

