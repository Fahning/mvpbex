<div wire:init="montaChart()">
    <div wire:loading class="flex items-center content-center justify-center bg-white p-3 border shadow-md rounded-md w-full" style="height:330px;">
        <div class="flex items-center content-center h-full">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="h-24 w-24" style="margin: auto;  shape-rendering: auto;" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                <circle cx="50" cy="50" fill="none" stroke="#5b71a4" stroke-width="7" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                    <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                </circle>
            </svg>
        </div>
    </div>
    <div wire:loading.class="hidden" class="bg-white p-3 border shadow-md rounded-md">
        <div class="text-center font-bold">Faturamento X Custo Peso X Custo Cubagem</div>
        <div id="chartFatCust" style="height:280px;"></div>
    </div>

</div>

@push('scripts')
    <script>
        window.addEventListener('renderData', ({ detail }) => {
            Highcharts.chart('chartFatCust', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: detail.newData.databaixa,
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: null
                    },
                    labels: {
                        enabled: false
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
                    data: detail.newData.faturamento
                }, {
                    name: 'Custo Peso',
                    data: detail.newData.custo_peso
                }, {
                    name: 'Custo Cubagem',
                    data: detail.newData.custo_cubagem
                }],
                tooltip: {
                    pointFormatter: function () {
                        var s = '<b>' + this.series.name + '</b>';
                        s += '<br/> ' + Intl.NumberFormat('pt-br', {
                            style: 'currency',
                            currency: 'BRL'
                        }).format(this.y);
                        return s;
                    }
                },
            })
        })
    </script>
@endpush
