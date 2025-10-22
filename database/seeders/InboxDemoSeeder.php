<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InboxDemoSeeder extends Seeder
{
//     public function run(): void
//     {
//         $now = Carbon::now();

//         // Grab a handful of real users to build DMs & a group
//         $users = DB::table('users')
//             ->select('id')
//             ->orderBy('id')
//             ->limit(6)
//             ->get()
//             ->pluck('id')
//             ->all();

//         if (count($users) < 3) {
//             $this->command->warn('Need at least 3 users in users table to seed inbox demo.');
//             return;
//         }

//         // Helper for stable dm_key: "min|max"
//         $dmKey = function (int $a, int $b) {
//             $min = min($a, $b);
//             $max = max($a, $b);
//             return "{$min}|{$max}";
//         };

//         // ---------- 1) Direct conversation (users[0] ↔ users[1]) ----------
//         $uA = $users[0];
//         $uB = $users[1];

//         // Create DM conversation
//         $dm1Id = DB::table('conversations')->insertGetId([
//             'type'             => 'direct',
//             'title'            => null,
//             'avatar_url'       => null,
//             'created_by'       => $uA,
//             'dm_key'           => $dmKey($uA, $uB),
//             'last_message_id'  => null,
//             'last_message_at'  => null,
//             'created_at'       => $now,
//             'updated_at'       => $now,
//         ]);

//         // Participants
//         DB::table('conversation_participants')->insert([
//             [
//                 'conversation_id' => $dm1Id,
//                 'user_id'         => $uA,
//                 'role'            => 'member',
//                 'last_read_at'    => $now->copy()->subMinutes(5),
//                 'created_at'      => $now,
//                 'updated_at'      => $now,
//             ],
//             [
//                 'conversation_id' => $dm1Id,
//                 'user_id'         => $uB,
//                 'role'            => 'member',
//                 'last_read_at'    => $now->copy()->subMinutes(30),
//                 'created_at'      => $now,
//                 'updated_at'      => $now,
//             ],
//         ]);

//         // Messages in DM1
//         $m1a = DB::table('messages')->insertGetId([
//             'conversation_id' => $dm1Id,
//             'sender_id'       => $uA,
//             'type'            => 'text',
//             'body'            => 'Hey, did you get the latest cabinet drawings?',
//             'metadata'        => null,
//             'reply_to_message_id' => null,
//             'created_at'      => $now->copy()->subMinutes(28),
//             'updated_at'      => $now->copy()->subMinutes(28),
//         ]);
//         $m1b = DB::table('messages')->insertGetId([
//             'conversation_id' => $dm1Id,
//             'sender_id'       => $uB,
//             'type'            => 'text',
//             'body'            => 'Yes—reviewed. Pushing updates after lunch.',
//             'metadata'        => null,
//             'reply_to_message_id' => $m1a,
//             'created_at'      => $now->copy()->subMinutes(12),
//             'updated_at'      => $now->copy()->subMinutes(12),
//         ]);

//         // Receipts for DM1 (✓✓ when read)
//         DB::table('message_receipts')->insert([
//             // m1a seen by B
//             [
//                 'message_id' => $m1a,
//                 'user_id'    => $uB,
//                 'status'     => 'read',
//                 'read_at'    => $now->copy()->subMinutes(20),
//                 'created_at' => $now,
//                 'updated_at' => $now,
//             ],
//             // m1b delivered to A but not yet read (so A will see ✓ only)
//             [
//                 'message_id' => $m1b,
//                 'user_id'    => $uA,
//                 'status'     => 'delivered',
//                 'read_at'    => null,
//                 'created_at' => $now,
//                 'updated_at' => $now,
//             ],
//         ]);

//         // Update conversation cache fields
//         DB::table('conversations')->where('id', $dm1Id)->update([
//             'last_message_id' => $m1b,
//             'last_message_at' => $now->copy()->subMinutes(12),
//             'updated_at'      => $now,
//         ]);

//         // ---------- 2) Second DM (users[0] ↔ users[2]) ----------
//         $uC = $users[2];

//         $dm2Id = DB::table('conversations')->insertGetId([
//             'type'             => 'direct',
//             'title'            => null,
//             'avatar_url'       => null,
//             'created_by'       => $uC,
//             'dm_key'           => $dmKey($uA, $uC),
//             'last_message_id'  => null,
//             'last_message_at'  => null,
//             'created_at'       => $now,
//             'updated_at'       => $now,
//         ]);

//         DB::table('conversation_participants')->insert([
//             [
//                 'conversation_id' => $dm2Id,
//                 'user_id'         => $uA,
//                 'role'            => 'member',
//                 'last_read_at'    => $now->copy()->subHours(2),
//                 'created_at'      => $now,
//                 'updated_at'      => $now,
//             ],
//             [
//                 'conversation_id' => $dm2Id,
//                 'user_id'         => $uC,
//                 'role'            => 'member',
//                 'last_read_at'    => $now->copy()->subHours(3),
//                 'created_at'      => $now,
//                 'updated_at'      => $now,
//             ],
//         ]);

//         $m2a = DB::table('messages')->insertGetId([
//             'conversation_id' => $dm2Id,
//             'sender_id'       => $uC,
//             'type'            => 'text',
//             'body'            => 'Reminder: installation scheduled for Friday 10:00.',
//             'metadata'        => null,
//             'reply_to_message_id' => null,
//             'created_at'      => $now->copy()->subHours(1)->subMinutes(10),
//             'updated_at'      => $now->copy()->subHours(1)->subMinutes(10),
//         ]);

//         DB::table('message_receipts')->insert([
//             [
//                 'message_id' => $m2a,
//                 'user_id'    => $uA,
//                 'status'     => 'delivered',
//                 'read_at'    => null,
//                 'created_at' => $now,
//                 'updated_at' => $now,
//             ],
//         ]);

//         DB::table('conversations')->where('id', $dm2Id)->update([
//             'last_message_id' => $m2a,
//             'last_message_at' => $now->copy()->subHours(1)->subMinutes(10),
//             'updated_at'      => $now,
//         ]);

//         // ---------- 3) Group (up to 6 members here, cap is 10) ----------
//         $groupMembers = array_slice($users, 0, min(6, count($users)));
//         $ownerId = $groupMembers[0];

//         $groupId = DB::table('conversations')->insertGetId([
//             'type'             => 'group',
//             'title'            => 'Design & Installation Squad',
//             'avatar_url'       => null, // can autogenerate later
//             'created_by'       => $ownerId,
//             'dm_key'           => null,
//             'last_message_id'  => null,
//             'last_message_at'  => null,
//             'created_at'       => $now,
//             'updated_at'       => $now,
//         ]);

//         $participantRows = [];
//         foreach ($groupMembers as $idx => $uid) {
//             $participantRows[] = [
//                 'conversation_id' => $groupId,
//                 'user_id'         => $uid,
//                 'role'            => $idx === 0 ? 'owner' : 'member',
//                 'last_read_at'    => $idx <= 2 ? $now->copy()->subMinutes(3) : $now->copy()->subHours(4),
//                 'created_at'      => $now,
//                 'updated_at'      => $now,
//             ];
//         }
//         DB::table('conversation_participants')->insert($participantRows);

//         $g1 = DB::table('messages')->insertGetId([
//             'conversation_id' => $groupId,
//             'sender_id'       => $ownerId,
//             'type'            => 'system',
//             'body'            => 'Group created.',
//             'metadata'        => null,
//             'reply_to_message_id' => null,
//             'created_at'      => $now->copy()->subHours(5),
//             'updated_at'      => $now->copy()->subHours(5),
//         ]);

//         $g2 = DB::table('messages')->insertGetId([
//             'conversation_id' => $groupId,
//             'sender_id'       => $ownerId,
//             'type'            => 'text',
//             'body'            => 'Please drop final renders before 4 PM.',
//             'metadata'        => null,
//             'reply_to_message_id' => $g1,
//             'created_at'      => $now->copy()->subMinutes(25),
//             'updated_at'      => $now->copy()->subMinutes(25),
//         ]);

//         // Receipts for group (track read, show compact ✓✓ later)
//         $receiptRows = [];
//         foreach ($groupMembers as $uid) {
//             if ($uid === $ownerId) continue; // sender doesn’t need a receipt
//             $receiptRows[] = [
//                 'message_id' => $g2,
//                 'user_id'    => $uid,
//                 'status'     => in_array($uid, array_slice($groupMembers, 0, 3)) ? 'read' : 'delivered',
//                 'read_at'    => in_array($uid, array_slice($groupMembers, 0, 3)) ? $now->copy()->subMinutes(10) : null,
//                 'created_at' => $now,
//                 'updated_at' => $now,
//             ];
//         }
//         DB::table('message_receipts')->insert($receiptRows);

//         DB::table('conversations')->where('id', $groupId)->update([
//             'last_message_id' => $g2,
//             'last_message_at' => $now->copy()->subMinutes(25),
//             'updated_at'      => $now,
//         ]);

//         $this->command->info('Inbox demo seeded: 2 DMs + 1 Group with messages and receipts.');
//     }



public function run(): void
{
    $this->command->info('InboxDemoSeeder running ✅');
}


}
