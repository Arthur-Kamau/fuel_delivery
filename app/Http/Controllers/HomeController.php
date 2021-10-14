<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $list = DB::table('gas_list')->get();
        return view('home', ['lists'=> $list]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sortByPrice()
    {
        $list = DB::table('gas_list')->orderBy('price')->get();
        return view('home', ['lists'=> $list]);
    }


    /**
     * Show the application dashboard. sorted by location
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sortByLocation()
    {
        $list = DB::table('gas_list')->orderBy('location')->get();
        return view('home', ['lists'=> $list]);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sortByType($type)
    {
        $list = DB::table('gas_list')->where('type', $type)->get();
        return view('type', ['lists'=> $list, 'type'=>$type]);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Show the application dashboard.
     *
    */
    public function createData(Request $request)
    {


        $validated = $request->validate([
            'location' => 'required|max:255',
            'price' => 'required',
            'type' => 'required',
            'delivery_cost' => 'required',

            'email' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $location = $request->input('location');
        $price = $request->input('price');
        $type = $request->input('type');
        $deliveryCost = $request->input('delivery_cost');
        $email = $request->input('email');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');


        DB::table('gas_list')->insert(
            [
                'email' => $email,
                'location' => $location,
                'type'=>$type,
                'delivery_cost'=>$deliveryCost,
                'price'=>$price,
                'latitude'=>$latitude,
                'longitude'=>$longitude,

            ]
        );
        return redirect('/home');
    }


}
