<?php

namespace App\Http\Controllers;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use App\Http\Requests;


class HomeController extends Controller
{
    public function home()
    {
    	$title = "Hotels Search";
    	return view('home',['title' => $title]);
    }

    public function search(Request $request)
    {
    	$hotel = $request->input('hotel');
    	$city = $request->input('city');
    	$min_price = $request->input('min_price');
    	$max_price = $request->input('max_price');
    	$date_start = $request->input('date_start');
    	$date_end = $request->input('date_end');

    	$final_result = array();

    	$filter = ['name' => $hotel,
    	'city' => $city,
    	'min_price' => $min_price,
    	'max_price' => $max_price,
    	'from' => $date_start,
    	'to' => $date_end];

    	$jsonurl = "https://api.myjson.com/bins/pq0f6";
		$json = file_get_contents($jsonurl);
		$hotel_list = json_decode($json);
		$hotel_list = response()->json($hotel_list);
		$hotel_list = $hotel_list -> getData() -> hotels;

		foreach ($hotel_list as $hotel_item){ 

			if(!empty($filter['name']))
			if(!(strpos(strtolower($hotel_item -> name), strtolower($filter['name'])) !== false))
			continue;

			if(!empty($filter['city']))
			if(!(strpos(strtolower($hotel_item -> city), strtolower($filter['city'])) !== false))
			continue;

			if(($hotel_item -> price > floatval($filter['max_price'])) || ($hotel_item -> price < floatval($filter['min_price'])))
			continue;

			$r = 21;
			$dates = $hotel_item -> availability;
			$date_flag = 0;

			foreach ($dates as $date) {

				$start_date_1 = strtotime($date_start);
				$end_date_1 = strtotime($date_end);
				
				$start_date_2 = strtotime($date -> from);
				$end_date_2 = strtotime($date -> to);

				if($start_date_1 < $start_date_2 ||
					$start_date_1 > $end_date_2 ||
					$end_date_1 < $start_date_2 ||
					$end_date_1 > $end_date_2)
					continue;
				else
					{
						$date_flag = 1;
						break;
					}
			}

			if(!$date_flag)
			continue;

			$final_result[] = $hotel_item;

			}

			$view = view("resultTable",compact('final_result'))->render();
	    	return response()->json(['html'=>$view]);
    }
}
