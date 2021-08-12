<div wire:init="dispatchDataRO()">
    <div class="bg-white p-3 border shadow-md rounded-md" >
        <div class="text-center font-bold">Realizado x Orçado (Ano: {{$year}})</div>
        <x-loading-table/>
        <div wire:loading.class="hidden" id="chartRo" style="height:280px;"></div>
    </div>
</div>

<script>
    function formatDate(date){
        return date.replace(/(\d*)-(\d*)-(\d*).*/, '$3-$2-$1');
    }
    function formatDateDay(date){
        return date.replace(/(\d*)-(\d*)-(\d*).*/, '$2');
    }

    window.addEventListener('renderChartRO', ({ detail }) => {
        Highcharts.chart('chartRo', {
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
                labels: {
                    enabled: false
                },
            },

            xAxis: {
                categories: detail.categories
            },
            legend: {
                enabled: false,
            },
            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    }
                }
            },
            series: [
                {
                    name: 'Realizado',
                    data: detail.series
                },
                {
                    name: 'Orçado',
                    data: detail.series2
                }
            ],
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b> <br>' + this.x + '<br>' + Intl.NumberFormat('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    }).format(this.point.y)
                }
            },
            credits: {
                enabled: false
            }

        })
    })

</script>
