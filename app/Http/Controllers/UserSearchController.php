<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSearchController extends Controller
{
    // GET /users/search?q=&limit=
    public function index(Request $request)
    {
        $q     = trim((string) $request->query('q', ''));
        $limit = min(max((int) $request->query('limit', 20), 1), 50);

        $rows = DB::table('users as u')
            ->leftJoin('employees as e', 'e.id', '=', 'u.employee_id')
            ->select('u.id as user_id', 'e.name', 'e.designation', 'e.avatar_path', 'e.email')
            ->when($q !== '', function ($w) use ($q) {
                $w->where(function ($w2) use ($q) {
                    $w2->where('e.name', 'like', "%{$q}%")
                      ->orWhere('e.designation', 'like', "%{$q}%")
                      ->orWhere('e.email', 'like', "%{$q}%");
                });
            })
            ->orderBy('e.name')
            ->limit($limit)
            ->get();

        return response()->json([
            'data' => $rows->map(fn($r) => [
                'id'          => (int) $r->user_id,
                'name'        => $r->name ?? 'Unknown',
                'designation' => $r->designation ?? '',
                'avatar'      => $r->avatar_path,
                'email'       => $r->email,
            ]),
        ]);
    }
}
