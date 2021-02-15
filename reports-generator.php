<?php 

require_once 'core/init.php';
require 'includes/styles.php';
require 'includes/navbar.php';

auth_guard();

use Gender\Classes\References\Settings\Source;

use Gender\Classes\Category;
use Gender\Classes\UserAudit;

$source = new Source;
$category = new Category;
$user_audit = new UserAudit;

$user_audit->log(
    8, // Menu ID - Reports Generator
    12 // Action ID - View
);

?>

<style type="text/css">

.chart-container, .survey-chart-container {
    position: relative;
    margin: auto;
    height: 80vh;
    width: 100%;
}

.rpt-container {
    display: none;
}

.no-height {
    height: 0 !important;
}

.chart-panel-container {
    height: 95vh;
    overflow-y: auto;
}

#survey_category {
    display: none;
}

</style>

<!-- Css for loader  -->
<link rel="stylesheet" href="<?=CSS;?>css-loader-master/dist/css-loader.css">

<!-- Css Loader Tag -->
<div class="loader loader-default" data-text="This will take some time to load, Sorry :-("></div>

<div class="container-fluid">

    <form action="<?=MODULE_URL;?>reports/print_report.php" method="POST" target="_blank">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">
                    <i class="fas fa-chart-pie my-green"></i> Reports Generator
                </div>
                
                <div class="panel-body my-panel-body">
                        
                    <div class="form-inline">

                        <input type="hidden" name="rpt_title" id="rpt-title">
                        <input type="hidden" name="tbl_header" id="tbl-header">
                        <input type="hidden" name="tbl_row" id="tbl-row">
                        <input type="hidden" name="tbl_row_total" id="tbl-row-total">
                        <input type="hidden" name="chart_base64" class="chart-base64">

                        <div class="form-group">
                            <select name="source" id="source" class="form-control mr-3" required>
                                <option value="">Select Source</option>
                                <?php foreach ($source->list() as $src_data) :?>
                                <option value="<?=$src_data->id;?>"><?=$src_data->sourcedesc;?></option>
                                <?php endforeach;?>
                                <option value="all">Internal/External</option>
                            </select>                        
                        </div>

                        <div class="form-group">
                            <select name="report_name" id="report_name" class="form-control mr-3" required>
                                <option value="">Select Report Name</option>
                                <option value="gender">Gender</option>
                                <option value="gender_pref">Gender Preferences</option>  
                                <option value="survey_analysis">Survey Analysis</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <select name="survey_category" id="survey_category" class="form-control mr-3">
                                <option value="all">All Survey Category</option>
                                <?php foreach ($category->list() as $categ_data) :?>
                                    <option value="<?=$categ_data->id;?>"><?=ucwords($categ_data->categdesc);?></option>
                                <?php endforeach;?>
                            </select>                        
                        </div> 
                        
                        <div class="form-group">
                            <select name="category" id="category" class="form-control mr-3">
                                <option value="">Category List</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control mr-3" name="date_from" id="date_from" autocomplete="off" placeholder="Date From">
                        </div>
                        
                        <div class="form-group">
                            <input type="text" class="form-control mr-3" name="date_to" id="date_to" autocomplete="off" placeholder="Date To">
                        </div>
                        
                        <div class="form-group">
                            <button type="button" name="filter" id="filter" class="btn my-btn mr-3">
                            	<i class="fas fa-filter gamboge"></i> Filter
                            </button>

                            <button type="submit" name="print" id="print" class="btn my-btn">
                                <i class="fa fa-print medium-crimson" aria-hidden="true"></i> Print Report
                            </button>
                        </div>
                      
                    </div>
                
                </div>    
            </div>
        
        </div>

        <div class="col-md-12 rpt-container">
        
            <div class="panel panel-default chart-panel-container">

                <div class="panel-heading">
                    <i class="fas fa-chart-line radical-red"></i> <span class="rpt-chart-title">Report Title</span> <span>Chart</span>
                </div>

                <div class="panel-body" id="chart-panel">
        
                    <div class="chart-container" id="chart-canvas-container">
                        <canvas id="chart-canvas"></canvas>
                    </div>

                </div>

            </div>

            <div class="panel panel-default">

                <div class="panel-heading">
                    <i class="fas fa-table steel-blue"></i> <span class="rpt-chart-title">Report Title</span> <span>Table</span>
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

        </div>

    </form>

</div>

<?php 
    include 'includes/footer.php';
    include 'includes/scripts.php';
?>
<script src="<?=JS;?>js-bootstrap-executive-charts/Chart.min.js"></script>
<script src="<?=JS;?>html2canvas.min.js"></script>
<script src="<?=JS;?>chartjs-plugin-labels-master/src/chartjs-plugin-labels.js"></script>
<script src="<?=JS;?>distinct-colors-master/dist/distinct-colors.min.js"></script>
<script type="text/javascript">

$(document).ready(function () {   
    dateRange("date_from","date_to","minDate");
    dateRange("date_to","date_from","maxDate");
});
    
const source = document.getElementById("source");

const reportName = document.getElementById("report_name");

const category = document.getElementById("category");

const dateFrom = document.getElementById("date_from");

const dateTo = document.getElementById("date_to");

const filter = document.getElementById("filter");

const print = document.getElementById("print");

var chartCanvas = document.getElementById("chart-canvas");

var ctx = chartCanvas.getContext("2d");

/* Default option for Line Chart */ 
const defaultLineChartOption = (title) => {

    return {
        maintainAspectRatio: false,
        title: {
            display: true,
            text: title,
            fontSize: 21,
            padding: 20
        },
        tooltips: {
            mode: 'index',
            intersect: false
        },
        elements: {
            line: {
                tension: 0 // disables bezier curves
            }
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    userCallback: function(label, index, labels) {
                         // When the floored value is the same as the value we have a whole number
                         // To remove decimal in y axes
                        if (Math.floor(label) === label) {
                             return label;
                        }
                    }
                }
            }]
        },
        legend: {
            display: true,
            position: 'bottom',
            labels: {
                fontColor: '#383838',
                fontSize: 16
            }
        }
    }
}

/* Default option for Bar Chart */
const defaultBarChartOption = (title,stacked,plugins) => {

    return {
        maintainAspectRatio: false,
        title: {
            display: true,
            text: title,
            fontSize: 21,
            padding: 20
        },
        tooltips: {
            mode: 'index',
            intersect: false
        },
        scales: {
            yAxes: [{
                stacked: stacked,
                ticks: {
                    beginAtZero: true,
                    userCallback: function(label, index, labels) {
                         // When the floored value is the same as the value we have a whole number
                         // To remove decimal in y axes
                        if (Math.floor(label) === label) {
                             return label;
                        }
                    }
                }
            }],
            xAxes: [{
                stacked: stacked
            }]
        },
        legend: {
            display: true,
            position: 'bottom',
            labels: {
                fontColor: '#383838',
                fontSize: 16
            }
        },
        plugins: plugins
    }
}

/* Default option for Pie Chart */
const defaultPieChartOption = (title,callbacks,plugins) => {

    return {
        maintainAspectRatio: false,
        title: {
            display: true,
            text: title,
            fontSize: 21
        },
        legend: {
            display: true,
            position: 'bottom',
            labels: {
                generateLabels: customChartLegend,
                fontColor: '#383838',
                fontSize: 18 
            }
        },
        tooltips: {
            mode: 'index',
            intersect: false,
            callbacks: callbacks
        },
        plugins: plugins
    }
}

/* Get the table labels of organization */
function orgLabel() 
{
    if (category.value == "office") { return "OFFICE"; }
    
    if (category.value == 'department') { return "DEPT"; }
    
    if (category.value == 'division') { return "DIVI"; }
}

/* Hide the report container if response is empty*/
function checkResponse(res)
{
    if (res == "") {
        $(".rpt-container").css("display", "none");
        displayError("No Data Found");
    }
    else {
        $(".rpt-container").css("display", "block");
    }
}

/**
 * Remove all the Survey Chart Container 
 * Remove the class no-height in chart-container
 */
function removeSurveyChartContainer()
{
    $(".survey-chart-container").remove();
    $(".chart-container").removeClass("no-height");
}

// Report Form Data
const formData = () => {
    return {
        source : source.value,        
        report : reportName.value,
        category : category.value,
        date_from : dateFrom.value,
        date_to : dateTo.value
    };
};

// Internal - Gender,Gender Preference,Survey Analysis - All,Per Office,Per Department,Per Division
// External - Gender,Gender Preference,Survey Analysis - All,Concessionaire,Passenger,Visitor/Walk In 
// Internal/External - Gender,Gender Preference,Survey Analysis - All 
source.addEventListener("change", () => {

    let output = "";

    switch (source.value) {
        
        case '1':

            output += `
                <option value="">Category List</option>
                <option value="all" selected>All</option>
                <option value="office">Per Office</option>
                <option value="department">Per Department</option>
                <option value="division">Per Division</option>
            `;

            category.innerHTML = output;

        break;

        case '2':
            
            $.ajax({
                url: '/miaa/module/gender/lib/get_user_types_by_source.php',
                type: 'POST',
                dataType: 'JSON',
                data: { source: source.value},
                success: function(res) {

                    output += `<option value="">Category List</option>
                               <option value="all" selected>All</option>`;
                    
                    for (i in res) {    
                        output += `<option value="${res[i].id}">${res[i].user_typedesc}</option>`;
                    }   

                    category.innerHTML = output;

                }
            });

        break;

        case 'all':

            output += `
                <option value="">Category List</option>
                <option value="all" selected>All</option>
            `;

            category.innerHTML = output;

        break;
    }

});


/* Show survey category when report name is survey analysis else remove */
reportName.addEventListener("change", () => {

    switch (reportName.value) {

        case 'survey_analysis':

            $("#survey_category").css("display", "block");

        break;

        default:
            $("#survey_category").css("display", "none");
        break;
    }

});


/*When Filter is clicked*/
filter.addEventListener("click", () => {

    if (source.value == "") {
        displayError("Source is required");
    }
    else if (reportName.value == "") {
        displayError("Report Name is required");
    }
    else if (category.value == "") {
        displayError("Category is required");
    }
    else if (dateFrom.value == "") {
        displayError("Date From is required");
    }
    else if (dateTo.value == "") {
        displayError("Date To is required");
    }
    else {

        switch (reportName.value) {

            case 'gender':

                switch (category.value) {

                    case 'all': genderReport(); break;

                    case 'office': genderPerOfficeReport(); break;

                    case 'department': genderPerOrganizationReport(); break;

                    case 'division': genderPerOrganizationReport(); break;
                }


                /** 
                 * If report name is Gender 
                 * If source is External
                 * If category is Passenger/Concessionaire/Visitor/Walk In 
                 */
                if (source.value == '2' && category.value != 'all') {
                    genderByUserTypeReport();
                }   

            break;

            case 'gender_pref':

                switch (category.value) {
                    
                    case 'all': genderPreferenceReport(); break;

                    case 'office': genderPreferencePerOrganizationReport(); break;

                    case 'department': genderPreferencePerOrganizationReport(); break;

                    case 'division': genderPreferencePerOrganizationReport(); break;  
                        
                }


                /** 
                 * If report name is Gender 
                 * If source is External
                 * If category is Passenger/Concessionaire/Visitor/Walk In 
                 */
                if (source.value == '2' && category.value != 'all') {
                    genderPreferenceByUserTypeReport();
                } 

            break;

            case 'survey_analysis':

                switch (category.value) {

                    case 'all': 

                       $(".loader").addClass("is-active");
                
                        surveyAnalysisReport(); 

                    break;

                    case 'office':

                        surveyAnalysisPerOrganizationReport();

                    break;

                    case 'department':


                    break;

                    case 'division':


                    break;

                }

            break;
        }
    }
});


/**
 * Create Base64 Chart Image 
 * For Chart Printing
 */ 
function createBase64Chart()
{
    setTimeout(() => {
        html2canvas(chartCanvas).then(function(canvas) {
            var base64URL = canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream');
            $('.chart-base64').val(base64URL);
        });
    }, 100);
}


// Add createBase64Chart Function to Chart Js plugin
var plugin = {
    id: 'createBase64',
    afterRender: function(chart,option) {
        if (!chart.$rendered) {
            chart.$rendered = true;
            createBase64Chart();
        }
    }
};

// Register Chart Js Plugin Globally
Chart.plugins.register(plugin);


/*-- Start of Gender Report  --*/ 

/**
 * This will generate the following reports:
 * Gender All (Internal) Chart and Table
 * Gender All (External) Chart and Table
 * Gender All (Internal/External) Chart and Table
 */
function genderReport()
{
    $.ajax({
        url: '/miaa/module/gender/lib/filter_reports.php',
        type: 'POST',
        dataType: 'JSON',
        data: formData(),
        success: function(res) {

            checkResponse(res);

            renderGenderChart(res);
            
            createGenderTable(res);
        }
    });

    chart.destroy();
}


/**
 * Gender All (Internal) Chart 
 * Gender All (External) Chart 
 * Gender All (Internal/External) Chart 
 */
function renderGenderChart(res)
{
    removeSurveyChartContainer();

    let labels = [];
    let dt = [];
    let title = "Total Number of Gender (" + $("#source option:selected").text() + ")";

    $(".rpt-chart-title").text(title);
    $("#rpt-title").val(title);

    for (i in res) {
        labels.push(res[i].GENDER);
        dt.push(res[i].TOTAL);
    }

    let callbacks = {
        afterLabel: function(tooltipItem, data) 
        {
            let percent = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] / arraySum(dt) * 100;
            
            return percent.toFixed(0) + '%';
        }
    };

    let plugins = {
        labels: [
            {
                render: 'percentage',
                fontColor: '#FFF',
                fontSize: 20
            }
        ]
    };
                
    chart = new Chart(ctx,{
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: dt,
                backgroundColor: ['#F53364','#4B77BE']
            }]
        },
        options: defaultPieChartOption(title,callbacks,plugins)
    });
}


/**
 * Gender All (Internal) Table 
 * Gender All (External) Table 
 * Gender All (Internal/External) Table 
 */
function createGenderTable(res)
{
    let tableHeader =`
        <tr>
            <th class="text-center">GENDER</th>
            <th class="text-center">SUB TOTAL</th>
        </tr>`;

    let tableBody = "";
    let sum = 0;

    for (i in res) {
        tableBody +=`
        <tr class="text-center">
            <td>${res[i].GENDER}</td>
            <td>${res[i].TOTAL}</td>
        </tr>`;
        sum += parseInt(res[i].TOTAL);
    }

    tableBody +=` 
        <tr class="text-center fw-6 tr-pd">
            <td>GRAND TOTAL</td>
            <td>${sum}</td>
        </tr>
    `;

    $("#tbl-header").val(JSON.stringify(["GENDER","SUB TOTAL"]));
    $("#tbl-row").val(JSON.stringify(res));
    $("#tbl-row-total").val(JSON.stringify(["GRAND TOTAL",sum]));

    $('#report-tbl thead').html(tableHeader);
    $('#report-tbl tbody').html(tableBody);
}


/* This will generate Gender Per Office Chart and Table */
function genderPerOfficeReport()
{
    $.ajax({
        url: '/miaa/module/gender/lib/filter_reports.php',
        type: 'POST',
        dataType: 'JSON',
        data: formData(),
        success: function(res) {

            checkResponse(res);

            renderGenderPerOfficeChart(res);

            createGenderPerOrganizationTable(res);
        }
    });

    chart.destroy();
}


/* Gender Per Office Chart*/
function renderGenderPerOfficeChart(res)
{
    removeSurveyChartContainer();

    let labels = [];
    let maleData = [];
    let femaleData = [];
    let title = "Total Number of Gender " + $("#category option:selected").text();

    $(".rpt-chart-title").text(title);
    $("#rpt-title").val(title);

    for (i in res) {
        labels.push(res[i].OFFICE);
        maleData.push(res[i].MALE_TOTAL);        
        femaleData.push(res[i].FEMALE_TOTAL);        
    }

    chart = new Chart(ctx,{
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: "Male",
                backgroundColor: "#303f9f",
                data: maleData
            },{
                label: "Female",
                backgroundColor: "#ff1744",
                data: femaleData
            }]
        },
        options: defaultBarChartOption(title,false,{
            labels: [
                {
                    render: 'value'
                }
            ]
        })   
    });
}


/**
 * This will generate the following reports:
 * Gender Per Department Chart and Table
 * Gender Per Division Chart and Table
 */
function genderPerOrganizationReport()
{
    $.ajax({
        url: '/miaa/module/gender/lib/filter_reports.php',
        type: 'POST',
        dataType: 'JSON',
        data: formData(),
        success: function(res) {

            checkResponse(res);

            renderGenderPerOrganizationChart(res);

            createGenderPerOrganizationTable(res);
        }
    });

    chart.destroy();
}


/**
 * Gender Per Office Chart 
 * Gender Per Department Chart 
 */
function renderGenderPerOrganizationChart(res)
{
    removeSurveyChartContainer();

    let labels = [];
    let maleData = [];
    let femaleData = [];
    let title = "Total Number of Gender " + $("#category option:selected").text();

    $(".rpt-chart-title").text(title);
    $("#rpt-title").val(title);

    for (i in res) {
        labels.push(res[i][orgLabel()]);
        maleData.push(res[i].MALE_TOTAL);        
        femaleData.push(res[i].FEMALE_TOTAL);        
    }

    chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: "Male",
                data: maleData,
                borderColor: '#303f9f',
                borderWidth: 3,
                backgroundColor: 'rgba(255,255,255, 0)'
            },{
                label: "Female",
                data: femaleData,
                borderColor: '#ff1744',
                borderWidth: 3,
                backgroundColor: 'rgba(255,255,255, 0)'
            }]
        },
        options: defaultLineChartOption(title)
    });
}


/** 
 * Gender Per Office Table
 * Gender Per Department Table
 * Gender Per Division Table
 */
function createGenderPerOrganizationTable(res)
{
    let tableHeader =`
        <tr>
            <th class="text-center">${category.value.toUpperCase()+"S"}</th>
            <th class="text-center">MALE</th>
            <th class="text-center">FEMALE</th>
            <th class="text-center">SUB TOTAL</th>
        </tr>`;

    let tableBody = "";
    let maleTotal = 0
    let femaleTotal = 0;
    let subTotal = 0;
    let grandTotal = 0;

    for (i in res) {
        tableBody +=`
        <tr class="text-center">
            <td>${res[i][orgLabel()]}</td>
            <td>${res[i].MALE_TOTAL}</td>
            <td>${res[i].FEMALE_TOTAL}</td>
            <td>${subTotal = parseInt(res[i].MALE_TOTAL) + parseInt(res[i].FEMALE_TOTAL)}</td>
        </tr>`;
        maleTotal += parseInt(res[i].MALE_TOTAL);
        femaleTotal += parseInt(res[i].FEMALE_TOTAL);
        grandTotal += parseInt(subTotal);
    }

    tableBody +=` 
        <tr class="text-center fw-6 tr-pd">
            <td>GRAND TOTAL</td>
            <td>${maleTotal}</td>
            <td>${femaleTotal}</td>
            <td>${grandTotal}</td>
        </tr>
    `;

    $("#tbl-header").val(JSON.stringify([category.value.toUpperCase()+"S","MALE","FEMALE","SUB TOTAL"]));
    $("#tbl-row").val(JSON.stringify(res));
    $("#tbl-row-total").val(JSON.stringify(["GRAND TOTAL",maleTotal,femaleTotal,grandTotal]));  

    $('#report-tbl thead').html(tableHeader);
    $('#report-tbl tbody').html(tableBody);
}


/** 
 * External Gender (Passenger) Chart and Table
 * External Gender (Concessionaire) Chart and Table
 * External Gender (Visitor/Walk In) Chart and Table
 */
function genderByUserTypeReport()
{
    $.ajax({
        url: '/miaa/module/gender/lib/filter_reports.php',
        type: 'POST',
        dataType: 'JSON',
        data: formData(),
        success: function(res) {

            checkResponse(res);

            renderGenderByUserTypeChart(res);

            createGenderByUserTypeTable(res);
        }
    });

    chart.destroy();
}

/**
 * External Gender (Passenger) Chart 
 * External Gender (Concessionaire) Chart 
 * External Gender (Visitor/Walk In) Chart 
 */
function renderGenderByUserTypeChart(res)
{
    removeSurveyChartContainer();

    let labels = [];
    let dt = [];
    let title = "Total Number of Gender (" + $("#category option:selected").text() + ")";

    $(".rpt-chart-title").text(title);
    $("#rpt-title").val(title);

    for (i in res) {
        labels.push(res[i].GENDER);
        dt.push(res[i].TOTAL);
    }

    let callbacks = {
        afterLabel: function(tooltipItem, data) 
        {
            let percent = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] / arraySum(dt) * 100;
            
            return percent.toFixed(0) + '%';
        }
    };

    let plugins = {
        labels: [
            {
                render: 'percentage',
                fontColor: '#FFF',
                fontSize: 20
            }
        ]
    };

    chart = new Chart(ctx,{
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: dt,
                backgroundColor: ['#F53364','#4B77BE']
            }]
        },
        options: defaultPieChartOption(title,callbacks,plugins)
    });
}


/**
 * External Gender (Passenger) Table 
 * External Gender (Concessionaire) Table 
 * External Gender (Visitor/Walk In) Table 
 */
function createGenderByUserTypeTable(res)
{
    let tableHeader =`
        <tr>
            <th class="text-center">GENDER</th>
            <th class="text-center">SUB TOTAL</th>
        </tr>`;

    let tableBody = "";
    let sum = 0;

    for (i in res) {
        tableBody +=`
        <tr class="text-center">
            <td>${res[i].GENDER}</td>
            <td>${res[i].TOTAL}</td>
        </tr>`;
        sum += parseInt(res[i].TOTAL);
    }

    tableBody +=` 
        <tr class="text-center fw-6 tr-pd">
            <td>GRAND TOTAL</td>
            <td>${sum}</td>
        </tr>
    `;

    $("#tbl-header").val(JSON.stringify(["GENDER","SUB TOTAL"]));
    $("#tbl-row").val(JSON.stringify(res));
    $("#tbl-row-total").val(JSON.stringify(["GRAND TOTAL",sum]));    

    $('#report-tbl thead').html(tableHeader);
    $('#report-tbl tbody').html(tableBody);
}

/*-- End of Gender Report  --*/ 


/*-- Start of Gender Preference Report  --*/ 


/**
 * This will generate the following reports:
 * Gender Preference All (Internal) Chart and Table
 * Gender Preference All (External) Chart and Table
 * Gender Preference All (Internal/External) Chart and Table
 */
function genderPreferenceReport()
{
    $.ajax({
        url: '/miaa/module/gender/lib/filter_reports.php',
        type: 'POST',
        dataType: 'JSON',
        data: formData(),
        success: function(res) {

            checkResponse(res);

            renderGenderPreferenceChart(res);

            createGenderPreferenceTable(res);
        }
    });

    chart.destroy();
}


/**
 * Gender Preference All (Internal) Chart 
 * Gender Preference All (External) Chart 
 * Gender Preference All (Internal/External) Chart 
 */
function renderGenderPreferenceChart(res)
{
    removeSurveyChartContainer();

    let labels = [];
    let data = []; 
    let colorNum = 0;
    let yAxesticks = [];

    let title = "Total Number of Gender Preference (" + $("#source option:selected").text() + ")";

    $(".rpt-chart-title").text(title);
    $("#rpt-title").val(title);

    for (i in res) {
        labels.push(res[i].GENDERPREF);
        data.push(res[i].TOTAL);
        colorNum++;
    }

    chart = new Chart(ctx,{
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: uniqueColors(colorNum)
            }]
        },
        options: {
            maintainAspectRatio: false,
            title: {
                display: true,
                text: title,
                fontSize: 21,
                padding: 20
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    generateLabels: customChartLegend,
                    fontColor: '#383838',
                    fontStyle: 600,
                    fontSize: 16
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
                        fontSize: 14
                    }
                }]
            },
            plugins: {
                labels: {
                    render: function (args) {  
                        let max = yAxesticks[0];

                        return Math.round(args.value * 100 / max)+"%";
                    }
                }
            }
        }
    });
}


/**
 * Gender Preference All (Internal) Table 
 * Gender Preference All (External) Table 
 * Gender Preference All (Internal/External) Table 
 */
function createGenderPreferenceTable(res)
{
    let tableHeader =`
        <tr>
            <th class="text-center">GENDER PREFERENCES</th>
            <th class="text-center">SUB TOTAL</th>
        </tr>`;

    let tableBody = "";
    let sum = 0;

    for (i in res) {
        tableBody +=`
        <tr class="text-center">
            <td>${res[i].GENDERPREF}</td>
            <td>${res[i].TOTAL}</td>
        </tr>`;
        sum += parseInt(res[i].TOTAL);
    }

    tableBody +=` 
        <tr class="text-center fw-6 tr-pd">
            <td>GRAND TOTAL</td>
            <td>${sum}</td>
        </tr>
    `;

    $("#tbl-header").val(JSON.stringify(["GENDER PREFERENCES","SUB TOTAL"]));
    $("#tbl-row").val(JSON.stringify(res));
    $("#tbl-row-total").val(JSON.stringify(["GRAND TOTAL",sum]));  

    $('#report-tbl thead').html(tableHeader);
    $('#report-tbl tbody').html(tableBody);
}


/**
 * This will generate the following reports: 
 * Gender Preference Per Office Chart and Table
 * Gender Preference Per Department Chart and Table
 * Gender Preference Per Division Chart and Table
 */
function genderPreferencePerOrganizationReport()
{
    $.ajax({
        url: '/miaa/module/gender/lib/filter_reports.php',
        type: 'POST',
        dataType: 'JSON',
        data: formData(),
        success: function(res) {

            checkResponse(res);

            renderGenderPreferencePerOrganizationChart(res);

            createGenderPreferencePerOrganizationTable(res);
        }
    });

    chart.destroy();
}


/** 
 * Gender Preference Per Office Chart
 * Gender Preference Per Department Chart
 * Gender Preference Per Division Chart
*/
function renderGenderPreferencePerOrganizationChart(res)
{
    removeSurveyChartContainer();

    let labels = [];
    let masculineData = [];
    let feminineData = [];
    let gayData = [];
    let lesbianData = [];
    let bisexualData = [];
    let transgenderData = [];
    let queerData = [];
    let questioningData = [];
    let intersexData = [];
    let asexualData = [];
    let allyData = [];
    let pansexualData = [];
    let title = "Total Number of Gender Preference " + $("#category option:selected").text();

    $(".rpt-chart-title").text(title);
    $("#rpt-title").val(title);

    for (i in res) {
        labels.push(res[i][orgLabel()]);
        masculineData.push(res[i].MASCULINE_TOTAL);        
        feminineData.push(res[i].FEMININE_TOTAL);
        gayData.push(res[i].GAY_TOTAL);        
        lesbianData.push(res[i].LESBIAN_TOTAL);
        bisexualData.push(res[i].BI_TOTAL);
        transgenderData.push(res[i].TRANS_TOTAL);
        queerData.push(res[i].QUEER_TOTAL);
        questioningData.push(res[i].QUESTIONING_TOTAL);
        intersexData.push(res[i].INTERSEX_TOTAL);
        asexualData.push(res[i].ASEXUAL_TOTAL);
        allyData.push(res[i].ALLY_TOTAL);
        pansexualData.push(res[i].PANSEXUAL_TOTAL);
    }

    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: "Masculine",
                data: masculineData,
                backgroundColor: "rgb(58,23,35)"
            },{
                label: "Feminine",
                data: feminineData,
                backgroundColor: "rgb(112,187,85)"
            },{
                label: "Gay",
                data: gayData,
                backgroundColor: "rgb(64,74,169)"
            },{
                label: "Lesbian",
                data: lesbianData,
                backgroundColor: "rgb(223,173,106)"
            },{
                label: "Bisexual",
                data: bisexualData,
                backgroundColor: "rgb(216,75,149)"
            },{
                label: "Transgender",
                data: transgenderData,
                backgroundColor: "rgb(115,213,222)"
            },{
                label: "Queer",
                data: queerData,
                backgroundColor: "rgb(150,50,29)"
            },{
                label: "Questioning",
                data: questioningData,
                backgroundColor: "rgb(64,101,112)"
            },{
                label: "Intersex",
                data: intersexData,
                backgroundColor: "rgb(222,184,217)"
            },{
                label: "Asexual",
                data: asexualData,
                backgroundColor: "rgb(31,55,22)"
            },{
                label: "Ally",
                data: allyData,
                backgroundColor: "rgb(203,163,159)"
            },{
                label: "Pansexual",
                data: pansexualData,
                backgroundColor: "rgb(206, 196, 172)"
            }]
        },
        /**
         * First Param = Chart Title
         * Second Param = stacked settings
         * Third Param = custom plugins 
         */
        options: defaultBarChartOption(title,true,{
            labels: false
        })
    });
}


/** 
 * Gender Preference Per Office Table
 * Gender Preference Per Department Table
 * Gender Preference Per Division Table
 */
function createGenderPreferencePerOrganizationTable(res)
{

    let tableHeader =`
        <tr>
            <th class="text-center">${category.value.toUpperCase()+"S"}</th>
            <th class="text-center">MASCULINE</th>
            <th class="text-center">FEMININE</th>
            <th class="text-center">GAY</th>
            <th class="text-center">LESBIAN</th>
            <th class="text-center">BISEXUAL</th>
            <th class="text-center">TRANSGENDER</th>
            <th class="text-center">QUEER</th>
            <th class="text-center">QUESTIONING</th>
            <th class="text-center">INTERSEX</th>
            <th class="text-center">ASEXUAL</th>
            <th class="text-center">ALLY</th>
            <th class="text-center">PANSEXUAL</th>
            <th class="text-center">SUB TOTAL</th>
        </tr>`;

    let tableBody = "";
    let masculineTotal = 0;
    let feminineTotal = 0;
    let gayTotal = 0;
    let lesbianTotal = 0;
    let bisexualTotal = 0;
    let transTotal = 0;
    let queerTotal = 0;
    let questioningTotal = 0;
    let intersexTotal = 0;
    let asexualTotal = 0;
    let allyTotal = 0;
    let pansexualTotal = 0;
    let subTotal = 0;
    let grandTotal = 0;

  
    for (i in res) {
        tableBody +=`
        <tr class="text-center">
            <td>${res[i][orgLabel()]}</td>
            <td>${res[i].MASCULINE_TOTAL}</td>
            <td>${res[i].FEMININE_TOTAL}</td>
            <td>${res[i].GAY_TOTAL}</td>
            <td>${res[i].LESBIAN_TOTAL}</td>
            <td>${res[i].BI_TOTAL}</td>
            <td>${res[i].TRANS_TOTAL}</td>
            <td>${res[i].QUEER_TOTAL}</td>
            <td>${res[i].QUESTIONING_TOTAL}</td>
            <td>${res[i].INTERSEX_TOTAL}</td>
            <td>${res[i].ASEXUAL_TOTAL}</td>
            <td>${res[i].ALLY_TOTAL}</td>
            <td>${res[i].PANSEXUAL_TOTAL}</td>
            <td>${
                    subTotal = parseInt(res[i].MASCULINE_TOTAL) + parseInt(res[i].FEMININE_TOTAL) + parseInt(res[i].GAY_TOTAL) + 
                               parseInt(res[i].LESBIAN_TOTAL) + parseInt(res[i].BI_TOTAL) + parseInt(res[i].TRANS_TOTAL) + parseInt(res[i].QUEER_TOTAL) + 
                               parseInt(res[i].QUESTIONING_TOTAL) + parseInt(res[i].INTERSEX_TOTAL) + parseInt(res[i].ASEXUAL_TOTAL) + 
                               parseInt(res[i].ALLY_TOTAL) + parseInt(res[i].PANSEXUAL_TOTAL)
                }
            </td>
        </tr>`;
        masculineTotal += parseInt(res[i].MASCULINE_TOTAL);
        feminineTotal += parseInt(res[i].FEMININE_TOTAL);
        gayTotal += parseInt(res[i].GAY_TOTAL);
        lesbianTotal += parseInt(res[i].LESBIAN_TOTAL);
        bisexualTotal += parseInt(res[i].BI_TOTAL);
        transTotal += parseInt(res[i].TRANS_TOTAL);
        queerTotal += parseInt(res[i].QUEER_TOTAL);
        questioningTotal += parseInt(res[i].QUESTIONING_TOTAL);
        intersexTotal += parseInt(res[i].INTERSEX_TOTAL);
        asexualTotal += parseInt(res[i].ASEXUAL_TOTAL);
        allyTotal += parseInt(res[i].ALLY_TOTAL);
        pansexualTotal += parseInt(res[i].PANSEXUAL_TOTAL);
        grandTotal += parseInt(subTotal);
    }

    tableBody +=` 
        <tr class="text-center fw-6 tr-pd">
            <td>GRAND TOTAL</td>
            <td>${masculineTotal}</td>
            <td>${feminineTotal}</td>
            <td>${gayTotal}</td>
            <td>${lesbianTotal}</td>
            <td>${bisexualTotal}</td>
            <td>${transTotal}</td>
            <td>${queerTotal}</td>
            <td>${questioningTotal}</td>
            <td>${intersexTotal}</td>
            <td>${asexualTotal}</td>
            <td>${allyTotal}</td>
            <td>${pansexualTotal}</td>
            <td>${grandTotal}</td>
        </tr>
    `;

    $("#tbl-header").val(JSON.stringify([
        category.value.toUpperCase()+"S","MASCULINE",
        "FEMININE","GAY","LESBIAN","BISEXUAL",
        "TRANSGENDER","QUEER","QUESTIONING","INTERSEX",
        "ASEXUAL","ALLY","PANSEXUAL","SUB TOTAL"
    ]));

    $("#tbl-row").val(JSON.stringify(res));

    $("#tbl-row-total").val(JSON.stringify([
        "GRAND TOTAL",masculineTotal,
        feminineTotal,gayTotal,
        lesbianTotal,bisexualTotal,
        transTotal,queerTotal,
        questioningTotal,intersexTotal,
        asexualTotal,allyTotal,
        pansexualTotal,grandTotal
    ]));  

    $('#report-tbl thead').html(tableHeader);
    $('#report-tbl tbody').html(tableBody);
}


/** 
 * External Gender Preference (Passenger) Chart and Table
 * External Gender Preference (Concessionaire) Chart and Table
 * External Gender Preference (Visitor/Walk In) Chart and Table
 */
function genderPreferenceByUserTypeReport()
{
    $.ajax({
        url: '/miaa/module/gender/lib/filter_reports.php',
        type: 'POST',
        dataType: 'JSON',
        data: formData(),
        success: function(res) {

            checkResponse(res);

            renderGenderPreferenceByUserTypeChart(res);

            createGenderPreferenceByUserTypeTable(res);
        }
    });

    chart.destroy();
}


/** 
 * External Gender Preference (Passenger) Chart
 * External Gender Preference (Concessionaire) Chart
 * External Gender Preference (Visitor/Walk In) Chart
 */
function renderGenderPreferenceByUserTypeChart(res)
{
    removeSurveyChartContainer();

    let labels = [];
    let data = []; 
    let colorNum = 0;
    let yAxesticks = [];
    let title = "Total Number of Gender Preference (" + $("#category option:selected").text() + ")";

    $(".rpt-chart-title").text(title);
    $("#rpt-title").val(title);

    for (i in res) {
        labels.push(res[i].GENDERPREF);
        data.push(res[i].TOTAL);
        colorNum++;
    }

    chart = new Chart(ctx,{
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: uniqueColors(colorNum)
            }]
        },
        options: {
            maintainAspectRatio: false,
            title: {
                display: true,
                text: title,
                fontSize: 20,
                padding: 21
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    generateLabels: customChartLegend,
                    fontColor: '#383838',
                    fontStyle: 600,
                    fontSize: 16
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
                        fontSize: 14
                    }
                }]
            },
            plugins: {
                labels: {
                    render: function (args) {  
                        let max = yAxesticks[0];

                        return Math.round(args.value * 100 / max)+"%";
                    }
                }
            }
        }
    });
}


/** 
 * External Gender Preference (Passenger) Table
 * External Gender Preference (Concessionaire) Table
 * External Gender Preference (Visitor/Walk In) Table
 */
function createGenderPreferenceByUserTypeTable(res)
{
    let tableHeader =`
        <tr>
            <th class="text-center">GENDER PREFERENCES</th>
            <th class="text-center">SUB TOTAL</th>
        </tr>`;

    let tableBody = "";
    let sum = 0;

    for (i in res) {
        tableBody +=`
        <tr class="text-center">
            <td>${res[i].GENDERPREF}</td>
            <td>${res[i].TOTAL}</td>
        </tr>`;
        sum += parseInt(res[i].TOTAL);
    }

    tableBody +=` 
        <tr class="text-center fw-6 tr-pd">
            <td>GRAND TOTAL</td>
            <td>${sum}</td>
        </tr>
    `; 

    $("#tbl-header").val(JSON.stringify(["GENDER PREFERENCES","SUB TOTAL"]));
    $("#tbl-row").val(JSON.stringify(res));
    $("#tbl-row-total").val(JSON.stringify(["GRAND TOTAL",sum]));   

    $('#report-tbl thead').html(tableHeader);
    $('#report-tbl tbody').html(tableBody);
}

/*-- End of Gender Preference Report  --*/ 


/*-- Start of Survey Analysis Report  --*/ 


/**
 * This will generate the following reports:
 * Survey Analysis All (Internal) Chart and Table
 * Survey Analysis All (External) Chart and Table
 * Survey Analysis All (Internal/External) Chart and Table
 */
function surveyAnalysisReport()
{
    let data = formData();

    data.survey_category = survey_category.value;

    $.ajax({
        url: '/miaa/module/gender/lib/filter_reports.php',
        type: 'POST',
        dataType: 'JSON',
        data: data,
        success: function(res) {

            checkResponse(res);

            renderSurveyAnalysisChart(res);

            $(".loader").removeClass("is-active");

        }
    });

    chart.destroy();
}


/**
 * This will generate Survey Analysis Chart (Internal) - Bar Chart
 */
function renderSurveyAnalysisChart(res)
{   
    removeSurveyChartContainer();    

    let surveyKeyList = [];

    const surveyData = res.reduce((allSurvey, survey) => {
        
        let index = surveyKeyList.indexOf(survey.QUESTION);        

        if (index >= 0) {

            let choices = allSurvey[index].CHOICE + "," + survey.CHOICE;
            let totals = allSurvey[index].TOTAL + "," + survey.TOTAL;

            allSurvey[index].CHOICE = choices.split(",");

            allSurvey[index].TOTAL = totals.split(",");

            return allSurvey
        }
        else { 

            surveyKeyList.push(survey.QUESTION);

            return allSurvey.concat(survey);
        }

    }, []);

    let title = "Survey Analysis (" + $("#source option:selected").text() + ")";

    $(".rpt-chart-title").text(title);
    $("#rpt-title").val(title);

    $("#chart-canvas-container").addClass("no-height");

    for (i in surveyData) 
    {
        /*Start of creating a chart panel div and canvas*/
        let chartPanel = document.getElementById("chart-panel");

        let newDiv = document.createElement("div");

        newDiv.className = "survey-chart-container";

        let newCanvas = document.createElement("CANVAS");

        newCanvas.id = "survey-canvas-" + i;
        
        newDiv.appendChild(newCanvas);

        chartPanel.appendChild(newDiv);
        /*End of creating a chart panel div and canvas*/

        chart = new Chart(document.getElementById("survey-canvas-"+i).getContext("2d"),{
            type: 'bar',
            data: {
                labels: surveyData[i].CHOICE,
                datasets: [{
                    data: surveyData[i].TOTAL,
                    backgroundColor: uniqueColors(surveyData[i].TOTAL.length)
                }]
            },
            options: {
                animation: false,
                maintainAspectRatio: false,
                title: {
                    display: true,
                    text: surveyData[i].QUESTION,
                    fontSize: 21,
                    padding: 30
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        generateLabels: customChartLegend,
                        fontColor: '#383838',
                        fontStyle: 600,
                        fontSize: 16
                    }
                },
                scales: {
                    yAxes : [{
                        ticks : {
                            fontSize: 14,
                            beginAtZero : true,
                            userCallback: function(label, index, labels) {
                                if (Math.floor(label) === label) {
                                    return label;
                                }
                            }
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontSize: 14
                        }
                    }]
                },
                plugins: {
                    labels: false,
                    createBase64: false
                }
            }
        });
    }
}


function createSurveyAnalysisTable(res)
{
    /**
     * Table Title = Question
     * Table Header = Choices | Total 
     * Table Footer = Grand TOtal
     */


}

function surveyAnalysisPerOrganizationReport()
{
    let data = formData();

    data.survey_category = survey_category.value;

    $.ajax({
        url: '/miaa/module/gender/lib/filter_reports.php',
        type: 'POST',
        dataType: 'JSON',
        data: data,
        success: function(res) {

            checkResponse(res);

            renderSurveyAnalysisPerOrgChart(res);


            // $(".loader").removeClass("is-active");

        }
    });

    chart.destroy();
}

function renderSurveyAnalysisPerOrgChart(res)
{
    removeSurveyChartContainer();    

    let surveyAnalysisKeyList = [];

    const newSurveyAnalysis = res.reduce( (allSurveyAnalysis, surveyAnalysis) => {

        let index = surveyAnalysisKeyList.indexOf(surveyAnalysis.QUESTION);        

        if (index >= 0) {

            let offices = allSurveyAnalysis[index].OFFICE + "," + surveyAnalysis.OFFICE;
            let choices = allSurveyAnalysis[index].CHOICE + "," + surveyAnalysis.CHOICE;
            let totals = allSurveyAnalysis[index].TOTAL + "," + surveyAnalysis.TOTAL;

            allSurveyAnalysis[index].OFFICE = [...new Set(offices.split(","))];

            allSurveyAnalysis[index].CHOICE = choices.split(",");

            allSurveyAnalysis[index].TOTAL = totals.split(",");

            return allSurveyAnalysis
        }
        else { 

            surveyAnalysisKeyList.push(surveyAnalysis.QUESTION);

            return allSurveyAnalysis.concat(surveyAnalysis);
        }
        
    },[]);

    const result = [];

    for (i in newSurveyAnalysis) 
    {
        let uniqueChoices = [...new Set(newSurveyAnalysis[i].CHOICE)];
        let choices = newSurveyAnalysis[i].CHOICE;
        let datasets = [];
            
        for (let j = 0; j < uniqueChoices.length; j++) {
            
            let totals = [];

            for (let k = 0; k < choices.length; k++) {
                if (choices[k] == uniqueChoices[j]) {
                    totals.push(newSurveyAnalysis[i].TOTAL[k]);
                }
            }

            datasets.push({
                label: uniqueChoices[j],
                data: totals,
                backgroundColor : uniqueColors(totals.length)
            }); 
        }       

        result.push({
            title: newSurveyAnalysis[i].QUESTION,
            labels: newSurveyAnalysis[i].OFFICE,
            datasets: datasets
        });
    }

    for (r in result) {

        /*Start of creating a chart panel div and canvas*/
        let chartPanel = document.getElementById("chart-panel");

        let newDiv = document.createElement("div");

        newDiv.className = "survey-chart-org-container";

        let newCanvas = document.createElement("CANVAS");

        newCanvas.id = "survey-org-canvas-" + r;
        
        newDiv.appendChild(newCanvas);

        chartPanel.appendChild(newDiv);
        /*End of creating a chart panel div and canvas*/

        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: result[r].labels,
                datasets: result[r].datasets
            },
            options: defaultBarChartOption(result[r].title,true,{
                labels: false
            })
        });
    }


}





</script>