<div wire:init="montaChartSegmento()">
    <div wire:loading class="flex items-center content-center justify-center bg-white p-3 border shadow-md rounded-md w-full" style="height:330px;">
        <div class="flex items-center content-center h-full">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="h-24 w-24" style="margin: auto;  shape-rendering: auto;" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                <circle cx="50" cy="50" fill="none" stroke="#5b71a4" stroke-width="7" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                    <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                </circle>
            </svg>
        </div>
    </div>
    <div wire:loading.class="hidden" class="bg-white p-3 border shadow-md rounded-md z-0">
        <div class="text-center font-bold">Faturamento Por Segmento</div>
        <div id="charSegmento" style="height:280px;"></div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('renderDataSegmento', ({ detail }) => {
            Highcharts.chart('charSegmento', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: detail.categories,
                    title: {
                        text: null
                    },
                    min: 0,
                    max: 10,
                    scrollbar: {
                        enabled: true
                    },
                    tickLength: 0
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: null
                    },
                    labels:{
                        enabled:false
                    }
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        },
                    }
                },
                legend: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Faturamento',
                    data: detail.series
                }],
                tooltip: {
                    formatter:function(){
                        return  this.x + '<br>' + Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(this.point.y)
                    }
                },
            })
        })
    </script>
@endpush
