<div
    class="fixed inset-0 w-full h-full z-20 bg-black bg-opacity-40 backdrop-filter backdrop-blur-lg duration-300 overflow-y-auto"
    x-show="isModelInsightOpen"
    x-transition:enter="transition duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div class="relative sm:w-3/4 md:w-1/2 lg:w-2/3 mx-2 sm:mx-auto my-10 opacity-100">
        <div
            class="relative bg-white shadow-lg rounded-md text-gray-900 z-20"
            @click.away="isModelInsightOpen = false"
            x-show="isModelInsightOpen"
            x-transition:enter="transition transform duration-300"
            x-transition:enter-start="scale-0"
            x-transition:enter-end="scale-100"
            x-transition:leave="transition transform duration-300"
            x-transition:leave-start="scale-100"
            x-transition:leave-end="scale-0"
        >
            <header class="flex items-center justify-between p-2">
                <h2 class="font-semibold">Insights</h2>
                <button class="focus:outline-none p-2" @click="isModelInsightOpen = false">
                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path
                            d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"
                        ></path>
                    </svg>
                </button>
            </header>
            <main class="p-2">
                <div wire:loading class="overflow-y-scroll w-full" style="height: 32rem;">
                    <div class="animate-pulse flex flex-col " >
                        <div class="h-24 bg-gray-400 rounded w-full"></div>
                        <div class="h-72 my-2 bg-gray-400 rounded w-full"></div>
                        <div class="flex my-1">
                            <div class="h-72 mr-2 bg-gray-400 rounded w-full"></div>
                            <div class="h-72 ml-1 bg-gray-400 rounded w-4/6"></div>
                        </div>
                        <div class="flex my-1">
                            <div class="h-72 mr-2 bg-gray-400 rounded w-full"></div>
                            <div class="h-72 ml-1 bg-gray-400 rounded w-4/6"></div>
                        </div>
                        <div class="flex my-1">
                            <div class="h-72 mr-2 bg-gray-400 rounded w-full"></div>
                            <div class="h-72 ml-1 bg-gray-400 rounded w-4/6"></div>
                        </div>
                    </div>
                </div>

                <!-- body -->
                <div wire:loading.class="hidden" class="overflow-y-scroll" style="height: 32rem;">
                    <div class="flex flex-col p-3 ">
                        <!-- Geral -->
                        <div class="border shadow-sm rounded-md text-sm bg-gray-200 text-gray-500 p-1 mb-2">
                            {{$insightModal['descricao'] ?? ''}}
                        </div>
                        <div class="w-full p-3 border shadow-sm rounded-md">
                            <div id="charModal" style="height:200px;"></div>
                        </div>

                        <div class="my-3"></div>

                        <!-- Chart Um -->
                        <div class="flex flex-row">
                            <div class="flex-1 border shadow-sm rounded-md">
                                <div id="chartUm" style="height:280px;"></div>
                            </div>
                            <div class="ml-2 w-96 border text-sm shadow-sm rounded-md bg-gray-200 text-gray-500 p-2" style="height:280px;">
                                {{$insightModal['chart_um']->description ?? ''}}
                            </div>
                        </div>

                        <div class="my-3"></div>

                        <!-- Chart Dois -->
                        <div class="flex flex-row">
                            <div class="flex-1 border shadow-sm rounded-md">
                                <div id="chartDois" style="height:280px;"></div>
                            </div>
                            <div class="ml-2 w-96 border text-sm shadow-sm rounded-md bg-gray-200 text-gray-500 p-2" style="height:280px;">
                                {{$insightModal['chart_dois']->description ?? ''}}
                            </div>
                        </div>

                        <div class="my-3"></div>

                        <!-- Chart Tres -->
                        <div class="flex flex-row">
                            <div class="flex-1 border shadow-sm rounded-md">
                                <div id="chartTres" style="height:280px;"></div>
                            </div>
                            <div class="ml-2 w-96 border text-sm rshadow-sm rounded-md bg-gray-200 text-gray-500 p-2" style="height:280px;">
                                {{$insightModal['chart_tres']->description ?? ''}}
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>
</div>


<script>
    window.addEventListener('renderDataInsight', ({ detail }) => {
        Highcharts.chart('charModal', {
            chart: {
                type: 'area'
            },
            title: {
                text: 'Evolução do Faturamento Ultimos 3 Meses'
            },
            subtitle: {
                text: null
            },
            yAxis: {
                labels:{
                    enabled:false
                },
                title: {
                    text: null
                }
            },
            xAxis: {
                categories: detail.faturamento.sk_data,
            },
            legend: {
                enabled: false,
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
            series: [{
                name: 'Faturamento',
                data: detail.faturamento.faturamento
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
        });
        Highcharts.chart('chartUm', {
            chart: {
                type: 'bar'
            },
            title: {
                text: null
            },
            subtitle: {
                text: null
            },
            yAxis: {
                labels:{
                    enabled:false
                },
                title: {
                    text: null
                }
            },
            xAxis: {
                labels:{
                    enabled:true
                },
                categories: detail.chart_um.sk_data
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
                    },
                    borderRadius: 5
                }
            },
            series: [{
                name: 'Faturamento',
                data: detail.chart_um.valores
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
        });
        Highcharts.chart('chartDois', {
            chart: {
                type: 'bar'
            },
            title: {
                text: null
            },
            subtitle: {
                text: null
            },
            yAxis: {
                labels:{
                    enabled:false
                },
                title: {
                    text: null
                }
            },
            xAxis: {
                labels:{
                    enabled:true
                },
                categories: detail.chart_dois.sk_data
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
                    },
                    borderRadius: 5
                },
            },
            series: [{
                name: 'Faturamento',
                data: detail.chart_dois.valores
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
        });
        Highcharts.chart('chartTres', {
            chart: {
                type: 'bar'
            },
            title: {
                text: null
            },
            subtitle: {
                text: null
            },
            yAxis: {
                labels:{
                    enabled:false
                },
                title: {
                    text: null
                }
            },
            xAxis: {
                labels:{
                    enabled:true
                },
                categories: detail.chart_tres.sk_data
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
                    },
                    borderRadius: 5
                }
            },
            series: [{
                name: 'Faturamento',
                data: detail.chart_tres.valores
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
        });
    })
</script>
