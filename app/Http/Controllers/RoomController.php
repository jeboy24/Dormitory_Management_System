<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::with('roomType')
            ->withCount('activeAssignments')
            ->when($request->q, fn ($q, $term) => $q->where('room_number', 'like', "%{$term}%"))
            ->when($request->room_type_id, fn ($q, $id) => $q->where('room_type_id', $id))
            ->orderBy('room_number')
            ->paginate(10)
            ->withQueryString();

        return view('rooms.index', [
            'rooms'     => $rooms,
            'roomTypes' => RoomType::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('rooms.create', [
            'room'      => new Room(['status' => 'available']),
            'roomTypes' => RoomType::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Room::create($this->validated($request));

        return redirect()->route('rooms.index')->with('success', 'Room added successfully.');
    }

    public function show(Room $room)
    {
        $room->load(['roomType', 'assignments.student']);

        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', [
            'room'      => $room,
            'roomTypes' => RoomType::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Room $room)
    {
        $data = $this->validated($request, $room);

        $newType   = RoomType::findOrFail($data['room_type_id']);
        $occupants = $room->activeAssignments()->count();
        if ($occupants > $newType->capacity) {
            return back()->withInput()->withErrors([
                'room_type_id' => "This room has $occupants active occupant(s); the selected type only fits {$newType->capacity}.",
            ]);
        }

        $room->update($data);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        if ($room->assignments()->exists()) {
            return back()->with('error', 'Cannot delete this room because it has assignment records.');
        }

        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }

    private function validated(Request $request, ?Room $room = null): array
    {
        return $request->validate([
            'room_type_id' => ['required', 'exists:room_types,id'],
            'room_number'  => ['required', 'string', 'max:20', Rule::unique('rooms', 'room_number')->ignore($room)],
            'floor'        => ['required', 'integer', 'min:1', 'max:50'],
            'status'       => ['required', Rule::in(['available', 'maintenance'])],
        ]);
    }
}