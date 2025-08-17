<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Notifications\OfferMade;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ListingOfferController extends Controller
{
    use AuthorizesRequests;
    public function store(Listing $listing, Request $request)
    {

        # هون بقدر اضيف اي ابيليتي بأي اسم عادي بس استخدمت الفيو لانه بنفس اللوجيك اللي بدي اياه وهاي ايدج كيس اذا كان اليوز فاتح
        # الصفحه من قبل وصار سولد واجا حاول يعمل اوفر عشان يمنعه
        $this->authorize('view', $listing);

        $offer = $listing->offers()->save(
                    Offer::make( #الميك بتكريت الموديل بدون ما تعمل حفظ بالداتا بيز عكس الكرييت
                        $request->validate([
                            'amount' => 'required|integer|min:1|max:20000000'
                        ])
                    )->bidder()->associate($request->user()) #هاي البيلونج تو لليوزر كمان
                );

        $listing->owner->notify(new OfferMade($offer));

        // بقدر اكتبها هيك بدل اللي فوق
        // $offer = Offer::make($request->validate([
        //                     'amount' => 'required|integer|min:1|max:20000000'
        // ]));

        // $offer->bidder()->associate($request->user());
        // $listing->offers()->save($offer);

        return redirect()->back()->with(
            'success', 'offer was made successfully'
        );
    }
}
