<div>
    <div class="bg-white p-3 border shadow-md rounded-md z-0">
        <div class="text-center font-bold">Faturamento Por Dia Do Mês</div>
        <div id="container" style="height:280px;"></div>
    </div>
</div>

@push('scripts')
    <script>
        function formatDate(date){
            return date.replace(/(\d*)-(\d*)-(\d*).*/, '$3-$2-$1');
        }
        document.addEventListener('livewire:load', () => {
            Highcharts.chart('container', {
                chart: {
                    type: 'line',
                    events: {
                        load: function(event) {
                        event.target.reflow();
                        }
                    }
                },
                title: {
                    text: null
                },
                subtitle: {
                    text: null
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    labels:{
                        enabled:false
                    },
                },
                xAxis: {
                    categories: @this.data.day,
                    labels:{
                        type: 'datetime',
                        labels: {
                            format: '{value:%d}',
                            rotation: 45,
                            align: 'left'
                        }
                    }
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
                        return  formatDate(this.x) + '<br>' + Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(this.point.y)
                    }
                },
                responsive: {
                    rules: [{
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
                    },
                    labels:{
                        enabled:false
                    },
                },
                xAxis: {
                    categories: @this.data.day,
                    labels:{
                        type: 'datetime',
                        labels: {
                            format: '{value:%d}',
                            rotation: 45,
                            align: 'left'
                        }
                    }
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
                        return  formatDate(this.x) + '<br>' + Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(this.point.y)
                    }
                },
                responsive: {
                    rules: [{
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

