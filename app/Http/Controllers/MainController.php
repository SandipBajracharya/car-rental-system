<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HomePageServices;
use App\Services\VehicleServices;
use App\Services\FaqServices;
use App\Services\ContactServices;
use App\Services\AboutUsServices;
use App\http\Requests\FeedbackRequest;
use RealRashid\SweetAlert\Facades\Alert;

class MainController extends Controller
{
    private $homePageService, $vehicleService, $faqService, $contactService, $aboutService;

    public function __construct(HomePageServices $service, VehicleServices $vehicleService, FaqServices $faqService, ContactServices $contactService, AboutUsServices $aboutService)
    {
        $this->homePageService = $service;
        $this->vehicleService = $vehicleService;
        $this->faqService = $faqService;
        $this->contactService = $contactService;
        $this->aboutService = $aboutService;
    }

    public function index()
    {
        $home_sliders = $this->homePageService->findAllHomeSliders();
        $topVehicle = $this->homePageService->findTopVehicle();
        return view('pages.main.homePage', compact(['home_sliders', 'topVehicle']));
    }

    public function carListing()
    {
        $vehicles = $this->vehicleService->findAllVehicles();
        session()->forget('rental_info');
        $inputs = [];
        return view('pages.main.carListing', compact('vehicles', 'inputs'));
    }

    public function viewFaqs()
    {
        $faqs = $this->faqService->findAllFaqs();
        return view('pages.main.faq', compact('faqs'));
    }

    public function contactUsPage()
    {
        $contact = $this->contactService->findLatestContact();
        return view('pages.main.feedback', compact('contact'));
    }

    public function aboutUsPage()
    {
        $about = $this->aboutService->findLatestContent();
        return view('pages.main.aboutUs', compact('about'));
    }

    public function reservationComplete()
    {
        return view('pages.main.reservationComplete');
    }

    public function addFeedback(FeedbackRequest $request)
    {
        $feedback = $this->contactService->addFeedback($request);
        Alert::toast($feedback['message'], $feedback['status']);
        return redirect()->back();
    }

    public function viewCarDetail(Request $request, $slug)
    {
        if (isset($request->rent)) {
            session()->forget('rental_info');
        }
        $vehicle = $this->vehicleService->findVehicleBySlug($slug);
        empty($vehicle->features)? $features = [] : $features = explode(',', $vehicle->features);
        $rental_info = session()->get('rental_info') ?? [];
        $show_filter = isset($rental_info) && count($rental_info) > 0? false : true;
        return view('pages.main.carDetail', compact('vehicle', 'show_filter', 'rental_info', 'features'));
    }

    public function ajaxCarDetail(Request $request)
    {
        $id = $request->id;
        $vehicle = $this->vehicleService->findVehicleById($id);
        $rental_info = session()->get('rental_info') ?? [];
        $show_filter = isset($rental_info) && count($rental_info) > 0? false : true;
        empty($vehicle->features)? $features = [] : $features = explode(',', $vehicle->features);
        $carDetail = view('include.main.carDetailModal', ['vehicle' => $vehicle, 'show_filter' => $show_filter, 'rental_info' => $rental_info , 'features' => $features])->render();
        return compact('carDetail');
    }
}
