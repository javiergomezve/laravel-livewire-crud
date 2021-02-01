<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class LiveTable extends Component
{
    use WithPagination;

    protected $listeners = ['delete', 'triggerRefresh' => '$refresh'];

    public $sortField = 'name';
    public $sortAsc = true;
    public $search = '';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function delete($id)
    {
        $user = User::find($id);
        $userName =  $user->name;
        $user->delete();
        $this->dispatchBrowserEvent('user-delete', ['userName' => $userName]);
    }

    public function render()
    {
        return view('livewire.live-table', [
            'users' => User::search($this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate()
        ]);
    }
}
