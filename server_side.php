<?php 
require 'core/init.php';
include 'includes/styles.php';
?>

<br><br><br>
<div class="container-fluid">

    <table class="table table-striped" id="test_tbl" width="100%">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Qrcode</th>
                <th class="text-center">Title</th>
                <th class="text-center">Status</th>
                <th class="text-center">Required Action</th>
                <th class="text-center">Action Taken</th>
                <th class="text-center">Date Received</th>
            </tr>
        </thead>
        
    </table>

</div>

<?php 
include 'includes/scripts.php';?>

<script type="text/javascript">

$(document).ready(function(){
    $('#test_tbl').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "ajax": "/miaa/module/gender/lib/server_side_test.php"
    });
});

</script>