<?php 

// Database connection info
$dbDetails = array(
    'host' => 'localhost',
    'user' => 'root',
    'pass' => 'root',
    'db'   => 'traildb'
);

// DB table to use
$table = 'tbltrans';

// Table's primary key
$primaryKey = 'trans_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database. 
// The `dt` parameter represents the DataTables column identifier.
$columns = array(
    array( 'db' => 'trans_id',   'dt' => 0 ),
    array( 'db' => 'docqrcode',  'dt' => 1 ),
    array( 'db' => 'doctitle',   'dt' => 2 ),
    array( 'db' => 'status',     'dt' => 3 ),
    array( 'db' => 'reqaction',  'dt' => 4 ),
    array( 'db' => 'actiontaken',  'dt' => 5 ),
    array(
        'db'        => 'daterecieve',
        'dt'        => 6,
        'formatter' => function( $d, $row ) {
            return date( 'jS M Y', strtotime($d));
        }
    )
);

// Include SQL query processing class
require('ssp.class.php');

// Output data as json format
echo json_encode(
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns )
);