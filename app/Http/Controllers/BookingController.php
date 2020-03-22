<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Booking::withTrashed()->get()->dd();
        $bookings = Booking::with(['room.roomType', 'users:name'])->paginate(2);
        return view('bookings.index', compact('bookings'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = DB::table('users')->get()->pluck('name', 'id')->prepend('None', '0');
        $rooms = Room::get()->pluck('number', 'id')->prepend('None');
        $booking = new Booking;

        return view('bookings.create', compact(['users', 'rooms', 'booking']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->ajax());
        $booking = Booking::create($request->input());
        $booking->users()->attach($request->input('user_id'));

        return response()->json([
            'status' => 'success',
            'title' => 'Success',
            'message' => 'Data successfully added.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        $room = DB::table('rooms')->where('id', $booking->room_id)->first();
        return view('bookings.show', compact(['booking', 'room']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        $users = DB::table('users')->get()->pluck('name', 'id')->prepend('None', '0');
        $rooms = DB::table('rooms')->get()->pluck('number', 'id')->prepend('None');
        $bookingUser = DB::table('bookings_users')->where('booking_id', $booking->id)->first();

        return view('bookings.edit', compact(['users', 'rooms', 'bookingUser', 'booking']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        (\App\Jobs\ProcessBookingJob::dispatch($booking));
        // Validation
        $validator = \Validator::make($request->all(), [
            'start' => 'required|date',
            'end' => 'required|date',
            // exists:rooms,id if it matches the id field in rooms table
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
            'is_paid' => 'nullable',
            'notes' => 'present',
            'is_reservation' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'title' => 'Error',
                'message' => $validator->errors()->first()
            ]);
        }

        $booking->fill($request->input());
        $booking->save();
        
        $booking->users()->sync([$request->input('user_id')]);

        return response()->json([
            'status' => 'success',
            'title' => 'Success',
            'message' => 'Data successfully updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->users()->detach();
        $booking->delete();
        return response()->json([
            'status' => 'success',
            'title' => 'Success',
            'message' => 'Data successfully deleted.'
        ]);
    }
}
