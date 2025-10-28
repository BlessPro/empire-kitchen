<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserSearchController extends Controller
{
    // GET /users/search?q=&limit=
    public function index_old(Request $request)
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
            'data' => $rows->map(function ($r) {
                return [
                    'id'          => (int) $r->user_id,
                    'name'        => $r->name ?? 'Unknown',
                    'designation' => $r->designation ?? '',
                    'avatar'      => $this->formatAvatar($r->avatar_path),
                    'email'       => $r->email,
                ];
            }),
        ]);
    }

    protected function formatAvatar(?string $path): string
    {
        if (empty($path)) {
            return asset('images/default-avatar.png');
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        $normalized = ltrim($path, '/');

        foreach (['public/', 'storage/'] as $prefix) {
            if (Str::startsWith($normalized, $prefix)) {
                $normalized = substr($normalized, strlen($prefix));
                break;
            }
        }

        if (!Storage::disk('public')->exists($normalized)) {
            return asset('images/default-avatar.png');
        }

        return Storage::disk('public')->url($normalized);
    }


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
            'data' => $rows->map(function ($r) {
                return [
                    'id'          => (int) $r->user_id,
                    'name'        => $r->name ?? 'Unknown',
                    'designation' => $r->designation ?? '',
                    'avatar'      => $this->formatAvatar($r->avatar_path),
                    'email'       => $r->email,
                ];
            }),
        ]);
    }








}
