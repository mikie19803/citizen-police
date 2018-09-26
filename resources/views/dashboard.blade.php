@extends('layouts.citizen')
@section('title')
Dashboard
@stop
@section('extra-styles')

@stop
@section('content')
    {{--    {{dd($report)}}--}}
    <?php
    $arr = [];
    array_push($arr, [
        'name' => 'Open Cases',
        'y' => $openCases
    ]);
    array_push($arr, [
        'name' => 'Closed Cases',
        'y' => $closedCases
    ]);
    $data = json_encode($arr);
    ?>
    <div class="row">
        <div class="col-md-offset-2 col-md-4">
            <h4>Open Cases: {{$openCases}}</h4>
            <h4>Closed Cases: {{$closedCases}}</h4>
            <h4>All Cases: {{$openCases + $closedCases}}</h4><br/>
        </div>
        <div class="col-md-4 col-md-offset-1">
            <form action="{{url('/dashboard')}}" method="get">
                <div class="row">
                    <label class="col-md-2">From: </label>
                    <div class="col-md-6">

                        <input type="date" name="from_date" class="form-control"
                        @if(isset($_GET['from_date']))
                            value="{{$_GET['from_date']}}"
                                @endif
                        >
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-2">To: </label>
                    <div class="col-md-6">

                    <input type="date" name="to_date" class="form-control"
                    @if(isset($_GET['to_date']))
                        value="{{$_GET['to_date']}}"
                            @endif >
                    </div>
                    <button class="btn btn-blue" type="submit">Search</button>
                </div>

            </form>

        </div>
    </div>
    <div class="container" id="chart">
    </div>

    <div class="container" id="container">

    </div>
@stop
@section('extra-scripts')
    <script src="{{asset('js\highcharts.js')}}"></script>
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>

    <script>
        Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
            return {
                radialGradient: {
                    cx: 0.5,
                    cy: 0.3,
                    r: 0.7
                },
                stops: [
                    [0, color],
                    [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                ]
            };
        });
        // Build the chart
        Highcharts.chart('chart', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Reports/Cases'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        },
                        connectorColor: 'silver'
                    }
                }
            },
            series: [{
                name: 'Cases',
                data: <?php echo $data ?>

            }]
        });
    </script>
@stop