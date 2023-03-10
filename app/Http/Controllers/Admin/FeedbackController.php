<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContactServices;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FeedbackController extends Controller
{
    private $contactService;

    public function __construct(contactServices $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->contactService->getFeedbackIndexDataTable();
        }
        return view('pages.admin.feedback.index');
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
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->contactService->deleteFeedback($id);
        Alert::toast($result['message'], $result['status']);
        return redirect()->back();
    }
}
