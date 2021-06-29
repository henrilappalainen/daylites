<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

class DaylitesController extends Controller
{

	private function getDayLite($lat, $lng, $day)
	{
		$time_str = "2021-1-1 +" . $day . " day";
		
		$sun_info = date_sun_info(strtotime( $time_str ), $lat, $lng);

		$sunrise = explode(":", date("H:i", $sun_info['sunrise']));
		$sunset = explode(":", date("H:i", $sun_info['sunset']));

		// If sunrise is more than 12, it is on previous day. 
		// Fix by making value negative for minus operation.
		if ($sunrise[0] > 12) {
			$sunrise[0] -= 24;
		}

		$dayliteamount = ($sunset[0] - $sunrise[0]) + ($sunset[1] - $sunrise[1]) / 60;
		
		// Quick and dirty fix to get zero reading summer days to full daylight / 24
		// Because this is supposed to only work in Finland, all summer months reading zero are filled.
		if ($dayliteamount < 0.1 && $day > 90 && $day < 270) {
			$dayliteamount = 24;
		}
		
		return $dayliteamount;
	}

	private function getYearlyDaylites($latitude, $longitude)
	{
		$lat = (float) $latitude;
		$lng = (float) $longitude;

		$list = [];

		for ($i = 0; $i <= 365; $i++) {
			array_push($list, $this->getDayLite($lat, $lng, $i));
		}
		
		return $list;
	}

		/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$latitude = $request->input('latitude');
		$longitude = $request->input('longitude');
	
		// return 'testi';

		// Return Json Response
		return response()
			->json([
				'daylites' => $this->getYearlyDaylites($latitude, $longitude)
			], 200);
	}
}