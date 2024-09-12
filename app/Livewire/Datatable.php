<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Datatable extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';

    public function updated($property)
    {
        if ($property === 'search') {
            $this->resetPage();
        }
    }
    
    public function render()
    {
        $employees = DB::table('employees');
        
        if (!empty($this->search)) {
            $search = trim(strtolower($this->search));
            $employees = $employees->where('name', 'like', '%'.$search.'%')
                ->orWhere('office', 'like', '%'.$search.'%')
                ->orWhere('position', 'like', '%'.$search.'%')
                ->orWhere('age', 'like', '%'.$search.'%');
        }
        return view('livewire.datatable', [
            'employees' => $employees->paginate($this->perPage),
        ]);
    }
}
