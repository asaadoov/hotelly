@push('css')
<link rel="stylesheet" href="{{ asset('plugins/charts-c3/c3.min.css') }}"/>
@endpush

@push('js')
<script src="{{ asset('bundles/apexcharts.bundle.js') }}"></script>
<script src="{{ asset('bundles/counterup.bundle.js') }}"></script>
<script src="{{ asset('bundles/knobjs.bundle.js') }}"></script>
<script src="{{ asset('bundles/c3.bundle.js') }}"></script>
<script src="{{ asset('bundles/echarts.bundle.js') }}"></script>
<script src="{{ asset('js/chart/c3.js') }}"></script>
<script src="{{ asset('js/chart/echart.js') }}"></script>
<script src="{{ asset('js/chart/apex.js') }}"></script>
@endpush