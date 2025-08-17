<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NotificationSeenController extends Controller
{

    use AuthorizesRequests;

    /**
     * DatabaseNotification
     * هاي الموديل تاعت النوتيفيكيشن  انا شفتها  بس هي موجوده من لارافيل
     * ضفتها هون عشان الداتا موديل  بايندنج
     *
     */
    public function __invoke(DatabaseNotification $notification)
    {
        $this->authorize('update', $notification);
        $notification->markAsRead();

        return redirect()->back()
            ->with('success' , 'Notification marked as read');
    }
}
