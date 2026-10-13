<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::withCount('rooms')->orderBy('name')->paginate(10);

        return view('room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('room-types.create', ['roomType' => new RoomType()]);
    }

    public function store(Request $request)
    {
        RoomType::create($this->validated($request));

        return redirect()->route('room-types.index')->with('success', 'Room type added successfully.');
    }

    public function edit(RoomType $roomType)
    {
        return view('room-types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $data = $this->validated($request, $roomType);

        $maxOccupants = $roomType->rooms()->withCount('activeAssignments')->get()->max('active_assignments_count') ?? 0;
        if ($data['capacity'] < $maxOccupants) {
            return back()->withInput()->withErrors([
                'capacity' => "Capacity cannot be lower than current occupants ($maxOccupants) in a room of this type.",
            ]);
        }

        $roomType->update($data);

        return redirect()->route('room-types.index')->with('success', 'Room type updated successfully.');
    }

    public function destroy(RoomType $roomType)
    {
        if ($roomType->rooms()->exists()) {
            return back()->with('error', 'Cannot delete this room type because rooms are using it.');
        }

        $roomType->delete();

        return redirect()->route('room-types.index')->with('success', 'Room type deleted successfully.');
    }

    private function validated(Request $request, ?RoomType $roomType = null): array
    {
        return $request->validate([
            'name'         => ['required', 'string', 'max:100', Rule::unique('room_types', 'name')->ignore($roomType)],
            'description'  => ['nullable', 'string', 'max:500'],
            'monthly_rate' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'capacity'     => ['required', 'integer', 'min:1', 'max:20'],
        ]);
    }
}