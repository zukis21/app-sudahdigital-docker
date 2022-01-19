<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxCitySearch extends Controller
{
    /*public function ajax_city(Request $request){
        $keyword = $request->get('q');
        $cities = \App\City::where('type','=','Kota')
                ->where('city_name','LIKE',"%$keyword%")
                ->orderBy('display_order','ASC')
                ->orderBy('postal_code','ASC')
                ->get();
        return $cities;
    }*/

    public function ajax_city(Request $request){
        /*$keyword = $request->get('q');
        $store = \App\Customer::where('store_name','LIKE',"%$keyword%")
        ->orWhere('store_code','LIKE',"%$keyword%")->get();
        return $store;*/
        $search = $request->get('search');
        if ($request->has('store_id')){
            $store_id = $request->get('store_id');
        }else{
            $store_id = '';
        }
        $client_id =  \Auth::user()->client_id;
        if($store_id == ''){
            if($search == ''){
                $city = \App\City::where('type','=','Kota')
                        //->where('city_name','LIKE',"%$keyword%")
                        ->orderBy('display_order','ASC')
                        ->orderBy('postal_code','ASC')
                        ->get();
            }else{
                $city = \App\City::where('type','=','Kota')
                        ->where('city_name','LIKE',"%$search%")
                        ->orderBy('display_order','ASC')
                        ->orderBy('postal_code','ASC')
                        ->get();
            }
        }else{
            $store = \App\Customer::findorFail($store_id);
            $city = \App\City::where('id','=',$store->city_id)->get();
        }

        $response = array();
        foreach($city as $ct){
            $response[] = array(
                "id"=>$ct->id,
                "text"=>$ct->city_name
            );
        }

        return response()->json($response);
    }

    public function ajax_store(Request $request){
        /*$keyword = $request->get('q');
        $store = \App\Customer::where('store_name','LIKE',"%$keyword%")
        ->orWhere('store_code','LIKE',"%$keyword%")->get();
        return $store;*/
        $search = $request->get('search');
        $user_id = $request->get('user_id');
        
        if ($request->has('city_id')){
            $city_id = $request->get('city_id');
        }else{
            $city_id = '';
        }
        //$city_id = $request->get('city_id');
        $client_id =  \Auth::user()->client_id;
        if($city_id == ''){
            if($search == ''){
                $store = \App\Customer::where('client_id',$client_id)
                        ->where('user_id',$user_id)
                        ->where('status','!=','NONACTIVE')
                        ->get();
            }else{
                $store = \App\Customer::where('client_id',$client_id)
                        ->where('user_id',$user_id)
                        ->where('status','!=','NONACTIVE')
                        ->where(function($q) use($search) {
                            $q->where('store_name','LIKE',"%$search%")
                              ->orWhere('store_code','LIKE',"%$search%");
                        })->get();
                        
                        //\App\Customer::where('city_id','=',$city_id)
                        //->where('store_name','LIKE',"$search")
                        //->orWhere('store_code','LIKE',"$search")
                        //->get();
            }
        }else{
            if($search == ''){
                $store = \App\Customer::where('client_id',$client_id)
                        ->where('user_id',$user_id)
                        ->where('status','!=','NONACTIVE')
                        ->where('city_id',$city_id)->get();
            }else{
                    $store = \App\Customer::where('client_id',$client_id)
                    ->where('status','!=','NONACTIVE')
                    ->where('user_id',$user_id)
                    ->where('city_id','=',$city_id)
                    ->where(function($q) use($search) {
                        $q->where('store_name','LIKE',"%$search%")
                          ->orWhere('store_code','LIKE',"%$search%");
                    })->get();
                    
                }
        }

        $response = array();
        foreach($store as $toko){
            $response[] = array(
                "id"=>$toko->id,
                "text"=>$toko->store_code.' - '.$toko->store_name
            );
        }

        return response()->json($response);
    }

    public function ajax_reasons(Request $request){
        $keyword = $request->get('q');
        $reasons = \App\ReasonsCheckout::where('client_id','=',auth()->user()->client_id)
                    ->where('reasons_name','LIKE',"%$keyword%")
                    ->orderBy('position','ASC')->get();
        return $reasons;
    }

    public function get_latlon(Request $request){
        $store_id = $request->get('store_id');
        
        $custlatlng = \App\Customer::findOrFail($store_id);
        
        if($custlatlng->lat != null){
            $latitudeFrom = $request->get('lat');
            $longitudeFrom = $request->get('lng');

            $latitudeTo = $custlatlng->lat;
            $longitudeTo = $custlatlng->lng;

            $distance = $this->vincentyGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo);
            if ($distance < 100) {
                echo "taken";	
            }else{
                echo 'not_taken';
            }
        }else{
            echo "null";
        }
        
        //return response()->json(round($distance,2));
    }

    public function vincentyGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);
      
        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
          pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);
      
        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
      
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
      }

      function circle_distance($lat1, $lon1, $lat2, $lon2) {
        $rad = M_PI / 180;
        return acos(sin($lat2*$rad) * sin($lat1*$rad) + cos($lat2*$rad) * cos($lat1*$rad) * cos($lon2*$rad - $lon1*$rad)) * 6371000;// Kilometers
      }

      function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'kilometers') {
        $theta = $longitude1 - $longitude2; 
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
        $distance = acos($distance); 
        $distance = rad2deg($distance); 
        $distance = $distance * 60 * 1.1515; 
        switch($unit) { 
          case 'miles': 
            break; 
          case 'kilometers' : 
            $distance = $distance * 1.609344; 
        } 
        return (round($distance,2)); 
      }

      function getDistanceBetween($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Km') 
      { 
          $theta = $longitude1 - $longitude2; 
          $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)))  + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
          $distance = acos($distance); 
          $distance = rad2deg($distance); 
          $distance = $distance * 60 * 1.1515; 
          switch($unit) 
          { 
              case 'Mi': break; 
              case 'Km' : $distance = $distance * 1.609344;
          } 
          return (round($distance,2)); 
      }
}
