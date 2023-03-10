<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AboutUsServices;
use App\Http\Requests\AboutRequest;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AboutUsController extends Controller
{
    private $aboutUsService;

    public function __construct(AboutUsServices $service)
    {
        $this->aboutUsService = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->aboutUsService->getIndexDataTable();
        }
        $aboutCount = $this->aboutUsService->countContent();
        return view('pages.admin.aboutUs.index', compact('aboutCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AboutRequest $request)
    {
        $result = $this->aboutUsService->addAbout($request);
        Alert::toast($result['message'], $result['status']);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->aboutUsService->findById($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AboutRequest $request, $id)
    {
        $result = $this->aboutUsService->updateAbout($request, $id);
        Alert::toast($result['message'], $result['status']);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
