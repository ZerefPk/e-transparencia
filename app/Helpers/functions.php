<?php
function flashNotification($message,$title = false)
{
    $message = [
        'title' => $title,
        'message' => $message,
    ];
    session()->flash('notificationflashModal', $message);
}
