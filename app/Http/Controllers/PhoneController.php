<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Models\Service;
use Doctrine\DBAL\Abstraction\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhoneController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session()->forget('search');
        $phones = Phone::all();

        $phones = Phone::sortable()->latest('updated_at')->paginate(10);
        return view('phone.index', compact('phones'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\phone $phone
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Phone $phone)
    {
        return view('phone.show', compact('phone'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\phone $phone
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Phone $phone)
    {
        return view('phone.edit', compact('phone'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\phone $phone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Phone $phone)
    {

        $request->validate([
            'number' => ['regex:/(60|62|63|64)/','required','digits:7','unique:phones,number'],
        ]);
        $phone->update($request->all());

        return redirect()->route('phone.index')
            ->with('success', 'Phone Table updated successfully');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('phone.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'number'         =>      ['regex:/(60|62|63|64)/','required','digits:7','unique:phones,number'],
        ]);

        $phone = Phone::create($request->all());

       return redirect()->route('phone.index')
            ->with('success', 'Phone Number created successfully.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\phone $phone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Phone $phone)
    {
        $phone->delete();

        return redirect()->route('phone.index')
        ->with('success', $phone->number.' deleted successfully');
    }

    public function searchPhone(Request $request) {

        $request->validate([

            'search' => 'required|digits:7'
        ]);

        $search = $request->input('search');

        $phones = Phone::sortable()->
            where('number','like', '%'.$search.'%')
            ->orderBy('updated_at', 'desc');

        $count = $phones->count();

        $phones = $phones->paginate(10);

       return view('phone.index', compact('phones'))
            ->with('search', session(['search' => $count]));
    }

    public function listPhoneService() {
        // $phones = DB::table('phones')
        // ->join('phone_service', 'phones.id', '=', 'phone_service.phone_id')
        // ->join('services', 'services.id', '=', 'phone_service.service_id')
        // ->select('phones.number', 'services.name', 'phone_service.updated_at')
        // ->simplePaginate(3);

        // $phones = Phone::sortable()->join('phone_service', 'phones.id', '=', 'phone_service.phone_id')
        // ->join('services', 'phone_service.service_id', '=', 'services.id')->paginate(5);
        // ->get(['phones.number', 'services.name', 'phone_service.updated_at']);

        $phones = Phone::with('services')->simplePaginate(4);
    //    return $phones;

    //     // dd($phones);

    //     foreach($phones as $service) {
    //         echo "<br />";
    //         return $service;
    //         echo "<br />";
    //     }

        //  dd($phones);

        return view('phone_service.index', compact('phones'));

        // foreach($phone as $key => $value) {
        //     echo $value->number." ".$value->name;
        //     echo "\n";
        // }
    }

    public function destroyPhoneService($number,$service)
    {
        $phone = Phone::findOrFail($number);

        $phone->services()->detach($service);

        return redirect()->route('phone_service.index')
        ->with('success', 'Phone Number detached successfully.');
    }
}
