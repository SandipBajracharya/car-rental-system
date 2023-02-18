<?php

use App\Services\ReservationActivityLogServices;

function getRerservationLog($limit = 7)
{
    return (new ReservationActivityLogServices)->findAll($limit);
}
