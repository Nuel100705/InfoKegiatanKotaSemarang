<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\PushSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home(\Illuminate\Http\Request $request)
    {
        $categories = Category::all();
        $dateRangeFilter = $request->query('date_range');

        if ($dateRangeFilter) {
            $dates = explode(' to ', $dateRangeFilter);
            $startDate = Carbon::parse($dates[0]);
            $endDate = isset($dates[1]) ? Carbon::parse($dates[1]) : $startDate->copy();

            return view('public.home', [
                'isFiltered' => true,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'filteredEvents' => Event::whereBetween('event_date', [$startDate->toDateString(), $endDate->toDateString()])
                    ->orderBy('event_date')
                    ->orderBy('jam')
                    ->get(),
                'categories' => $categories,
            ]);
        }

        $today = Carbon::today('Asia/Jakarta');
        $tomorrow = Carbon::tomorrow('Asia/Jakarta');

        return view('public.home', [
            'isFiltered' => false,
            'todayEvents' => Event::whereDate('event_date', $today)
                ->orderBy('event_date')
                ->orderBy('jam')
                ->get(),

            'tomorrowEvents' => Event::whereDate('event_date', $tomorrow)
                ->orderBy('event_date')
                ->orderBy('jam')
                ->get(),

            'categories' => $categories,
        ]);
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $categories = Category::all();

        return view('public.category', [
            'category' => $category,
            'events' => Event::where('category_id', $category->id)
                ->latest()
                ->get(),
            'categories' => $categories,
        ]);
    }

  public function show($id)
  {
      $event = Event::with('category')->findOrFail($id);

      return view('public.show', [
          'event' => $event,
          'categories' => Category::all(),
      ]);
  }

  public function checkUpcomingEvents()
  {
      $now = Carbon::now();
      $oneHourLater = $now->copy()->addHour();

      // Cari event yang tanggalnya hari ini dan jamnya antara sekarang dan 1 jam ke depan
      $upcomingEvent = Event::whereDate('event_date', $now->toDateString())
          ->whereTime('jam', '>', $now->toTimeString())
          ->whereTime('jam', '<=', $oneHourLater->toTimeString())
          ->orderBy('jam', 'asc')
          ->first();

      if ($upcomingEvent) {
          return response()->json([
              'success' => true,
              'event' => [
                  'id' => $upcomingEvent->id,
                  'title' => $upcomingEvent->title,
                  'time' => Carbon::parse($upcomingEvent->jam)->format('H:i'),
                  'message' => 'Acara akan segera dimulai!'
              ]
          ]);
      }

      // Alternatif: Cari event yang baru ditambahkan (dalam 30 menit terakhir)
      $newEvent = Event::where('created_at', '>=', $now->copy()->subMinutes(30))
          ->orderBy('created_at', 'desc')
          ->first();

      if ($newEvent) {
          return response()->json([
              'success' => true,
              'event' => [
                  'id' => $newEvent->id,
                  'title' => $newEvent->title,
                  'time' => Carbon::parse($newEvent->event_date)->format('d M') . ' ' . Carbon::parse($newEvent->jam)->format('H:i'),
                  'message' => 'Acara Baru Ditambahkan!'
              ]
          ]);
      }

      return response()->json(['success' => false]);
  }

  public function savePushSubscription(Request $request)
  {
      $request->validate([
          'event_id' => 'required|exists:events,id',
          'endpoint' => 'required|url',
          'keys.p256dh' => 'required|string',
          'keys.auth' => 'required|string',
      ]);

      // Create or update subscription for this endpoint
      PushSubscription::updateOrCreate(
          ['endpoint' => $request->endpoint, 'event_id' => $request->event_id],
          [
              'public_key' => $request->input('keys.p256dh'),
              'auth_token' => $request->input('keys.auth'),
          ]
      );

      return response()->json(['success' => true]);
  }

}
