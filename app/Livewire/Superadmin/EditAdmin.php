<?php

namespace App\Livewire\Superadmin;

use Livewire\Component;

class EditAdmin extends Component
{
     public $adminId;
    public $name, $email, $academy_name, $is_paid, $is_blocked;

    protected $listeners = ['editAdmin' => 'loadAdmin'];

    public function loadAdmin($id)
    {
        $admin = User::findOrFail($id);
        $this->adminId = $admin->id;
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->academy_name = $admin->academy_name;
        $this->is_paid = $admin->is_paid;
        $this->is_blocked = $admin->is_blocked;
    }

    public function updateAdmin()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->adminId,
            'academy_name' => 'required|string|max:255',
        ]);

        $admin = User::findOrFail($this->adminId);
        $admin->update([
            'name' => $this->name,
            'email' => $this->email,
            'academy_name' => $this->academy_name,
            'is_paid' => (bool) $this->is_paid,
            'is_blocked' => (bool) $this->is_blocked,
        ]);

        $this->dispatchBrowserEvent('admin-updated');
        session()->flash('success', 'Admin updated successfully!');
    }

    public function render()
    {
        return view('livewire.superadmin.edit-admin');
    }
}
