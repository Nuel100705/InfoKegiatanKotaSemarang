<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventReminder;
use Illuminate\Http\Request;

class EventReminderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id'       => 'required|exists:events,id',
            'email'          => 'required|email',
            'minutes_before' => 'required|integer|min:1',
        ]);

        $event = Event::findOrFail($request->event_id);

        $eventDateTime = \Carbon\Carbon::parse($event->event_date . ' ' . ($event->jam ?? '00:00:00'));
        $notifyAt = $eventDateTime->copy()->subMinutes($request->minutes_before);

        if ($notifyAt->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Waktu pengingat sudah lewat. Pilih waktu lebih awal.'
            ], 422);
        }

        EventReminder::updateOrCreate(
            ['event_id' => $event->id, 'email' => $request->email],
            [
                'minutes_before' => $request->minutes_before,
                'notify_at'      => $notifyAt,
                'sent'           => false,
                'sent_at'        => null,
            ]
        );

        // [TAMBAHAN] Kirim email konfirmasi saat itu juga sebagai bukti realtime
        try {
            \Illuminate\Support\Facades\Mail::to($request->email)->send(
                new \App\Mail\EventReminderMail($event, "Pengingat Berhasil Disetel. Kami akan mengingatkanmu kembali pada " . $notifyAt->format('d M Y H:i'))
            );
        } catch (\Exception $e) {
            // Abaikan error pada dev/local, tapi bisa log error bila perlu
            \Illuminate\Support\Facades\Log::error('Gagal kirim email di EventReminderController: ' . $e->getMessage());
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Pengingat Email berhasil diaktifkan!',
            'notify_at' => $notifyAt->toIso8601String(),
            'email'     => $request->email,
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'email'    => 'required|email',
        ]);

        EventReminder::where('event_id', $request->event_id)
            ->where('email', $request->email)
            ->delete();

        return response()->json(['success' => true]);
    }
}
