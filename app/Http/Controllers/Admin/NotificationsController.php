<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function feed(Request $request)
    {
        $items = Activity::with([
            'project:id,name',
            'actor.employee:id,name,avatar_path'
        ])->latest()->limit(20)->get();

        $data = $items->map(function ($a) {
            $actor = optional(optional($a->actor)->employee)->name ?? optional($a->actor)->name ?? 'Someone';
            return [
                'id'        => (int) $a->id,
                'type'      => (string) $a->type,
                'message'   => (string) ($a->message ?? ''),
                'project'   => [ 'id' => (int) $a->project_id, 'name' => optional($a->project)->name ],
                'actor'     => [ 'name' => $actor ],
                'created_at'=> optional($a->created_at)->toIso8601String(),
            ];
        });

        return response()->json(['data' => $data]);
    }
}

