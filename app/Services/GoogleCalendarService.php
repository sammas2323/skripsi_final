<?php

namespace App\Services;

use Google\Client as GoogleClient;
use Google\Service\Calendar as GoogleCalendar;
use Google\Service\Calendar\Event as GoogleCalendarEvent;
use Carbon\Carbon;

class GoogleCalendarService
{
    protected $client;

    public function __construct($user)
    {
        $this->client = new GoogleClient();
        $this->client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
        $this->client->addScope(GoogleCalendar::CALENDAR);
        $this->client->setAccessType('offline');

        $this->client->setAccessToken([
            'access_token' => $user->google_access_token,
            'refresh_token' => $user->google_refresh_token,
            'expires_in' => now()->diffInSeconds($user->google_token_expires, false),
            'created' => now()->subSeconds(30)->timestamp // agar aman untuk refresh
        ]);

        // Jika token sudah kadaluarsa, refresh
        if ($this->client->isAccessTokenExpired()) {
            $newToken = $this->client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);

            if (isset($newToken['access_token'])) {
                $user->google_access_token = $newToken['access_token'];
                $user->google_token_expires = now()->addSeconds($newToken['expires_in'] ?? 3600);
                $user->save();

                $this->client->setAccessToken($newToken);
            }
        }
    }

    /**
     * Membuat event utama dan reminder H-5 s/d H-1 sebelum berakhir
     */
    public function createEvent($title, $description, $startDateTime, $endDateTime)
    {
        $calendarService = new GoogleCalendar($this->client);

        $start = new Carbon($startDateTime);
        $end = new Carbon($endDateTime);

        $event = new GoogleCalendarEvent([
            'summary'     => $title,
            'description' => $description,
            'start'       => [
                'dateTime' => $start->toRfc3339String(),
                'timeZone' => 'Asia/Jakarta',
            ],
            'end'         => [
                'dateTime' => $end->toRfc3339String(),
                'timeZone' => 'Asia/Jakarta',
            ],
            'reminders' => [
                'useDefault' => true, // Reminder default (biasanya 10 menit sebelum)
            ]
        ]);

        // Simpan event utama
        $createdEvent = $calendarService->events->insert('primary', $event);

        // Buat 5 reminder sebelum event berakhir
        $this->createReminderBeforeEnd(
            $title,
            'Kontrak sewa akan segera berakhir.',
            $endDateTime
        );

        return $createdEvent;
    }

    /**
     * Membuat 5 event reminder H-5 s/d H-1 sebelum masa sewa berakhir
     */
    public function createReminderBeforeEnd($title, $description, $endDateTime)
    {
        $calendarService = new GoogleCalendar($this->client);
        $end = Carbon::parse($endDateTime);
        $createdReminders = [];

        // Buat reminder H-5 sampai H-1
        for ($i = 5; $i >= 1; $i--) {
            $reminderDate = $end->copy()->subDays($i)->setTime(9, 0, 0); // jam 09:00

            $event = new GoogleCalendarEvent([
                'summary'     => "[Reminder H-$i] $title",
                'description' => $description . " — Tersisa $i hari sebelum kontrak berakhir.",
                'start'       => [
                    'dateTime' => $reminderDate->toRfc3339String(),
                    'timeZone' => 'Asia/Jakarta',
                ],
                'end'         => [
                    'dateTime' => $reminderDate->copy()->addMinutes(5)->toRfc3339String(),
                    'timeZone' => 'Asia/Jakarta',
                ],
                'reminders' => [
                    'useDefault' => false,
                    'overrides' => [
                        ['method' => 'popup', 'minutes' => 10], // popup 10 menit sebelumnya
                    ],
                ]
            ]);

            $created = $calendarService->events->insert('primary', $event);
            $createdReminders[] = $created;
        }

        return $createdReminders;
    }
}
