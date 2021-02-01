<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class UserForm extends Component
{
    protected $listeners = ['triggerEdit'];

    public $user_id;
    public $name;
    public $email;
    public $age;
    public $address;

    public function render()
    {
        return view('livewire.user-form');
    }

    public function save()
    {
        $validate = $this->validate([
            'name' => 'required|min:10',
            'email' => 'required|email|min:10',
            'age' => 'required|integer',
            'address' => 'required|min:10',
        ]);

        if ($this->user_id) {
            User::find($this->user_id)
                ->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'age' => $this->age,
                    'address' => $this->address,
                ]);

            $this->dispatchBrowserEvent('user-saved', ['action' => 'updated', 'user_name' => $this->name]);
        } else {
            User::create(array_merge($validate, [
                'user_type' => 'user',
                'password' => bcrypt($this->email),
            ]));

            $this->dispatchBrowserEvent('user-saved', ['action' => 'created', 'userName' => $this->name]);
        }

        $this->resetForm();
        $this->emit('live-table', 'triggerRefresh');
    }

    public function resetForm()
    {
        $this->user_id = null;
        $this->name = null;
        $this->email = null;
        $this->age = null;
        $this->address = null;
    }

    public function triggerEdit($user)
    {
        $this->user_id = $user['id'];
        $this->name = $user['name'];
        $this->email = $user['email'];
        $this->age = $user['age'];
        $this->address = $user['address'];

        $this->emit('dataFetched', $user);
    }
}
