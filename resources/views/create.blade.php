@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create station') }}</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('create_data') }}">
                            @csrf

                            <div id="locationError" class="alert alert-danger "></div>

                            <input id="email" type="hidden" class="form-control @error('email') is-invalid @enderror" name="email" value="{{  Auth::user()->email }}" required >
                            <input id="latitude" type="hidden" class="form-control @error('latitude') is-invalid @enderror" name="latitude"  required >
                            <input id="longitude" type="hidden" class="form-control @error('longitude') is-invalid @enderror" name="longitude" required >


                            <div class="form-group row">
                                <label for="location" class="col-md-4 col-form-label text-md-right">{{ __('Location') }}</label>

                                <div class="col-md-6">
                                    <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" required autocomplete="location" autofocus>

                                    @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>

                                <div class="col-md-6">
{{--                                    <input id="amount" type="text" class="form-control @error('type') is-invalid @enderror" name="amount" value="{{ old('type') }}" required autocomplete="amount" autofocus>--}}

                                    <select name="type">
                                    <option value="petrol">Petrol</option>
                                    <option value="diesel">Diesel</option>
                                    <option value="unleaded_premium_super">Unleaded Premium Super</option>
                                    <option value="kerosene">Kerosene</option>
                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Price per liter') }}</label>

                                <div class="col-md-6">
                                    <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required autocomplete="price" autofocus>

                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>





                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Delivery cost per kilometer') }}</label>

                                <div class="col-md-6">
                                    <input id="price" type="text" class="form-control @error('delivery_cost') is-invalid @enderror" name="delivery_cost" value="{{ old('delivery_cost') }}" required autocomplete="price" autofocus>

                                    @error('delivery_cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create') }}
                                    </button>
                                </div>
                            </div>

                        </form>


                        <script>
                            let latitude = document.getElementById("latitude");
                            let longitude = document.getElementById("longitude");
                            let x = document.getElementById("locationError");
                            if (navigator.geolocation) {
                                x.remove();
                                navigator.geolocation.getCurrentPosition(showPositionByGeolocation);
                            } else {
                                showPositionByIp();
                                x.innerHTML = "Geolocation is not supported by this browser.(using Ip which is less accurate)";
                            }
                            function showPositionByGeolocation(position) {

                                longitude.value = position.coords.longitude;
                                latitude.value = position.coords.latitude;
                            }
                            function showPositionByIp(){
                                jQuery.get("http://ipinfo.io", function(response) {
                                    console.log("=>"+response.loc);
                                    let lat= response.loc.substring(0,response.loc.indexOf(",") )
                                    let long= response.loc.substring(response.loc.indexOf(",")+1,response.loc.length )

                                    console.log("lat =>"+lat);
                                    console.log("long =>"+long);

                                    latitude.value=lat;
                                    longitude.value=long;

                                }, "jsonp");

                            }


                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
