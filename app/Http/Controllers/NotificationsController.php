<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationsController extends Controller
{
    public function index(): View
    {
        $notifications = auth()->user()
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function recent(): JsonResponse
    {
        $user = auth()->user();

        $recent = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id', 'title', 'message', 'read_at', 'created_at'])
            ->map(fn ($n) => [
                'id' => $n->id,
                'title' => $n->title,
                'message' => $n->message,
                'read_at' => $n->read_at?->toIso8601String(),
                'created_at' => $n->created_at->toIso8601String(),
            ]);

        $unreadCount = $user->notifications()->unread()->count();

        return response()->json([
            'unread_count' => $unreadCount,
            'recent' => $recent,
        ]);
    }

    public function markAsRead(Notification $notification): RedirectResponse
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['read_at' => now()]);

        return back();
    }

    public function markAllAsRead(): RedirectResponse
    {
        auth()->user()
            ->notifications()
            ->unread()
            ->update(['read_at' => now()]);

        return back()->with('status', 'Todas las notificaciones marcadas como leídas.');
    }
}
