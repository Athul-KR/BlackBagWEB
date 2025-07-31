
<div class="tab-pane fade @if($viewtype != 'list') show active @endif" id="pills-summary" role="tabpanel" aria-labelledby="pills-summary-tab">
         @if(empty($medicalhistoryList) )
        
         @if( ($viewtype !='patient')) 
         <div class="no-data-box">
            <p class="mb-0 align_middle"><span class="material-symbols-outlined primary">info</span>No records found!</p>
         </div>
         @endif
        @else
        <div  @if(isset($view) && $view == 'video' ) class="nograph" @else class="graph-wrapper" style="height: 300px" @endif>
            <canvas id="{{$formType}}_chart"></canvas>
        </div>
    @endif
       
   
    <input type="hidden" value="{{$formType}}" name="formType" id="formType" >
</div>
<input type="hidden" value="{{$viewtype}}" name="viewtype" id="viewtype" >

    @if($viewtype !='patient')
        @include('appointment.charts.list')
    @endif
      
         
<script>
    
var bpChartInstance = bpChartInstance || null;
var chart = '{{$formType}}'+'_chart' ;
function loadChart(labels, datasets) {
  
    setTimeout(() => {
        const canvas = document.getElementById(chart);
       
        if (!canvas) {
            console.error('Canvas not found!');
            return;
        }

        $('#pills-summary').addClass('show active');

        const ctx = canvas.getContext('2d');

        if (bpChartInstance !== null) {
            bpChartInstance.destroy();
        }

        // ✅ Reverse labels and datasets to have recent date on the right
        labels = labels.slice().reverse(); // clone and reverse
        datasets = datasets.slice().reverse();

        const colors = ['#4285F4', '#EA4335', '#34A853', '#FF9800', '#9C27B0'];

        // Add legend label mapping for specific form types
        const legendLabelMap = {
            glucose: {
                bgvalue: "Glucose",
                a1c: "A1C"
            }
            // Add more types and field mappings as needed
        };

        const chartDatasets = Object.keys(datasets[0] || {}).map((field, index) => ({
            label: (legendLabelMap['{{$formType}}'] && legendLabelMap['{{$formType}}'][field])
                ? legendLabelMap['{{$formType}}'][field]
                : field.charAt(0).toUpperCase() + field.slice(1),
            data: datasets.map(record => record[field] ?? null),
            borderColor: colors[index % colors.length],
            borderWidth: 2,
            fill: false,
            borderDash: [5, 5],
            pointBackgroundColor: colors[index % colors.length],
            pointRadius: 4,
            pointBorderColor: '#fff',
            pointBorderWidth: 1
        }));

        bpChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: chartDatasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        title: { display: true, text: 'Measurement Values' }
                    },
                    x: {
                        title: { display: true, text: 'Date' }
                    }
                }
            }
        });
    }, 300);
}

   

</script>








