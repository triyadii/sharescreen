<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\ScreenRoom;
use App\Models\RoomSignal;

class ScreenShareController extends Controller
{
    // Membuat room session baru
    public function createRoom(Request $request)
    {
        // Bersihkan room lama (lebih dari 2 jam) agar database tidak bengkak
        ScreenRoom::where('created_at', '<', now()->subHours(2))->update(['status' => 'inactive']);
        RoomSignal::where('created_at', '<', now()->subHours(2))->delete();

        // Buat kode unik 6 karakter
        do {
            $code = Str::upper(Str::random(6));
        } while (ScreenRoom::where('code', $code)->exists());

        $host_id = 'host_' . Str::random(10);

        $room = ScreenRoom::create([
            'code' => $code,
            'host_id' => $host_id,
            'status' => 'active',
            'mode' => 'webrtc'
        ]);

        return response()->json([
            'success' => true,
            'code' => $code,
            'host_id' => $host_id
        ]);
    }

    // Bergabung ke room yang sudah ada
    public function joinRoom(Request $request, $code)
    {
        $room = ScreenRoom::where('code', strtoupper($code))
            ->where('status', 'active')
            ->first();

        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Room tidak ditemukan atau sudah tidak aktif.'
            ], 404);
        }

        $viewer_id = 'viewer_' . Str::random(10);

        return response()->json([
            'success' => true,
            'code' => $room->code,
            'viewer_id' => $viewer_id,
            'mode' => $room->mode
        ]);
    }

    // Mendapatkan status room terkini
    public function getRoomStatus($code)
    {
        $room = ScreenRoom::where('code', strtoupper($code))->first();

        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Room tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'code' => $room->code,
            'status' => $room->status,
            'mode' => $room->mode
        ]);
    }

    // Mengubah mode room (webrtc <-> frame)
    public function changeMode(Request $request, $code)
    {
        $room = ScreenRoom::where('code', strtoupper($code))->first();
        if (!$room) {
            return response()->json(['success' => false, 'message' => 'Room tidak ditemukan.'], 404);
        }

        $request->validate([
            'mode' => 'required|in:webrtc,frame'
        ]);

        $room->update([
            'mode' => $request->mode
        ]);

        return response()->json([
            'success' => true,
            'mode' => $room->mode
        ]);
    }

    // Mengirim sinyal WebRTC (offer, answer, candidate)
    public function sendSignal(Request $request, $code)
    {
        $request->validate([
            'sender_id' => 'required|string',
            'recipient_id' => 'nullable|string',
            'type' => 'required|string',
            'payload' => 'required|string'
        ]);

        $signal = RoomSignal::create([
            'room_code' => strtoupper($code),
            'sender_id' => $request->sender_id,
            'recipient_id' => $request->recipient_id,
            'type' => $request->type,
            'payload' => $request->payload
        ]);

        return response()->json([
            'success' => true,
            'signal_id' => $signal->id
        ]);
    }

    // Mengambil sinyal WebRTC baru
    public function getSignals(Request $request, $code)
    {
        $request->validate([
            'recipient_id' => 'required|string',
            'last_signal_id' => 'nullable|integer'
        ]);

        $lastSignalId = $request->input('last_signal_id', 0);
        $recipientId = $request->recipient_id;

        $signals = RoomSignal::where('room_code', strtoupper($code))
            ->where('id', '>', $lastSignalId)
            ->where(function($query) use ($recipientId) {
                $query->where('recipient_id', $recipientId)
                      ->orWhereNull('recipient_id');
            })
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'signals' => $signals
        ]);
    }

    // Mengunggah frame gambar (Mode Fallback / HTTP Frame)
    public function uploadFrame(Request $request, $code)
    {
        $request->validate([
            'frame' => 'required|image|mimes:jpeg,jpg|max:2048'
        ]);

        if ($request->hasFile('frame')) {
            $file = $request->file('frame');
            
            $dir = storage_path('app/public/rooms');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }

            $file->move($dir, strtoupper($code) . '.jpg');

            return response()->json([
                'success' => true,
                'path' => asset('storage/rooms/' . strtoupper($code) . '.jpg')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tidak ada file yang diunggah.'
        ], 400);
    }

    // Menampilkan halaman Dashboard Host
    public function showHostPage($code)
    {
        $room = ScreenRoom::where('code', strtoupper($code))->first();
        if (!$room) {
            return redirect('/')->with('error', 'Room tidak ditemukan.');
        }

        $iceServers = json_decode(env('WEBRTC_ICE_SERVERS', '[{"urls":"stun:stun.l.google.com:19302"},{"urls":"stun:stun1.l.google.com:19302"}]'), true);

        return view('host', [
            'code' => strtoupper($code),
            'room' => $room,
            'iceServers' => $iceServers
        ]);
    }

    // Menampilkan halaman Viewer
    public function showViewerPage($code)
    {
        $room = ScreenRoom::where('code', strtoupper($code))->first();
        if (!$room) {
            return redirect('/')->with('error', 'Room tidak ditemukan.');
        }

        $iceServers = json_decode(env('WEBRTC_ICE_SERVERS', '[{"urls":"stun:stun.l.google.com:19302"},{"urls":"stun:stun1.l.google.com:19302"}]'), true);

        return view('viewer', [
            'code' => strtoupper($code),
            'room' => $room,
            'iceServers' => $iceServers
        ]);
    }
}
