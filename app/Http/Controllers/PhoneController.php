<?php

namespace App\Http\Controllers;

use App\Phone;
use App\phone;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $phones = Phone::all();

        return view('phone.index');
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
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('phone.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\phone $phone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Phone $phone)
    {
        $phone->save();

        return redirect()->route('phone.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $phone = Phone::create($request->all());

        $request->session()->flash('phone.id', $phone->id);

        return redirect()->route('phone.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\phone $phone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Phone $phone)
    {
        $phone->delete();

        return redirect()->route('phone.index');
    }
}
