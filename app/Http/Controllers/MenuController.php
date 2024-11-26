<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menu = Menu::get();
        
        return view('Menu.data', compact('menu'));
    }


    public function create()
    {
        
        return view('menu.create');
    }

    public function store(){

    }

    public function submit(Request $request)
    {
        $Vdata = $request->validate([
        'harga'=>'required|numeric|min:1'
        ]);
        $menu = new Menu();
        $menu->nama_menu = $request->nama_menu;
        $menu->jenis = $request->jenis;
        $menu->harga = $Vdata['harga'];
        $menu->save();

        return redirect()->route('menu');
    }
    public function edit($id)
    {
        $menu = Menu::find($id);
        return view('Menu.edit',compact('menu'));
    }

    public function update ( Request $request, $id){
        $menu = Menu::find($id);
        $menu->nama_menu = $request->nama_menu;
        $menu->jenis = $request->jenis;
        $menu->harga = $request->harga;
        $menu->update();

        return redirect()->route('menu');

    }


    public function delete($id){
        $menu = menu::find($id);
        $menu->delete();

        session()->flash('success','berhasil menghapus menu!');

        return redirect()->route('menu');
        
    }


   
}
