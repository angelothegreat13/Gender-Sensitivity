<?php 
    require_once 'core/init.php';
    include 'includes/styles.php';
    deny_if_not_login();
?>

<body>
<div class="row">
    <div class="col-md-3" style="margin-top:30px;">
        <canvas id="genderChart" width="200" height="200"></canvas>
    </div>

    <div class="col-md-9">
        <canvas id="genderPrefChart" width="400" height="200"></canvas>
    </div>    
</div>
    
</body>

<script src="../../assets/js/js-bootstrap/jquery.min.js"></script>
<script src="../../assets/js/js-bootstrap-executive-charts/Chart.min.js"></script>
<script type="text/javascript">
var genderChart = document.getElementById("genderChart").getContext('2d');
var genderPrefChart = document.getElementById("genderPrefChart").getContext('2d');

var dynamicColors = function() 
{
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    return "rgb(" + r + "," + g + "," + b + ")";
};

$(document).ready(function () 
{     
    // Start of Gender Chart
    $.ajax({
        type: "POST",
        url: "lib/gender_charts.php",
        data: {mode:"gender_total"},
        dataType: "JSON",
        success: function (response) 
        {   
            let gender = [];
            let genderTotal = [];
            
            for(var i in response) {
                gender.push(response[i].gender);
                genderTotal.push(response[i].total);
            }

            var genderPieChart = new Chart(genderChart,{
                type: 'pie',
                data: {
                    labels: gender,
                    datasets: [{
                        data: genderTotal,
                        backgroundColor: [
                            '#4B77BE',
                            '#F62459',
                        ]
                    }]
                },
                options: {
                    legend: {
                        labels: {
                            fontSize: 15,
                            fontStyle : '600'
                        }
                    },
                    responsive : true,
                    animation: false
                }
            });
        }
    });
    // End of Gender Chart


    // Start of Gender Preference Chart
    $.ajax({
        type: "POST",
        url: "lib/gender_charts.php",
        data: {mode:"gender_pref_total"},
        dataType: "JSON",
        success: function (response) 
        {
            let genderPref = [];
            let genderPrefTotal = [];
            let colors = [];

            for(var i in response) {
                genderPref.push(response[i].genderdesc);
                genderPrefTotal.push(response[i].total);
                colors.push(dynamicColors());
            }

            var genderPrefBarChart = new Chart(genderPrefChart,{
                type: 'bar',
                data: {
                    labels: genderPref,
                    datasets: [{
                        data: genderPrefTotal,
                        backgroundColor: colors
                    }]
                },
                options: {
                    responsive: true,
                    legend: {
                        display: false,
                    },
                    title: {
                        display: true,
                        text: 'TOTAL NUMBER OF GENDER PREFERENCES',
                        fontSize: 15,
                        fontStyle : '600'
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true,
                                // min: Array.min(genderPrefTotal) -5,
                            }
                        }]
                    },
                    responsive : true,
                    animation: false
                }
            });
        }
    });
    // End of Gender Preference Chart

    setTimeout(function(){ 
        window.print();
    }, 500);
});


</script>




