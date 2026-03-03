<?php

namespace App\Console\Commands;

use App\Models\EventReminder;
use App\Models\PushSubscription;
use App\Services\WebPushService;
use App\Mail\EventReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Exception;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim pengingat Email untuk kegiatan yang sudah waktunya';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reminders = EventReminder::with('event')
            ->where('sent', false)
            ->where('notify_at', '<=', now())
            ->get();

        if ($reminders->isEmpty()) {
            $this->info('Tidak ada pengingat Email yang perlu dikirim.');
        } else {


            foreach ($reminders as $reminder) {
                $event = $reminder->event;
                $label = $this->buildLabel($reminder->minutes_before);

                try {
                    Mail::to($reminder->email)->send(new EventReminderMail($event, $label));
                    
                    $reminder->update(['sent' => true, 'sent_at' => now()]);
                    $this->info("✅ Email terkirim ke {$reminder->email} untuk acara: {$event->title}");
                } catch (Exception $e) {
                    $this->error("❌ Gagal kirim email ke {$reminder->email}. Error: " . $e->getMessage());
                }
            }
        }

        // Web Push Notifications
        $this->info('Mengecek Push Notifications...');
        $pushSubscriptions = PushSubscription::with('event')
            ->whereHas('event', function ($query) {
                // Notifikasi push biasa dikirim dalam jarak 1 jam. Anda dapat menyesuaikan logic.
                $query->where('event_date', '<=', now()->toDateString())
                      ->where('jam', '>', now()->toTimeString())
                      ->where('jam', '<=', now()->addHour()->toTimeString());
            })->get();

        if ($pushSubscriptions->isEmpty()) {
            $this->info('Tidak ada push notification yang perlu dikirim (atau fitur ini diproses realtime di browser).');
        } else {
            $webPushService = new WebPushService();
            foreach ($pushSubscriptions as $sub) {
                try {
                    $payload = [
                        'title' => 'Pengingat Browser Actif!',
                        'body' => $sub->event->title . ' akan segera dimulai dalam waktu dekat.',
                        'url' => '/kegiatan/' . $sub->event->id
                    ];
                    $res = $webPushService->sendNotification($sub, $payload);
                    if ($res->isSuccess()) {
                        $this->info("✅ Push Notif terkirim ke endpoint: " . substr($sub->endpoint, 0, 30) . "...");
                        // Optionally delete or mark sent, but typically endpoints can receive multiple if it's generic
                    } else {
                        $this->error("❌ Gagal kirim push: " . $res->getReason());
                        if ($res->isSubscriptionExpired()) {
                            $sub->delete(); // Remove expired
                        }
                    }
                } catch (\Exception $e) {
                    $this->error("❌ Gagal kirim push: " . $e->getMessage());
                }
            }
        }

        $this->info("Selesai. {$reminders->count()} pengingat diproses.");
    }

    private function buildLabel(int $minutes): string
    {
        if ($minutes < 60)   return "{$minutes} menit";
        if ($minutes < 1440) return (intdiv($minutes, 60)) . " jam";
        return (intdiv($minutes, 1440)) . " hari";
    }
}
