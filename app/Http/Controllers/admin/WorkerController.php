<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\Worker;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class WorkerController extends Controller
{
    public function list()
    {
        $workers = Worker::all();
        return view('admin.worker.list', compact('workers'));
    }

    public function create()
    {
        return view('admin.worker.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:workers',
            'phone_number' => 'required',
            'profile_image' => 'nullable|image',
            'joining_date' => 'required|date',
            'gender' => 'required',
            'state' => 'required',
            'file' => 'nullable|file',
        ]);

        $worker = new Worker();
        $worker->fill($request->all());

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/student_upload'), $imageName);
            $worker->profile_image = $imageName;
        }

        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('upload/student_files'), $fileName);
            $worker->file = $fileName;
        }

        $worker->save();

        return response()->json([
            'message' => 'Worker Profile Created Successfully',
        ], 201)->route('worker.list');
    }

    public function edit($id)
    {
        $worker = Worker::findOrFail($id);
        return view('admin.worker.edit', compact('worker'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:workers,email,' . $id,
            'phone_number' => 'required',
            'profile_image' => 'nullable|image',
            'joining_date' => 'required|date',
            'gender' => 'required',
            'state' => 'required',
            'file' => 'nullable|file',
        ]);

        $worker = Worker::findOrFail($id);
        $worker->fill($request->all());

        if ($request->hasFile('profile_image')) {
            if ($worker->profile_image) {
                File::delete(public_path('upload/student_upload/' . $worker->profile_image));
            }

            $file = $request->file('profile_image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/student_upload'), $imageName);
            $worker->profile_image = $imageName;
        }

        if ($request->hasFile('file')) {
            if ($worker->file) {
                File::delete(public_path('upload/student_files/' . $worker->file));
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/student_files'), $fileName);
            $worker->file = $fileName;
        }

        $worker->save();

        return response()->json([
            'message' => 'Worker Profile Updated Successfully',
        ], 200);
    }

    public function delete($id)
    {
        $worker = Worker::findOrFail($id);

        if ($worker->profile_image) {
            File::delete(public_path('upload/student_upload/' . $worker->profile_image));
        }

        if ($worker->file) {
            File::delete(public_path('upload/student_files/' . $worker->file));
        }

        $worker->delete();

        return response()->json([
            'message' => 'Worker Profile Deleted Successfully',
        ], 200);
    }
}
