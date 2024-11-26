<?php

namespace App\Livewire;

use App\Models\Employee;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Buku extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $nama;
    public $email;
    public $alamat;
    public $exitingfoto;
    public $image;

    public $perPage = 2;
    public $employee_id;
    public $updateData = false;

    public $search;



    public function render()
    {
        if ($this->search != null) {

            $data = Employee::where('nama', 'like', '%' . $this->search)->orWhere('nama', 'like', '%' . $this->search)->orWhere('email', 'like', '%' . $this->search)->orWhere('alamat', 'like', '%' . $this->search)->orderBy('nama', 'asc')->paginate($this->perPage);
        } else {
            $data = Employee::orderBy('nama', 'asc')->paginate($this->perPage);
        }

        return view('livewire.buku', ['dataEmployee' => $data])
        ->extends('livewire');
    }

    public function store()
    {
        $rules = [
            'nama' => 'required|min:5',
            'email' => 'required|email',
            'alamat' => 'required|min:5',
            'image' => 'required|max:1024|nullable|sometimes'

        ];

        $validated = $this->validate($rules);
        if ($this->image) {
            $validated['image'] = $this->image->store('uploads', 'public');
        }

        Employee::create($validated);
        session()->flash('message', 'Data Berhasil Dimasukan!');
        $this->clear();
    }

    public function edit($id)
    {
        $data = Employee::find($id);
        $this->nama = $data->nama;
        $this->email = $data->email;
        $this->alamat = $data->alamat;
        $this->updateData = true;
        $this->employee_id = $id;
    }

    public function update()
    {
        $rules = [
            'nama' => 'required|min:5',
            'email' => 'required|email',
            'alamat' => 'required|min:5',
            'image' => 'required|max:1024|nullable|sometimes'

        ];
        $validated = $this->validate($rules);
        $data = Employee::find($this->employee_id);
        if ($this->image) {
            // Hapus gambar lama jika ada
            if ($data->image && file_exists(public_path('storage/uploads/' . $data->image))) {
                unlink(public_path('storage/uploads/' . $data->image));
            }

            // Simpan file gambar ke dalam folder 'public/uploads'
            $imagePath = $this->image->store('uploads', 'public');

            // Update path gambar di database
            $validated['image'] = $imagePath;
        } // Gunakan foto lama jika tidak ada yang baru
        $data->update($validated);
        session()->flash('message', 'Data Telah Berhasil Di Update !');
        $this->clear();
    }

    public function clear()
    {
        $this->nama = '';
        $this->email = '';
        $this->alamat = '';
        $this->image = '';
        $this->updateData = false;
        $this->employee_id = '';
    }

    public function delete()
    {
        $id = $this->employee_id;
        Employee::find($id)->delete();
        session()->flash('message', 'Data Berhasil Di Hapus !');
        $this->clear();
    }

    public function delete_konfirmasi($id)
    {
        $this->employee_id = $id;
        // $this->clear();
    }


}
