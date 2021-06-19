<div>
    <div class="bg-white p-3 border shadow-md rounded-md z-0">
        <div class="text-center font-bold">Faturamento Por Segmento</div>

            <div id="cSegmento"></div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', () => {
            Highcharts.chart('cSegmento', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: @this.cSegmento.categories,
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
                    title: {
                        enabled:false,
                        text: '',
                        align: 'high'
                    },
                    labels: {
                        enabled:false
                    }
                },
                tooltip: {
                    formatter:function(){
                        return  '<strong>' + this.x + '</strong>' + '<br>' + '- ' + Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(this.point.y)
                    }
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true,
                            formatter:function(){
                                return Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(this.point.y)
                            }
                        }
                    }
                },
                credits: {
                    enabled: false
                },
                legend:{
                    enabled: false
                },
                series: [
                    {
                    name: 'Total',
                    data: @this.cSegmento.series,
                    dataSorting: {
                        enabled: true
                    }
                }
                ]
            });
        })
        document.addEventListener('atualizaChart', () => {
            Highcharts.chart('cSegmento', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: @this.dataSegmento.categories,
                    title: {
                        text: null
                    },
                },
                yAxis: {
                    title: {
                        enabled:false,
                        text: '',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify',
                        enabled:false
                    }
                },
                tooltip: {
                    formatter:function(){
                        return  '<strong>' + this.x + '</strong>' + '<br>' + '- ' + Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(this.point.y)
                    }
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true,
                            formatter:function(){
                                return Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(this.point.y)
                            }
                        }
                    }
                },
                credits: {
                    enabled: false
                },
                legend:{
                    enabled: false
                },
                series: [
                    {
                        name: 'Total',
                        data: @this.dataSegmento.series,
                        dataSorting: {
                            enabled: true
                        }
                    }
                ]
            });
        })
    </script>
@endpush
