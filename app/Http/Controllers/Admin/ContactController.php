<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContactServices;
use App\Http\Requests\ContactRequest;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    private $contactService;

    public function __construct(contactServices $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->contactService->getIndexDataTable();
        }
        $contactCount = $this->contactService->countContact();
        return view('pages.admin.contact.index', compact('contactCount'));
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
    public function store(ContactRequest $request)
    {
        $result = $this->contactService->addContact($request);
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
        $data = $this->contactService->findContactById($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, $id)
    {
        $result = $this->contactService->updateContact($request, $id);
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
