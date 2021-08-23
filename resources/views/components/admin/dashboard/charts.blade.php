@push('libs_js')
    <script src="{{ asset('assets/app/libs/morris-js/morris.min.js') }}"></script>
    <script src="{{ asset('assets/app/libs/raphael/raphael.min.js') }}"></script>
    <script>
        $(function(){
             new Morris.Bar({
                // ID of the element in which to draw the chart.
                element: 'orders-chart',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data: @json($orders),
                // The name of the data record attribute that contains x-values.
                xkey: 'month',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['total'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['Total'],
                barColors: ['#71b6f9'],
                yLabelFormat: function(y) {return new Intl.NumberFormat('en-IN', {style: 'currency', currency:'INR'}).format(y);}
            });

            new Morris.Bar({
                element: 'bookings-chart',
                data: @json($bookings),
                xkey: 'month',
                ykeys: ['total'],
                labels: ['Total'],
                barColors: ['#5b69bc'],
                yLabelFormat: function(y) {return new Intl.NumberFormat('en-IN', {style: 'currency', currency:'INR'}).format(y);}
            });
        })
    </script>
@endpush

<div class="col-md-6">
    <div class="card-box">
        <h4 class="header-title mt-0 mb-3">Orders Analystics</h4>
        <div id="orders-chart"></div>
    </div>
</div>
<div class="col-md-6">
    <div class="card-box">
        <h4 class="header-title mt-0 mb-3">Bookings Analystics</h4>
        <div id="bookings-chart"></div>
    </div>
</div>