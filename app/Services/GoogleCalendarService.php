<?php

namespace App\Services;

use Google\Client as GoogleClient;
use Google\Service\Calendar as GoogleCalendar;
use Google\Service\Calendar\Event as GoogleCalendarEvent;

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

            // Update token jika berhasil diperbarui
            if (isset($newToken['access_token'])) {
                $user->google_access_token = $newToken['access_token'];
                $user->google_token_expires = now()->addSeconds($newToken['expires_in'] ?? 3600);
                $user->save();

                $this->client->setAccessToken($newToken);
            }
        }
    }

    public function createEvent($title, $description, $startDateTime, $endDateTime)
    {
        $calendarService = new GoogleCalendar($this->client);

        $event = new GoogleCalendarEvent([
            'summary'     => $title,
            'description' => $description,
            'start'       => [
                'dateTime' => $startDateTime,
                'timeZone' => 'Asia/Jakarta',
            ],
            'end'         => [
                'dateTime' => $endDateTime,
                'timeZone' => 'Asia/Jakarta',
            ],
        ]);

        return $calendarService->events->insert('primary', $event);
    }
}
