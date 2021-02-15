<?php 
require 'core/init.php';
require 'includes/styles.php';
require 'includes/navbar.php';

use Gender\Classes\Supports\Input;

auth_guard();

?>

<div class="container-fluid">

    <div class="col-md-12">
        <div class="panel panel-default float-design">
            <div class="panel-heading">
                <i class="fas fa-chart-line steel-blue"></i> Report Generator
            </div>
            <div class="panel-body my-panel-body">
            
                <form action="<?php echo MODULE_URL.'reports/rpt_gender.php';?>" method="POST" target="_blank" class="form-inline">
                    
                    <div class="form-group">
                        <select name="report_name" id="report_name" class="form-control" required>
                            <option value="">Select Report Name</option>
                            <option value="total_gender">Total Number of Gender</option>
                            <option value="total_gender_pref">Total Number of Gender Preferences</option>  
                            <option value="gender_by_month">Number of Gender by Birth Month</option>
                            <option value="gender_pref_by_month">Number of Gender Preference by Birth Month</option> 
                            <option value="total_reponses_per_categ">Number of Responses per Category</option>              
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="source" id="source" class="form-control">
                            <option value="">Select Source</option>
                            <option value="office">Per Office</option>
                            <option value="department">Per Department</option>
                            <option value="division">Per Division</option>
                            <option value="user">Per User</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="date_from" id="date_from" autocomplete="off" placeholder="Date From">
                    </div>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" name="date_to" id="date_to" autocomplete="off" placeholder="Date To">
                    </div>
                    
                    <div class="form-group">
                        <button type="button" name="generate_rpt_btn" id="generate_rpt_btn" class="btn my-btn"><i class="fas fa-bolt gamboge"></i> Generate Report</button>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="print_rpt_btn" id="print_rpt_btn" class="btn my-btn"><i class="fa fa-print medium-crimson" aria-hidden="true"></i> Print Report</button>
                    </div>
                    
                </form>
            
            </div>    
        </div>
    </div>

    <div class="col-md-12" id="rpt-container">

        <form action="<?php echo MODULE_ROOT;?>reports/print-chart" method="POST" target="_blank">
            <div class="panel panel-default" id="chart-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <input type="hidden" class="rpt-title-input" name="chart_title">
                        <input type="hidden" class="chart-base64" name="chart_base64">
                        <i class="fas fa-chart-bar radical-red"></i> <span class="rpt-title"></span> Report Summary
                        <button type="submit" name="print_chart" id="print_chart" data-toggle="tooltip" data-placement="top" title="Print Chart" class="pull-right transparent-btn"><i class="fas fa-print radical-red"></i></button>
                    </h3>
                </div>
                <div class="panel-body">
                    
                    <div class="row">
                        
                        <div class="col-md-3">
                            <img src="/miaa/assets/images/gender/gender.svg" class="img-responsive" id="report-logo">
                        </div>
                    
                        <div class="col-md-9">
                            <canvas id="chart-canvas" width="450" height="450"></canvas>
                        </div>

                        <div class="col-md-12" style="margin-top:20px;">

                            <div class="table-responsive">

                                <table class="table table-striped table-bordered" id="report-tbl">
                                    <thead>
                                        
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                        
                        </div>

                    </div>

                </div>

            </div>
        </form>
        
        <!-- <form action="<?php echo MODULE_ROOT;?>reports/print-table" method="POST" target="_blank">
            <div class="panel panel-default" id="table-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <input type="hidden" class="rpt-title-input" name="tbl_title">
                        <input type="hidden" class="tbl-head" name="tbl_head">
                        <input type="hidden" class="tbl-data" name="tbl_data">
                        <i class="fas fa-chart-bar steel-blue"></i> <span class="rpt-title"></span> Table
                        <button type="submit" name="print_tbl" id="print_tbl" data-toggle="tooltip" data-placement="top" title="Print Table" class="pull-right transparent-btn"><i class="fas fa-print steel-blue"></i></button>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="report-tbl">
                            <thead>
                                
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form> -->

    </div>

</div>

<?php 
include 'includes/footer.php';
include 'includes/scripts.php';?>
<script src="<?php echo JS;?>js-bootstrap-executive-charts/Chart.min.js"></script>
<script src="<?php echo JS;?>html2canvas.min.js"></script>
<script src="<?php echo JS;?>chartjs-plugin-labels-master/src/chartjs-plugin-labels.js"></script>
<script src="<?php echo JS;?>distinct-colors-master/dist/distinct-colors.min.js"></script>
<script type="text/javascript">

$(document).ready(function () 
{   
    dateRange("date_from","date_to","minDate");
    dateRange("date_to","date_from","maxDate");
});

const reportName = document.querySelector("#report_name");
const dateFrom = document.querySelector("#date_from");
const dateTo = document.querySelector("#date_to");
const source = document.querySelector("#source");

var chartCanvas = document.getElementById("chart-canvas");
var ctx = chartCanvas.getContext("2d");

document.querySelector("#generate_rpt_btn").addEventListener("click",() => 
{
    if (reportName.value == "") {
        displayError("Report Name is Required");
    }
    else if(source.value == "") {
        displayError("Source is Required");
    }
    else {
        switch (reportName.value) {
            case 'total_gender':
                totalNumberOfGender();
            break;
            
            case 'total_gender_pref':
                totalNumberOfGenderPreferences();
            break;

            case 'gender_by_month':
            
            break;

            case 'gender_pref_by_month':
            
            break;
        }
    }
});

const formData = () => {
    return {
        report_name: reportName.value,
        source: source.value,
        date_from: dateFrom.value,
        date_to: dateTo.value
    };
};

const chartData = (res,lbl,dt,clr = []) => {

    let labels = [],
        data = [],
        colors = clr,
        numberOfColors = 0;
    
    for (let i in res) {
        labels.push(res[i][lbl]);
        data.push(res[i][dt]);
        numberOfColors ++;
    }

    let distinctColors = colors.concat(uniqueColors(numberOfColors,0.8));

    return {
        labels: labels,
        data: data,
        colors: distinctColors
    }
};

const reportImage = (report) => {

    let baseURL = "/miaa/assets/images/gender/";

    switch (report) 
    {
        case "total_gender":
            $("#report-logo").attr("src", baseURL + "gender.svg");
        break;

        case "total_gender_pref":
            $("#report-logo").attr("src", baseURL + "gender-pref.png");
        break;

        case "gender_by_month":
            $("#report-logo").attr("src", baseURL + "gender-by-birth-month.png");
        break;

        case "gender_pref_by_month":
            $("#report-logo").attr("src", baseURL + "gender-pref-by-birth-month.png");
        break;
    }
};

function totalNumberOfGender(res)
{   
    $.ajax({
        type: "POST",
        url: "/miaa/module/gender/reports/generate_rpt_server.php",
        data: formData(),
        dataType: "JSON",
        success: (res) => {

            $("#rpt-container").show();

            reportImage(reportName.value);

            let chart_data = chartData(res,'gender','total',['#F53364','#4B77BE']);

            totalNumberPerGenderChart(chart_data);
            
            createTableReport(chart_data,'gender')
        }
    });

    chart.destroy();
}

function totalNumberOfGenderPreferences()
{
    $.ajax({
        type: "POST",
        url: "/miaa/module/gender/reports/generate_rpt_server.php",
        data: formData(),
        dataType: "JSON",
        success: (res) => {
            
            $("#rpt-container").show();
            
            reportImage(reportName.value);

            let chart_data = chartData(res,'genderdesc','total');

            defaultBarChart(chart_data);
            
            createTableReport(chart_data,'gender preference');
        }
    });

    chart.destroy();
}

function defaultPieChart(labels,data,colors)
{   
    let total = arraySum(data);

    chart = new Chart(ctx,{
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'top',
                labels: {
                    generateLabels: customChartLegend,
                    fontColor: '#383838',
                    fontStyle: 600,
                    fontSize: 14 
                }
            },
            tooltips: {
                mode: 'index',
                callbacks: {
                    afterLabel: function(tooltipItem, data) 
                    {
                        let percent = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] / total * 100;
                        
                        return percent.toFixed(2) + '%';
                    }
                }
            },
            plugins: {
                labels: [
                    {
                        render: 'percentage',
                        fontColor: '#FFF',
                        fontSize: 20
                    },
                    {
                        render: function (args) {
                            // args will be something like:
                            // { label: 'Label', value: 123, percentage: 50, index: 0, dataset: {...} }
                            return args.label + " : " + args.value ;
                        },
                        position: 'outside',
                        textMargin: 10,
                        fontSize: 20
                    }
                ]
            }
        }
    });
}

function defaultBarChart(chart_data)
{   
    let yAxesticks = [];

    console.log(chart_data.labels);

    chart = new Chart(ctx,{
        type: 'bar',
        data: {
            labels: chart_data.labels,
            datasets: [{
                data: chart_data.data,
                backgroundColor: chart_data.colors,
                borderColor: '#673AB7',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'top',
                labels: {
                    generateLabels: customChartLegend,
                    fontColor: '#383838',
                    fontStyle: 600,
                    fontSize: 13
                }
            },
            scales: {
                yAxes : [{
                    ticks : {
                        fontSize: 14,
                        beginAtZero : true,
                        callback : function(value,index,values) {
                            yAxesticks = values;
                            return value;
                        }
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontSize: 13
                    }
                }]
            },
            plugins: {
                labels: {
                    render: function (args) {  
                        let max = yAxesticks[0];

                        return Math.round(args.value * 100 / max)+"%";
                    },
                    fontSize: 12
                }
            }
        }
    });
}

function createTableReport(chart_data,th1,th2 = 'total')
{
    let labels = chart_data.labels;
    let data = chart_data.data;
    let sum = 0;
    
    $('.tbl-data').val(JSON.stringify(chart_data));
    $('.tbl-head').val(th1.toUpperCase());

    let tableHeader =`
        <tr>
            <th>${th1.toUpperCase()}</th>
            <th>${th2.toUpperCase()}</th>
        </tr>`;

    let tableRow = '';


    for (let i = 0; i < labels.length; i++) 
    {
        tableRow +=`
        <tr>
            <td>${labels[i]}</td>
            <td>${data[i]}</td>
        </tr>`;
        sum += parseInt(data[i],10);
    }

    tableRow +=` 
        <tr>
            <td></td>
            <td class="grand-total"><strong>GRAND TOTAL: ${sum}</strong></td>
        </tr>
    `;  

    $('#report-tbl thead').html(tableHeader);
    $('#report-tbl tbody').html(tableRow);
}

function totalNumberPerGenderChart(chart_data)
{
    let total = arraySum(chart_data.data);

    chart = new Chart(ctx,{
        type: 'pie',
        data: {
            labels: chart_data.labels,
            datasets: [{
                data: chart_data.data,
                backgroundColor: chart_data.colors
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
            },
            title: {
                display: true,
                text: 'TOTAL NUMBER PER GENDER CHART',
                fontColor: '#212121',
                fontSize: 20
            },
            tooltips: {
                mode: 'index',
                callbacks: {
                    afterLabel: function(tooltipItem, data) 
                    {
                        let percent = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] / total * 100;
                        
                        return Math.round(percent) + '%';
                    }
                }
            },
            plugins: {
                labels: [
                    {
                        render: 'percentage',
                        fontColor: '#FFF',
                        fontSize: 18
                    },
                    {
                        render: function (args) {
                            return args.label + " : " + args.value ;
                        },
                        position: 'outside',
                        textMargin: 6,
                        fontSize: 18
                    }
                ]
            }
        }
    });
}

</script>