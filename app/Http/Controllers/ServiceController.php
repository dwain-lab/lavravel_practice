<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use App\Exports\ServicesExport;
use App\Imports\ServicesImport;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Exceptions\NoFilePathGivenException;
use SplFileObject;

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
            'code' => 'required',
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
            ->where('code','like', '%'.$search.'%')
            ->orWhere('name','like', '%'.$search.'%')
            ->orWhere('description','like', '%'.$search.'%')
            ->orderBy('updated_at', 'desc');

        $count = $services->count();

        $services = $services->paginate(10);

       return view('service.index', compact('services'))
            ->with('search', session(['search' => $count]));
    }

        /**
    * @return \Illuminate\Support\Collection
    */
    public function serviceImportUpload()
    {
        return view('service.file-import');
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws BindingResolutionException
     * @throws Exception
     * @throws NoFilePathGivenException
     */
    public function serviceImportStore(Request $request)
    {

        $rules = [
            'file' => 'required|mimes:csv,txt|max:2040',
        ];


    $customMessages = [
        'mimes' => 'File must be type CSV only.',
        'required' => 'Please insert file and try again.',
        'max' => 'File needs to be bigger than 2 megabytes',
    ];

    $this->validate($request, $rules, $customMessages);

        $path = $request->file('file')->path();
        $fileObj = new splFileObject($path, 'r');
        $fileObj->seek(1);
        if ($fileObj->current() == "\r\n" || !(preg_match('/[\d\w]+[,]\b/', $fileObj->current())) || $fileObj->current() == ""  ) {
            // echo "we are here in the object";
            // return dd($fileObj->current());
            return back()->withErrors('Please verify csv file.  File is formatted wrongly!');
        }
        // echo "we are here";
        // return dd($fileObj->current());
        $file = $request->file('file');
        $file = $file->store('temp');

        $import = new ServicesImport;
        $import->import($file);


        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        return back()->withStatus('Upload completed successfully.');


    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function serviceExport()
    {
        return new ServicesExport;
    }
}
