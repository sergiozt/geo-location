<?php
/**
 * User: s.zheleznitskij
 * Date: 12/27/13
 * Time: 3:30 PM
 * Calculate a Destination Coordinate based on Distance(Radius) and angle(North - East and South - West )
 *
 */

$latitude = 32.9697;
$longitude = 20;
$radius = 100;

function geoDestination($latitude,$longitude, $radius)
{
    $latitudeRad = toRad($latitude);
    $longitudeRad = toRad($longitude);

    $radius = $radius / 6371.01; //Earth's radius in km
    $angleFirst = 45;
    $angleSecond  = -135;

    // for firs pair
    $angleFirst = toRad($angleFirst);
    $latitudeFirst = asin( sin($latitudeRad)*cos($radius) +
    cos($latitudeRad) * sin($radius) * cos($angleFirst) );
    $longitudeFirst = $longitudeRad + atan2(sin($angleFirst) * sin($radius) * cos($latitudeRad),
            cos($radius) - sin($latitudeRad) * sin($latitudeFirst));
    $longitudeFirst = fmod(($longitudeFirst + 3 * pi()),(2 * pi())) - pi();

    // for second pair
    $angleSecond = toRad($angleSecond);
    $latitudeSecond = asin( sin($latitudeRad)*cos($radius) +
    cos($latitudeRad) * sin($radius) * cos($angleSecond) );
    $longitudeSecond = $longitudeRad + atan2(sin($angleSecond) * sin($radius) * cos($latitudeRad),
            cos($radius) - sin($latitudeRad) * sin($latitudeSecond));
    $longitudeSecond = fmod(($longitudeSecond + 3 * pi()),(2 * pi())) - pi();

    $pairCoordinates = array(
        'sw' => array(
            'latitude' => toDeg($latitudeFirst),
            'longitude' => toDeg($longitudeFirst),
        ),
        'ne' => array(
            'latitude' => toDeg($latitudeSecond),
            'longitude' => toDeg($longitudeSecond),
        ),
    );

    return $pairCoordinates;
}

function toRad($deg)
{
    return $deg * pi() / 180;
}

function toDeg($rad)
{
    return $rad * 180 / pi();
}

var_dump(geoDestination($latitude, $longitude, $radius));
