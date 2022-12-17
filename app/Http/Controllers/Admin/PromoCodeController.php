<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromoCodeRequest;
use App\Services\PromoCodeServices;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PromoCodeController extends Controller
{
    private $promoCodeService;

    public function __construct(PromoCodeServices $service)
    {
        $this->promoCodeService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->promoCodeService->getIndexDataTable();
        }
        return view('pages.admin.promoCode.index');
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
    public function store(PromoCodeRequest $request)
    {
        $result = $this->promoCodeService->addPromoCode($request);
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
        $data = $this->promoCodeService->findPromoCodeById($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PromoCodeRequest $request, $id)
    {
        $result = $this->promoCodeService->updatePromoCode($request, $id);
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
        $result = $this->promoCodeService->deletePromoCode($id);
        Alert::toast($result['message'], $result['status']);
        return redirect()->back();
    }

    public function updateStatus(Request $request, $id)
    {
        $req = $request->all();
        $result = $this->promoCodeService->updatePromoCodeStatus($req, $id);
        return $result;
    }
}
