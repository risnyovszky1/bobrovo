<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Group;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    // ---- GROUPS -----

    public function index()
    {
        $groups = Group::query()
            ->where('created_by', Auth::user()->id)
            ->withCount('students')
            ->orderBy('name')
            ->get();

        return view('admin.group.list', ['groups' => $groups]);
    }

    public function create()
    {
        return view('admin.group.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:6',
            'desc' => 'required|min:10'
        ]);

        $group = new Group([
            'name' => $request->input('title'),
            'description' => $request->input('desc'),
            'created_by' => Auth::user()->id
        ]);

        $group->save();

        $this->flashMsg('Skupina "' . $group->name . '" bola úspešne pridaná.');

        return redirect()->route('group.show', $group);
    }

    public function destroy(Group $group)
    {
        $this->flashMsg('Skupina "' . $group->name . '" bola úspešne vymazaná.');

        $group->delete();

        return redirect()->route('group.index');
    }

    public function show(Group $group)
    {
        $group->load('students');

        return view('admin.group.show', ['group' => $group]);
    }

    public function edit(Group $group)
    {
        return view('admin.group.edit', ['group' => $group]);
    }

    public function update(Request $request, Group $group)
    {
        $this->validate($request, [
            'title' => 'required',
            'desc' => 'required'
        ]);

        $group->update([
            'name' => $request->input('title'),
            'description' => $request->input('desc'),
        ]);

        $this->flashMsg('Skupina "' . $group->name . '" bola úspešne upravená.');

        return redirect()->route('group.show', $group);
    }
}
