<div>
  <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js">
  
</script><script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script><script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

<script>
                      // Setup block

                      const data = {
                        labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                        datasets: [{
                           label: 'Weekly Sales',
                           data: [{
                x: new Date('2023-08-05').setHours(0,0,0,0),
                o: 1.25,
                h: 1.35,
                l: 1.00,
                c: 1.10,
                s: [1.25,1.10]
              },
              {
                x: new Date('2023-08-04').setHours(0,0,0,0),
                o: 1.10,
                h: 1.35,
                l: 1.00,
                c: 1.20,
                s: [1.10,1.20]
              },
              {
                x: new Date('2023-08-03').setHours(0,0,0,0),
                o: 1.20,
                h: 1.50,
                l: 1.20,
                c: 1.50,
                s: [1.20,1.50]
              },
              {
                x: new Date('2023-08-02').setHours(0,0,0,0),
                o: 1.50,
                h: 1.80,
                l: 1.20,
                c: 1.40,
                s: [1.50,1.40]
              },
              {
                x: new Date('2023-08-01').setHours(0,0,0,0),
                o: 1.40,
                h: 2.00,
                l: 1.30,
                c: 1.75,
                s: [1.40,1.75]
              }],

              backgroundColor: (ctx) => {
                const { raw:{ o, c} } = ctx;
                console.log(ctx.raw.o)
                console.log(ctx.raw.c)
                if(c >= o){
                  color = 'rgba(75, 192, 0, 0.2)';
                }else{
                  color = 'rgba(255, 26, 104, 0.2)';
                }
                return color;
              },

                           /*backgroundColor: 'rgba(0, 0, 0,1)',*/
                           borderWidth: 2,
                           borderColor: 'rgba(0, 0, 0,1)',
                           borderSkipped: false
                           
                        }]
                      };

                      const candlestick = {
                        id: 'candlestick',
                        beforeDatasetsDraw(chart, args, pluginOptions){
                          const { ctx, data, chartArea: {top, bottom, left, right, width, height}, scales: {x,y}} = chart;
                          ctx.save();

                          const closingPrice = data.datasets[0].data.map(datapoint => {
                            return datapoint.c;
                          });
                          data.datasets[0].data.forEach((datapoint, index) =>{
                            ctx.beginPath();
                          ctx.moveTo(chart.getDatasetMeta(0).data[index].x,chart.getDatasetMeta(0).data[index].y);
                          ctx.lineTo(chart.getDatasetMeta(0).data[index].x,y.getPixelForValue(data.datasets[0].data[index].h));
                          ctx.stroke();
                          
                          ctx.beginPath();
                          ctx.moveTo(chart.getDatasetMeta(0).data[index].x,chart.getDatasetMeta(0).data[index].y);
                          ctx.lineTo(chart.getDatasetMeta(0).data[index].x,y.getPixelForValue(data.datasets[0].data[index].l));
                          ctx.stroke();
                          })


                        }
                      }

                      //config block
                      const config = {
                        type: 'bar',
                        data: data,
                        options: {
                          parsing: {
                            xAxisKey: 'x',
                            yAxisKey: 's',
                          }
                        },
                        scales: {
                          x: {
                            type: 'timeseries',
                            time: {
                              unit: 'day'
                            }
                          },
                          y: {
                            beginAtZero: true,
                            grace: '5%'
                          }
                        },
                        plugins: [candlestick]
                      };

                      //render block
                      var myChart = new Chart (
                        document.getElementById('myChart'),
                        config
                        );
                    </script>