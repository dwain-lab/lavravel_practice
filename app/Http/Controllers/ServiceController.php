<?php

namespace App\Http\Controllers;

use App\Service;
use App\service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = Service::all();

        return view('service.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\service $service
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Service $service)
    {
        return view('service.show', compact('service'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\service $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Service $service)
    {
        return view('service.edit', compact('service'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('service.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\service $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $service->save();

        return redirect()->route('service.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = Service::create($request->all());

        $request->session()->flash('service.id', $service->id);

        return redirect()->route('service.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\service $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Service $service)
    {
        $service->delete();

        return redirect()->route('service.index');
    }
}
