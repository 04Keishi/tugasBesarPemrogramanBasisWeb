<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $items = Project::with('customer')->orderBy('no_so')->get();

        return view('master.project.index', compact('items'));
    }

    public function create()
    {
        $customers = Customer::orderBy('nama_rek')->get();

        return view('master.project.form', ['item' => null, 'customers' => $customers]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'no_so'        => ['required', 'string', 'max:30', 'unique:project,no_so'],
            'id_customer'  => ['nullable', 'string', 'exists:customer,id_customer'],
            'nama_project' => ['required', 'string', 'max:200'],
        ]);

        Project::create($data);

        return redirect()->route('project.index')
            ->with('flash_success', 'Data project berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $item = Project::findOrFail($id);
        $customers = Customer::orderBy('nama_rek')->get();

        return view('master.project.form', compact('item', 'customers'));
    }

    public function update(Request $request, string $id)
    {
        $item = Project::findOrFail($id);

        $data = $request->validate([
            'no_so'        => ['required', 'string', 'max:30', "unique:project,no_so,{$id},no_so"],
            'id_customer'  => ['nullable', 'string', 'exists:customer,id_customer'],
            'nama_project' => ['required', 'string', 'max:200'],
        ]);

        $item->update($data);

        return redirect()->route('project.index')
            ->with('flash_success', 'Data project berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        try {
            Project::findOrFail($id)->delete();

            return redirect()->route('project.index')
                ->with('flash_success', 'Data project berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->route('project.index')
                ->with('flash_error', 'Gagal menghapus (kemungkinan masih dipakai pada Purchase Order).');
        }
    }
}
