<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RealtorListingController extends Controller
{

    #هاي اليوز مشان البوليسي
    use AuthorizesRequests;
    public function __construct()
    {
        #وهاي مشان استخدم البوليسي ولازم يكون اسمها بنفس الكونفينشن مشان لارافيل توصللها
        $this->authorizeResource(Listing::class, 'listing');
    }

    public function index(Request $request)
    {
        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['by', 'order'])
        ];

        return Inertia('Realtor/Index', [
            'filters' => $filters,
            'listings' => Auth::user()
                        ->listings()
                        ->filter($filters)
                        ->withCount('images')
                        ->withCount('offers')
                        ->paginate(5)
                        ->withQueryString(),
        ]);
    }

    public function show(Listing $listing)
    {
        return Inertia('Realtor/Show', [
            'listing' => $listing->load('offers', 'offers.bidder')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia('Realtor/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->user()->listings()->create(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:0|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_nr' => 'required|min:1|max:1000',
                'price' => 'required|integer|min:1|max:20000000',
            ])
        );

        return redirect()->route('realtor.listing.index')
            ->with('success', 'Listing Created Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        return Inertia('Realtor/Edit',
            [
                "listing" => $listing
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        $listing->update(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:15|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_nr' => 'required|min:1|max:1000',
                'price' => 'required|integer|min:1|max:20000000',
            ])
        );

        return redirect()->route('realtor.listing.index')
            ->with('success', 'Listing was changed!');
    }

    public function destroy(Listing $listing)
    {
        $listing->deleteOrFail();

        return redirect()->back()
                ->with('success', 'Listing was deleted!');
    }

    // هذا ملوش علاقه بالريسورس كنترول انا ضفته مانيوالي
     public function restore (Listing $listing)
    {
        $listing->restore();

        return redirect()->back()
                ->with('success', 'Listing was restored!');
    }
}
