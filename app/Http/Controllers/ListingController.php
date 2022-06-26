<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
  public function index()
  {
    return view('listings.index', [
      'listings' => Listing::latest()
        ->filter(request(['tag', 'search']))
        ->paginate(2),
    ]);
  }

  public function show(Listing $listing)
  {
    return view('listings.show', [
      'listing' => $listing,
    ]);
  }

  public function create(Listing $listing)
  {
    return view('listings.create', [
      'listing' => $listing,
    ]);
  }

  // store listing data
  public function store(Request $request)
  {
    $formFields = $request->validate([
      'title' => 'required',
      'company' => ['required', Rule::unique('listings', 'company')],
      'location' => 'required',
      'website' => 'required',
      'tags' => 'required',
      'description' => 'required',
      'email' => ['required', 'email'],
    ]);

    if ($request->hasFile('logo')) {
      $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }

    $formFields['user_id'] = auth()->id();

    Listing::create($formFields);

    return redirect('/')->with('message', 'Listing created successfully!');
  }

  // show edit form
  public function edit(Listing $listing)
  {
    return view('listings.edit', ['listing' => $listing]);
  }

  // update listing data
  public function update(Request $request, Listing $listing)
  {
    // Make sure logged in user is owner
    if (auth()->id() !== $listing->user_id) {
      return redirect('/')->with(
        'message',
        'You are not authorized to edit this listing.'
      );
    }
    $formFields = $request->validate([
      'title' => 'required',
      'company' => ['required'],
      'location' => 'required',
      'website' => 'required',
      'tags' => 'required',
      'description' => 'required',
      'email' => ['required', 'email'],
    ]);

    if ($request->hasFile('logo')) {
      $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }

    $listing->update($formFields);

    return back()->with('message', 'Listing updated successfully!');
  }

  //Delete Listing
  public function destroy(Listing $listing)
  {
    // Make sure logged in user is owner
    if (auth()->id() !== $listing->user_id) {
      return redirect('/')->with(
        'message',
        'You are not authorized to edit this listing.'
      );
    }
    $listing->delete();
    return redirect('/')->with('message', 'Listing deleted successfully!');
  }

  // Manage Listing
  public function manage()
  {
    return view('listings.manage', [
      'listings' => auth()->user()->listings,
    ]);
  }
}
