<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/** @mixin \App\Models\Comment */
class CommentResource extends JsonResource
{
    public function toArray($request): array
    {
        $user = $this->user;
        $employee = optional($user)->employee;

        $avatar = null;
        if ($employee && $employee->avatar_path) {
            $avatar = Str::startsWith($employee->avatar_path, ['http://','https://'])
                ? $employee->avatar_path
                : Storage::url($employee->avatar_path);
        }

        return [
            'id'         => $this->id,
            'body'       => (string) $this->comment,
            'created_at' => optional($this->created_at)?->toIso8601String(),
            'author'     => [
                'id'         => optional($user)->id,
                'name'       => $employee->name ?? ($user->name ?? 'User'),
                'avatar_url' => $avatar,
                'role'       => $user->role ?? null,
            ],
        ];
    }
}
