<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\ChatMessage;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealtimeController extends Controller
{
    public function stream(Request $request)
    {
        return response()->stream(function () {
            // Disable time limit for streaming response
            set_time_limit(0);

            $lastNotificationId = 0;
            $lastMessageId = 0;

            for ($i = 0; $i < 10; $i++) {
                // Fetch unread notifications
                $notifications = Notification::where('id', '>', $lastNotificationId)
                    ->where('is_read', false)
                    ->latest()
                    ->get();

                if ($notifications->count() > 0) {
                    $lastNotificationId = $notifications->first()->id;
                    echo "event: notification\n";
                    echo "data: " . json_encode($notifications) . "\n\n";
                    ob_flush();
                    flush();
                }

                // Send heartbeat ping
                echo "event: ping\n";
                echo "data: " . json_encode(['time' => date('Y-m-d H:i:s')]) . "\n\n";
                ob_flush();
                flush();

                sleep(2);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    public function pollNotifications()
    {
        $notifications = Notification::latest()->limit(5)->get();
        $unreadCount = Notification::where('is_read', false)->count();
        $pendingBookingsCount = Booking::where('status', 'pending')->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
            'pending_bookings_count' => $pendingBookingsCount
        ]);
    }

    public function markRead($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->update(['is_read' => true]);
        }
        return response()->json(['status' => 'success']);
    }
}
