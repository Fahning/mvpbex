<div>
    <div class="bg-white p-3 border shadow-md rounded-md z-0">
        <div class="text-center font-bold mt-4">Faturamento Por Bases ({{monthToString($month)}} de {{$year}})</div>
        <div id="charBases" style="height:280px;"></div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', () => {
            Highcharts.chart('charBases', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: @this.categories,
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
                    data: @this.series
                }],
                tooltip: {
                    formatter:function(){
                        return  this.x + '<br>' + Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(this.point.y)
                    }
                },
            })
            document.addEventListener('updateChart', () => {
                Highcharts.chart('charBases', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        categories: @this.categories,
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
                        data: @this.series
                    }],
                    tooltip: {
                        formatter:function(){
                            return  this.x + '<br>' + Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(this.point.y)
                        }
                    },
                })
            })
        })
    </script>
@endpush
