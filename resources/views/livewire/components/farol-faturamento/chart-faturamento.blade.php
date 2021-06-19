<div>
    <div class="bg-white p-3 border shadow-md rounded-md z-0">
        <div class="text-center font-bold">Faturamento Por Dia Do Mês</div>
        <div id="container" style="height:280px;"></div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', () => {
            Highcharts.chart('container', {
                title: {
                    text: null
                },
                subtitle: {
                    text: null
                },
                yAxis: {
                    title: {
                        text: null
                    }
                },

                xAxis: {
                    labels:{
                        enabled:false
                    },
                    categories: @this.data.day
                },
                legend: {
                    enabled: false,
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },
                plotOptions: {
                    series: {
                        label: {
                            connectorAllowed: false
                        }
                    }
                },
                series: [{
                    name: 'Faturamento',
                    data: @this.data.value
                }],
                tooltip: {
                    formatter:function(){
                        return  this.x + '<br>' + Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(this.point.y)
                    }
                },
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                },
                credits: {
                    enabled: false
                }
            })
        })
        document.addEventListener('atualizaChart', () => {
            Highcharts.chart('container', {
                title: {
                    text: null
                },
                subtitle: {
                    text: null
                },
                yAxis: {
                    title: {
                        text: null
                    }
                },

                xAxis: {
                    labels:{
                        enabled:false
                    },
                    categories: @this.data.day
                },
                legend: {
                    enabled: false,
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },
                plotOptions: {
                    series: {
                        label: {
                            connectorAllowed: false
                        }
                    }
                },
                series: [{
                    name: 'Faturamento',
                    data: @this.data.value
                }],
                tooltip: {
                    formatter:function(){
                        return  this.x + '<br>' + Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(this.point.y)
                    }
                },
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                },
                credits: {
                    enabled: false
                }
            })
        })


    </script>
@endpush

