<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Models\Parents;
use App\Notifications\NotificationEmail;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    public function index()
    {
        return NotificationResource::collection(Notification::all());
    }

    public function store(StoreNotificationRequest $request)
    {
        $notification = Notification::create($request->validated());

        // إرسال الإشعار بالبريد الإلكتروني
        $parent = Parents::find($notification->parent_id);
        $user = $parent->user; // يفترض أن Parents ترتبط بـ User
        $user->notify(new NotificationEmail($notification));

        return new NotificationResource($notification);
    }

    public function show(Notification $notification)
    {
        return new NotificationResource($notification);
    }

    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        $notification->update($request->validated());
        return new NotificationResource($notification);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
