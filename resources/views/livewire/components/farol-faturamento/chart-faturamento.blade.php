<div wire:init="dispatchData()">
    <div class="bg-white p-3 border shadow-md rounded-md z-0">
        <div class="text-center font-bold">Faturamento Por Dia Do Mês</div>
        <x-loading-table/>
        <div wire:loading.class="hidden"  id="ChartFaturamentoMes" style="height:280px;"></div>
    </div>
</div>

<script>
    function formatDate(date){
        return date.replace(/(\d*)-(\d*)-(\d*).*/, '$3-$2-$1');
    }
    function formatDateDay(date){
        return date.replace(/(\d*)-(\d*)-(\d*).*/, '$3');
    }
    window.addEventListener('renderChartFaturamento', ({ detail }) => {
        console.log(detail)
        Highcharts.chart('ChartFaturamentoMes', {
            chart: {
                type: 'line'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: detail.categories,
                labels: {
                    formatter: function() {
                        return formatDateDay(this.value);
                    }
                },

            },
            yAxis: {
                title: {
                    text: null
                },
                labels:{
                    enabled:false
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: false
                    }
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
                data: detail.series
            }],
            tooltip: {
                formatter:function(){
                    return  formatDate(this.x) + '<br>' + Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(this.point.y)
                }
            },
        })
    })
</script>

