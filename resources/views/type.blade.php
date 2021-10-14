@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">{{ __('Products for type ') }} {{$type}}


                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                            <tr>
                                <td scope="col">#</td>
                                <td scope="col">Location</td>
                                <td scope="col">Type</td>
                                <td scope="col">Price</td>
                                <td scope="col">Delivery cost(per Km)</td>
                                <td scope="col">Distance Km(approx)</td>
                                <td scope="col">Total Delivery cost(approx)</td>

                            </tr>
                            </thead>
                            <tbody>

                            <?php  $pos = 1?>
                            @foreach ($lists as $item)
                                <input type="hidden" id="lat-{{$loop->index}}" value="{{ $item->latitude}}"/>
                                <input type="hidden" id="long-{{$loop->index}}" value="{{ $item->longitude}}"/>
                                <input type="hidden" id="dlvry-{{$loop->index}}" value="{{ $item->longitude}}"/>
                                <tr>
                                    <td scope="row"> {{ $loop->index +1}}</td>
                                    <td>{{$item->location}}</td>
                                    <td>{{$item->type}}</td>
                                    <td>{{$item->price}}</td>
                                    <td >{{$item->delivery_cost}}          </td>

                                    <td id="distance-{{ $loop->index }}"></td>
                                    <td id="cost-{{ $loop->index }}"></td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            // start of execution

            function roundToTwo(num) {
                return +(Math.round(num + "e+2")  + "e-2");
            }


            function updateUi(longitude, latitude) {

                let itemsCount = {{count($lists)}};

                for (let i = 0; i < itemsCount; i++) {

                    const cstPerKm = document.getElementById("dlvry-" + i).value;
                    const lat = document.getElementById("lat-" + i).value;
                    const long = document.getElementById("long-" + i).value;
                    console.log("item number" + i + " item lat "+lat + " long  "+ long)


                    const r = haversine(lat, long, longitude, latitude);
                    const ele = document.getElementById("distance-" + i);
                    const ele2 = document.getElementById("cost-" + i);
                    if (ele != undefined) {


                        ele.innerText =roundToTwo( r/1000).toString();
                    } else {
                        console.error("Element distance-" + i + "  is undefined")
                    }

                    if (ele2 != undefined) {

                        ele2.innerText = roundToTwo(r*cstPerKm/1000).toString();
                    }else{
                        console.error("Element distance and cost-" + i + "  is undefined")
                    }

                }
            }

            function showPositionByGeolocation(position) {
                console.log(" long " + position.coords.longitude);
                // longitude = position.coords.longitude;
                // latitude = position.coords.latitude;
                updateUi(position.coords.longitude, position.coords.latitude)
            }

            function showPositionByIp() {
                jQuery.get("http://ipinfo.io", function (response) {
                    console.log("=>" + response.loc);
                    let lat = response.loc.substring(0, response.loc.indexOf(","))
                    let long = response.loc.substring(response.loc.indexOf(",") + 1, response.loc.length)

                    console.log("lat =>" + lat);
                    console.log("long =>" + long);

                    // latitude = lat;
                    // longitude = long;
                    updateUi(longitude, latitude);
                }, "jsonp");

            }


            function haversine(lat1, lon1, lat2, lon2) {
                // distance between latitudes
                // and longitudes
                let dLat = (lat2 - lat1) * Math.PI / 180.0;
                let dLon = (lon2 - lon1) * Math.PI / 180.0;

                // convert to radiansa
                lat1 = (lat1) * Math.PI / 180.0;
                lat2 = (lat2) * Math.PI / 180.0;

                // apply formulae
                let a = Math.pow(Math.sin(dLat / 2), 2) +
                    Math.pow(Math.sin(dLon / 2), 2) *
                    Math.cos(lat1) *
                    Math.cos(lat2);
                let rad = 6371;
                let c = 2 * Math.asin(Math.sqrt(a));
                return rad * c;

            }


            if (navigator.geolocation) {
                console.log("one ")
                navigator.geolocation.getCurrentPosition(showPositionByGeolocation);
            } else {
                console.log("twi ")
                showPositionByIp();
            }


        </script>
    </div>



@endsection
