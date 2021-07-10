<div>
    <div class="bg-white p-3 border shadow-md rounded-md" >
        <div class="text-center font-bold">Faturamento X Custo Peso X Custo Cubagem</div>
        <div id="chartFatCust" style="height:280px;"></div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', () => {
            Highcharts.chart('chartFatCust', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: @this.dataGraf.databaixa,
                    title: {
                        text: null
                    }
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
                    data: @this.dataGraf.faturamento
                }, {
                    name: 'Custo Peso',
                    data: @this.dataGraf.custo_peso
                },{
                    name: 'Custo Cubagem',
                    data: @this.dataGraf.custo_cubagem
                }],
                tooltip: {
                    pointFormatter: function () {
                        var s = '<b>' + this.series.name + '</b>';
                        s += '<br/> ' + Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(this.y);
                        return s;
                    }
                },
            })
            document.addEventListener('updateChart', () => {
                Highcharts.chart('charSegmento', {
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
                        }
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
