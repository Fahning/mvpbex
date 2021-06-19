<div>
    <div class="bg-white p-3 border shadow-md rounded-md" >
        <div class="text-center font-bold">Realizado x Orçado (Ano: {{$year}})</div>
        <div id="chartRO" style="height:280px;"></div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', () => {
            Highcharts.chart('chartRO', {
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
                    labels: {
                        enabled: false
                    },
                    categories: @this.data2.mes
                },
                legend: {
                    enabled: false,
                    layout: 'vertical',
                    align: 'bottom',
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
                    name: 'Realizado',
                    data: @this.data2.receita
                }, {
                    name: 'Orçado',
                    data: @this.data2.meta
                }],
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.series.name + '</b> <br>' + this.x + '<br>' + Intl.NumberFormat('pt-br', {
                            style: 'currency',
                            currency: 'BRL'
                        }).format(this.point.y)
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
            Highcharts.chart('chartRO', {
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
                    labels: {
                        enabled: false
                    },
                    categories: @this.data2.mes
                },
                legend: {
                    enabled: false,
                    layout: 'vertical',
                    align: 'bottom',
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
                    name: 'Realizado',
                    data: @this.data2.receita
                }, {
                    name: 'Orçado',
                    data: @this.data2.meta
                }],
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.series.name + '</b> <br>' + this.x + '<br>' + Intl.NumberFormat('pt-br', {
                            style: 'currency',
                            currency: 'BRL'
                        }).format(this.point.y)
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
