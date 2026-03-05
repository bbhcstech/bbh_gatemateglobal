<?php

namespace App\Http\Controllers;

use App\Models\HelpRating;
use Illuminate\Http\Request;

class HelpRatingController extends Controller
{
    public function index()
    {
        $ratings = HelpRating::latest()->get();
        return view('admin.help_ratings.index', compact('ratings'));
    }

    public function create()
    {
        return view('admin.help_ratings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'help_id' => 'required|numeric',
            'resident_id' => 'required|numeric',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string'
        ]);

        HelpRating::create($request->all());

        return redirect()->route('help-ratings.index')
            ->with('success', 'Rating added successfully');
    }

    public function edit(HelpRating $helpRating)
    {
        return view('admin.help_ratings.edit', compact('helpRating'));
    }

    public function update(Request $request, HelpRating $helpRating)
    {
        $request->validate([
            'help_id' => 'required|numeric',
            'resident_id' => 'required|numeric',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string'
        ]);

        $helpRating->update($request->all());

        return redirect()->route('help-ratings.index')
            ->with('success', 'Rating updated successfully');
    }

    public function destroy(HelpRating $helpRating)
    {
        $helpRating->delete();

        return redirect()->route('help-ratings.index')
            ->with('success', 'Rating deleted successfully');
    }
}
