<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        * {
            font-size: 1.05em;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1 id='title' class="jumbotron text-center">{{ config('app.name') }}</h1>

        @if($nearest)
            <div class="card mt-4 mb-4">
                <div class="card-header bg-dark text-white">
                    <h4>This is the nearest place to you!</h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-start">
                        <div class="col-4">
                            Place Name
                        </div>
                        <div class="col-*">
                            {{ $nearest->name }}
                        </div>
                    </div>
                    <div class="row justify-content-start">
                        <div class="col-4">
                            Location
                        </div>
                        <div class="col-*">
                            {{ $nearest->city }} / {{ $nearest->country }}
                        </div>
                    </div>
                    <div class="row justify-content-start">
                        <div class="col-4">
                            Free Bikes
                        </div>
                        <div class="col-*">
                            {{ $nearest->free_bikes }}
                        </div>
                    </div>
                    <div class="row justify-content-start">
                        <div class="col-4">
                            Distance in Km
                        </div>
                        <div class="col-*">
                            {{ number_format($nearest->distance, 1) }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div>
            <form id="filterForm" action="{{ route('places') }}">
                <h3>Filters</h3>
                <div class="form-row">
                    <div class="col-auto">
                        <label class="sr-only" for="name">Name</label>
                        <input type="text" class="form-control mb-2" name="name" placeholder="Filter by name" value="{{ $filter['name'] }}"/>
                    </div>
                    <div class="col-auto">
                        <label class="sr-only" for="city">City</label>
                        <input type="text" class="form-control mb-2" name="city" placeholder="Filter by city" value="{{ $filter['city'] }}"/>
                    </div>
                    <div class="col-auto">
                        <input type="submit" class="btn btn-primary mb-2" value="Filter">
                        <button id="btnReset" type="reset" class="btn btn-danger mb-2 reset">Clear</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <th>Name</th>
                    <th>Location</th>
                    <th>Distance (in Km)</th>
                    <th>Free Bikes</th>
                </thead>
                <tbody>
                    @foreach ($places as $place)
                        <tr>
                            <td>{{ $place->name }}</td>
                            <td>{{ $place->city }} / {{ $place->country }}</td>
                            <td>{{ number_format($place->distance, 1) }}
                            <td>{{ $place->free_bikes }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.getElementById('btnReset').addEventListener('click', () => {
            window.location = "{{ route('places') }}";
        });
    </script>
</body>
</html>
