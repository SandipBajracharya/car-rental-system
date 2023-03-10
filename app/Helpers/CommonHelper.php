<?php

use App\Services\ReservationActivityLogServices;
use App\Services\FaqServices;
use App\Services\ContactServices;

function getRerservationLog($limit = 7)
{
    return (new ReservationActivityLogServices)->findAll($limit);
}

function getFaqs($limit = 5)
{
    return (new FaqServices)->findAllFaqs($limit);
}

function getContact()
{
    return (new ContactServices)->findLatestContact();
}

function clearSession()
{
    session()->forget('rental_info');
    session()->forget('vehicle_id');
    session()->forget('is_guest');
    session()->forget('guest_id');
    return true;
}

function excerpt($title, $limit = 25) {
    $trimmed_title = substr($title, 0, $limit);

    if (strlen($title) > $limit) {
        return $trimmed_title.'...';
    } else {
        return $title;
    }
}

function getCarListUrl()
{
    $rental_info = session()->get('rental_info');
    if (!empty($rental_info) && count($rental_info) > 0) {
        $url = '/find-car?pickup_location='.$rental_info['pickup_location'].'&start_dt='.$rental_info['start_dt'].'&end_dt='.$rental_info['end_dt'];
    } else {
        $url = '/car-listing';
    }
    return $url;
}
