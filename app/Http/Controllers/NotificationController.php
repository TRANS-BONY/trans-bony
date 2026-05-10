<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $unreadNotifications = $user->unreadNotifications;
        
        return response()->json([
            'count' => $unreadNotifications->count(),
            'items' => $unreadNotifications->map(function($n) {
                return [
                    'id' => $n->id,
                    'message' => $n->data['message'] ?? '',
                    'type' => $n->data['type'] ?? 'info',
                    'icon' => $n->data['icon'] ?? 'fas fa-bell',
                    'time' => $n->created_at->diffForHumans(),
                    'url' => $n->data['url'] ?? '#'
                ];
            })
        ]);
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}
