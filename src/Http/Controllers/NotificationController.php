<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
use Jacofda\Klaxon\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->paginate();
        return view('jacofda::notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['read' => 1]);
        return 'done';
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return 'done';
    }

    public function show(Notification $notification)
    {
        return view('jacofda::notifications.show', compact('notification'));
    }

}
