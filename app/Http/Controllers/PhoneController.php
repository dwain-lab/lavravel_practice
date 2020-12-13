<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

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

        $phones = Phone::sortable()->with('services')->latest('updated_at')->Paginate(5);


        return view('phone_service.index', compact('phones'));
    }

    public function destroyPhoneService($number,$service)
    {
        $phone = Phone::findOrFail($number);

        if($phone) {
            $phone->updated_at = now();
            $phone->save();
        }

        $phone->services()->detach($service);

        return redirect()->route('phone_service.index')
        ->with('success', 'Phone Number detached successfully.');
    }

    /**
     * @param Request $request
     * @return View|Factory
     * @throws BindingResolutionException
     */
    public function createPhoneService(Request $request)
    {
        $phones = Phone::all()->sortBy('number', SORT_NATURAL | SORT_FLAG_CASE)->pluck('number', 'id');

        // $services = Service::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name', 'id');

        $services = Service::all()->sortByDesc('code');

        return view('phone_service.create', compact(['phones','services']));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     */
    public function phone_serviceStore(Request $request)
    {
        $request->validate([

            'tags' => 'required',
            'number' => 'required',
        ]);

        $input = $request->except('_method','_token');

        $tags = $input['tags'];

        $phone = Phone::findOrFail($request->number);

        if($phone && $tags) {

            $phone->updated_at = now();
            $phone->save();

            $phone->services()->syncWithoutDetaching($tags);

            return redirect()->route('phone_service.index')
                ->with('success', 'Tag successfully created.');
        }

        return redirect()->route('phone_service.index')
        ->with('error', 'Oops!  Something went wrong.  Please try again later.');

    }

    /**
     * @param Request $request
     * @param Phone $phone
     * @return View|Factory
     * @throws BindingResolutionException
     */
    public function phone_serviceEdit(Request $request, Phone $phone)
    {
        $taggedServices = Service::whereHas('phones', function($query) use($phone) {
            $query->where('phone_id', '=', $phone->id);
        })->orderBy('name', 'asc')->get();

        $noneTaggedServices = Service::whereDoesntHave('phones', function($query) use($phone) {
            $query->where('phone_id', '=', $phone->id);
        })->orderBy('name', 'asc')->get();

        return view('phone_service.edit', compact(['phone','taggedServices','noneTaggedServices']));
    }

    /**
     * @param Request $request
     * @param Phone $phone
     * @return RedirectResponse
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     */
    public function phone_serviceUpdate(Request $request, Phone $phone)
    {
        $input = $request->except('_method','_token');
        $request->validate([
            'tags'    => ['required'],
             'number' => ['regex:/(60|62|63|64)/','required','digits:7'],
        ]);


        $tags = $input['tags'];

        $phone = Phone::findOrFail($phone->id);

        if($tags && $phone) {

            $phone->updated_at = now();
            $phone->save();

            $phone->services()->sync($tags);

            return redirect()->route('phone_service.index')
             ->with('success', 'Service Tags updated successfully');
        }

        return redirect()->route('phone_service.index')
        ->with('error', 'Something went wrong.  Please try again...');
    }

    public function phone_serviceDeleteAllServiceAttached($phone)
    {
        $phone = Phone::findOrFail($phone);

        if($phone) {
            $phone->updated_at = now();
            $phone->save();
        }

        $phone->services()->detach();

        return redirect()->route('phone_service.index')
        ->with('success', 'Phone Number detached successfully.');
    }

    /**
     * @param Request $request
     * @return View|Factory
     * @throws BindingResolutionException
     */
    public function searchPhoneService(Request $request) {

        $request->validate([

            'search' => 'required'
        ]);

        $search = $request->input('search');

        $phones = Phone::sortable()
            ->where('number','like', '%'.$search.'%')
            ->orderBy('updated_at', 'desc');

        $count = $phones->count();

        $phones = $phones->paginate(10);

       return view('phone_service.index', compact('phones'))
            ->with('search', session(['search' => $count]));
    }
}
