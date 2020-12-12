<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        session()->forget('search');
        $services = Service::all();

        $services = Service::sortable()->latest('updated_at')->paginate(10);
        return view('service.index', compact('services'));

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

        $request->validate([
            'code' => 'required|unique:services,code',
            'name' => 'required',
            'description' => 'required',
        ]);

        $service->update($request->all());

        return redirect()->route('service.index')
            ->with('success', 'Service Table updated successfully');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'code' => 'required|unique:services,code',
            'name' => 'required',
            'description' => 'required',
        ]);

        Service::create($request->all());

       return redirect()->route('service.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\service $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Service $service)
    {
        $service->delete();

        return redirect()->route('service.index')
            ->with('success', $service->name.' deleted successfully');
    }

    /**
     * @param Request $request
     * @return View|Factory
     * @throws BindingResolutionException
     */
    public function searchService(Request $request) {

        $request->validate([

            'search' => 'required'
        ]);

        $search = $request->input('search');

        $services = Service::sortable()
            ->where('number','like', '%'.$search.'%')
            ->orderBy('updated_at', 'desc');

        $count = $services->count();

        $services = $services->paginate(10);

       return view('service.index', compact('services'))
            ->with('search', session(['search' => $count]));
    }
}
