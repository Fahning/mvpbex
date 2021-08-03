<div id="modal_overlay" class="z-30 hidden absolute inset-0 bg-black bg-opacity-30 h-screen w-full flex justify-center items-start md:items-center pt-10 md:pt-0">

    <button
        onclick="openModal(false)"
        class="absolute top-16 right-11 bg-red-500 hover:bg-red-600 text-2xl w-10 h-10 rounded-full focus:outline-none text-white">
        &cross;
    </button>
    <!-- modal -->
    <div id="modal" class="z-40 overflow-y-auto pacity-0 transform -translate-y-full scale-150  relative w-11/12 md:w-11/12 h-3/4 md:h-3/4 bg-white rounded shadow-lg transition-opacity transition-transform duration-300">
        <!-- button close -->

        <!-- body -->
            <div class="flex flex-col p-3 ">
                <!-- Geral -->
                <div class="border shadow-sm rounded-md bg-gray-200 text-gray-500 p-1 mb-2">
                    {{$insightModal['descricao'] ?? ''}}
                </div>
                <div class="w-full  p-3 border shadow-sm rounded-md">
                    <div id="charModal" style="height:280px;"></div>
                </div>

                <div class="my-3"></div>

                <!-- Chart Um -->
                <div class="flex flex-row">
                    <div class="flex-1 border shadow-sm rounded-md">
                        <div id="chartUm" style="height:280px;"></div>
                    </div>
                    <div class="ml-2 w-96 border shadow-sm rounded-md bg-gray-200 text-gray-500 p-2" style="height:280px;">
                        {{$insightModal['chart_um']->description ?? ''}}
                    </div>
                </div>

                <div class="my-3"></div>

                <!-- Chart Dois -->
                <div class="flex flex-row">
                    <div class="flex-1 border shadow-sm rounded-md">
                        <div id="chartDois" style="height:280px;"></div>
                    </div>
                    <div class="ml-2 w-96 border shadow-sm rounded-md bg-gray-200 text-gray-500 p-2" style="height:280px;">
                        {{$insightModal['chart_dois']->description ?? ''}}
                    </div>
                </div>

                <div class="my-3"></div>

                <!-- Chart Tres -->
                <div class="flex flex-row">
                <div class="flex-1 border shadow-sm rounded-md">
                    <div id="chartTres" style="height:280px;"></div>
                </div>
                <div class="ml-2 w-96 border shadow-sm rounded-md bg-gray-200 text-gray-500 p-2" style="height:280px;">
                    {{$insightModal['chart_tres']->description ?? ''}}
                </div>
            </div>

            </div>
        </div>

</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:loaded', () => {
            Highcharts.chart('charModal', {
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
                    categories: []
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
                    data: []
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
                    categories: []
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
                    data: []
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
                    categories: []
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
                    data: []
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
                    categories: []
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
                    data: []
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

        document.addEventListener('livewire:update', () => {
            document.addEventListener('alpine:init', () => {
                Alpine.data('isSidebarOpen', false)
            })
            Highcharts.chart('charModal', {
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
                    categories: @this.insightModal != null ? @this.insightModal.faturamento.sk_data : []
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
                    data: @this.insightModal != null ? @this.insightModal.faturamento.faturamento : []
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
                    categories: @this.insightModal != null ? @this.insightModal.chart_um.sk_data : []
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
                    data: @this.insightModal != null ? @this.insightModal.chart_um.faturamento : []
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
                    categories: @this.insightModal != null ? @this.insightModal.chart_dois.sk_data : []
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
                    data: @this.insightModal != null ? @this.insightModal.chart_dois.faturamento : []
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
                    categories: @this.insightModal != null ? @this.insightModal.chart_tres.sk_data : []
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
                    data: @this.insightModal != null ? @this.insightModal.chart_tres.faturamento : []
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
@endpush

<script>
    document.addEventListener('abreModal', ({detail}) => {
        openModal(true)
    })
    const modal_overlay = document.querySelector('#modal_overlay');
    const modal = document.querySelector('#modal');

    function openModal (value){
        const modalCl = modal.classList
        const overlayCl = modal_overlay

        if(value){
            overlayCl.classList.remove('hidden')
            setTimeout(() => {
                modalCl.remove('opacity-0')
                modalCl.remove('-translate-y-full')
                modalCl.remove('scale-150')
            }, 100);
        } else {
            modalCl.add('-translate-y-full')
            setTimeout(() => {
                modalCl.add('opacity-0')
                modalCl.add('scale-150')
            }, 100);
            setTimeout(() => overlayCl.classList.add('hidden'), 300);
        }
    }

</script>
