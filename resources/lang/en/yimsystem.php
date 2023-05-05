<?php

/* 
in php config
'parking' => [
    'name' => ':Parking parking',
]

example use
 * $msg = __('appark.invitation.qr', [
        'company' => $companyName,
        'date' => $dateFrom,
        'parking' => $parkingName,
        'plate' => $vehicle->plate,
        'url' => $invitation->url,
        'duration' => $duration
    ]);

example with var

'parking_events' => [
'not_found' => 'Parking event not found',
'exists' => 'Parking event already exists',
'error' => [
    'creating' => 'Error creating event',
    'updating' => 'Error updating event',
    'deleting' => 'Error deleting event'
],
'not_a_migrated' => 'Parking event is not a migrated event',
'attempts' => [
    \App\Classes\ParkingAttemptTypes::EVENT_01 => 'We were unable to charge your last stay. You must pay it to be able to enter again',
    \App\Classes\ParkingAttemptTypes::EVENT_02 => 'You have a valid entrance in the :Parking parking, contact the administrator',
    \App\Classes\ParkingAttemptTypes::EVENT_03 => 'You are trying to enter outside the parking hours of operation',
    \App\Classes\ParkingAttemptTypes::EVENT_04 => 'You have already used the stays of your :Contract contract',
    \App\Classes\ParkingAttemptTypes::EVENT_05 => 'You have already used the lots of your :Contract contract',
    \App\Classes\ParkingAttemptTypes::EVENT_06 => 'You must add a payment method to use your :Contract contract'
]
 */
return [

    'accepted' => 'The :attribute must be accepted.',

    
];