<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('category')->latest()->paginate(10);
        $categories = Category::all();

        return view('admin.events.index', compact('events', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'event_date'  => 'required|date',
            'jam'         => 'required',
            'jam_selesai' => 'nullable',
            'description' => 'required',
            'location'    => 'required',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'video'       => 'nullable|mimes:mp4,mov,avi|max:10000',
        ]);

        // ✅ upload gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        // ✅ upload video
        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('events', 'public');
        }

    Event::create([
     'title'       => $request->title,
     'category_id' => $request->category_id,
     'event_date'  => $request->event_date,
     'jam'         => \Carbon\Carbon::parse($request->jam)->format('H:i'),
     'jam_selesai' => $request->jam_selesai ? \Carbon\Carbon::parse($request->jam_selesai)->format('H:i') : null,
     'description' => $request->description,
    'location'    => $request->location,
    'latitude'    => $request->latitude,
    'longitude'   => $request->longitude,
    'image'       => $imagePath,
    'video'       => $videoPath,
]);


        return redirect()->route('events.index')
            ->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function edit(Event $event)
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
{
    $request->validate([
        'title'       => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'event_date'  => 'required|date',
        'jam'         => 'required',
        'jam_selesai' => 'nullable',
        'description' => 'required',
        'location'    => 'required',
        'latitude'    => 'required',   // 🔥 TAMBAHKAN
        'longitude'   => 'required',   // 🔥 TAMBAHKAN
        'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'video'       => 'nullable|mimes:mp4,mov,avi|max:10000',
    ]);

    // upload gambar baru
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('events', 'public');
        $event->image = $imagePath;
    }

    // upload video baru
    if ($request->hasFile('video')) {
        $videoPath = $request->file('video')->store('events', 'public');
        $event->video = $videoPath;
    }

    // 🔥 INI YANG PALING PENTING
    $event->update([
        'title'       => $request->title,
        'category_id' => $request->category_id,
        'event_date'  => $request->event_date,
        'jam'         => \Carbon\Carbon::parse($request->jam)->format('H:i'),
        'jam_selesai' => $request->jam_selesai ? \Carbon\Carbon::parse($request->jam_selesai)->format('H:i') : null,
        'description' => $request->description,
        'location'    => $request->location,
        'latitude'    => $request->latitude,   // 🔥 WAJIB
        'longitude'   => $request->longitude,  // 🔥 WAJIB
    ]);

    return redirect()->route('events.index')
        ->with('success', 'Kegiatan berhasil diperbarui');
}


    public function destroy(Event $event)
    {
        $event->delete();

        return back()->with('success', 'Kegiatan berhasil dihapus');
    }
}
