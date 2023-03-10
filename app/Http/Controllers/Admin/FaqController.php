<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FaqServices;
use App\Http\Requests\FaqRequest;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FaqController extends Controller
{
    private $faqService;

    public function __construct(FaqServices $faqService)
    {
        $this->faqService = $faqService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->faqService->getIndexDataTable();
        }
        return view('pages.admin.faq.index');
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
    public function store(FaqRequest $request)
    {
        $result = $this->faqService->addFaq($request);
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
        $data = $this->faqService->findFaqById($id);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->faqService->findFaqById($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FaqRequest $request, $id)
    {
        $result = $this->faqService->updateFaq($request, $id);
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
        $result = $this->faqService->deleteFaq($id);
        Alert::toast($result['message'], $result['status']);
        return redirect()->back();
    }
}
