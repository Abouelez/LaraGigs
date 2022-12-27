<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PhpParser\Node\Expr\List_;

class JobController extends Controller
{
    public function index()
    {
        return view('jobs.index', [
            'jobs' => Job::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    public function show(Job $job)
    {
        return view('jobs.show', [
            'job' => $job
        ]);
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $formFields['user_id'] = auth()->id();
        Job::create($formFields);
        return redirect('/')->with('message', 'Job posted successfully!');
    }

    public function edit(Job $job)
    {
        return view('jobs.edit', ["job" => $job]);
    }

    public function update(Request $request, Job $job)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $job->update($formFields);
        return redirect('/')->with('message', 'Job Updated successfully!');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect('/')->with('message', 'Job Deleted successfully!');
    }

    public function manage()
    {
        return view('jobs.manage', [
            'jobs' => auth()->user()->jobs()->get()
        ]);
    }
}
