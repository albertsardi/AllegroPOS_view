<!DOCTYPE html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{env('app_name1')}} - Point of Sales</title>
<meta name="description" content="{{env('app_name1')}} - {{env('app_name2')}}">
<meta name="author" content="{{env('app_copyright')}}">

<html lang="en">
<head>
    <!-- BEGIN CSS for this page -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/css/fontawesome/font-awesome.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/plugin/select2/select2.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/plugin/select2/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" >
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="{{ asset('assets/plugin/ag-grid/styles/ag-grid.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugin/ag-grid/styles/ag-theme-alpine.css') }}">
    <!-- END CSS for this page -->
</head>

<body class="adminbody">

<div id="main">

	<!-- top bar navigation -->
	@extends('topmenu')
	<!-- End Navigation -->

	<!-- Left Sidebar -->
	@extends('menu')
	<!-- End Sidebar -->


    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">

				<div class="row">
					<div class="col-xl-12">
						<div class="breadcrumb-holder">
							<h1 class="main-title float-left"> {{ $caption }} </h1>
							<ol class="breadcrumb float-right">
								<li class="breadcrumb-item">Home</li>
								<li class="breadcrumb-item active">Data Tables</li>
							</ol>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
				<!-- end row -->

				<div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3>
                                    <i class="fa fa-table"></i> Data list
                                    <div class='float-right'>
                                        {{-- <button id="cmNew" type="button" class="btn btn-primary btn-sm btn-submit">New</button> --}}
                                        <a href='{{ url($jr.'/edit/new') }}' class="btn btn-primary btn-sm btn-submit">New</a>
                                        <a href='{{ url('datalist/'.$jr.'/pdf-usingChromeheadless') }}' class="btn btn-primary btn-sm btn-submit">Print</a>
                                        {{-- <button id="cmExportExcel" type="button" class="btn btn-primary btn-sm btn-submit">to Excel</button> --}}
                                        <a href='{{ url('datalist/'.$jr.'/excel') }}' class="btn btn-primary btn-sm btn-submit">to Excel</a>
                                        <a href='{{ url('datalist/'.$jr.'/pdf') }}' class="btn btn-primary btn-sm btn-submit">to PDF</a>
                                    </div>
                                </h3>
                            </div>
                            <div class="card-body">
                        <table id="example1" class="table table-striped table-sm table-hover display w-100">
                            {!! $grid !!}
                        </table>
                        <div id="xgrid" class="ag-theme-alpine w-100 my-2" style="height: 300px;"></div>
                        <!--<nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>-->
                            </div><!-- end card-->
                        </div>
                    </div>
                </div>
  				<!-- END container-fluid -->
		</div>
		<!-- END content -->

    </div>
	<!-- END content-page -->

	<footer class="footer">
		[footer.php]
	</footer>

</div>
<!-- END main -->

<!-- BEGIN Java Script for this page -->
<script src="{{ asset('assets/js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/bootbox.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/fastclick.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugin/select2/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pikeadmin.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/plugin/ag-grid/ag-grid-community.min.noStyle.js') }}" type="text/javascript"></script>
<script>
// START CODE FOR BASIC DATA TABLE
var xdata = <?php echo $data;?>;
            {{-- <?php dump($data);?> --}}
            const gridOptions = {
                columnDefs: [
                    { field: 'CatName', rowGroup: true, hide: false },
                    { field: 'AccNo', rowGroup: false, hide: false },
                    { field: 'AccName', rowGroup: true, hide: true },
                    {
                    field: 'Bal',
                        aggFunc: (params) => {
                            console.log(params)
                            let sum = 0;
                            params.values.forEach((value) => (sum += value));
                            return sum;
                        },
                    },
                ],
                xxcolumnDefs: [
                    { field: "AccNo", headerName: 'AccNo', width: 150 },
                    { field: "AccName", headerName: 'AccName', width: 150 },
                    { field: "Bal", headerName: 'Bal', width: 150 },
                ],
                //rowData: xdata,
                defaultColDef: {
                    flex: 1,
                    minWidth: 100,
                    sortable: true,
                    resizable: true,
                },
                autoGroupColumnDef: {
                    minWidth: 200,
                },
                sideBar: true,
                animateRows: true,
            }
            //var xgd =  document.querySelector('#xgrid');
            //new agGrid.Grid(xgd, gridOptions);

            // setup the grid after the page has finished loading
            alert('xxxxyyyy');
            document.addEventListener('DOMContentLoaded', function () {
                alert('ddddd');
                var gridDiv = document.querySelector('#xgrid');
                new agGrid.Grid(gridDiv, gridOptions);
                //fetch('https://www.ag-grid.com/example-assets/olympic-winners.json')
                fetch('http://localhost/lav7_PikeAdmin_multi/api/mastercoa')
                    .then((response) => response.json())
                    .then((data) => gridOptions.api.setRowData(data));
            });


    $(document).ready(function() {
        var fnum    = $.fn.dataTable.render.number(',','.',0,'')
        var fcur    = $.fn.dataTable.render.number(',','.',0,'Rp ')
        var fcurB   = function(data, type) {
            var cur = 'Rp ';
            var number = $.fn.dataTable.render.number( ',', '.', 2, ''). display(Math.abs(data));
            if (data==0) {
                return '<span style="color:black">' +cur + number + '</span>';
            } else if (data<0) {
                return '<span style="color:red">' +cur + ' (' + number + ')</span>';
            } else {
                return '<span style="color:darkgreen">'+ cur + number + '</span>';
            }
        }
        var factive = function(data) {
            if (data.Active==1 || data.ActiveProduct==1) return `<span class="badge badge-success rounded"> <i class="fa fa-check" aria-hidden="true"></i> Active </span>`;
            return `<span class="badge badge-danger rounded"> <i class="fa fa-check" aria-hidden="true"></i> Not active </span>`;
        }
   var jr='{{$jr}}';
   var opt={
      //processing: true,
      //serverSide: true,
      paging: true,
      pagingType: "full_numbers",
      pageLength: 10,
   }
   alert(jr);
    //dd(json_encode($data));




    switch(jr) {
         case 'customer':
         case 'supplier':
            $('#example1').DataTable({
                //ajax:"{{$_url}}",
                data: <?php echo $data;?>,
                //data: <?php echo json_encode($data);?>,
                columns: [
                    { data: null,
                        render: function (data, type, row) {
                            ////console.log(data)
                            if (jr=='customer') {
                                return "<a href='{{ url('/customer/edit') }}/"+data['id']+"'>"+data['AccName']+"</a>";
                            } else {
                                return "<a href='{{ url('/supplier/edit') }}/"+data['id']+"'>"+data['AccName']+"</a>";
                            }
                        }
                    },
                    { data: 'AccCode' },
                    { data: 'Phone' },
                    { data: 'Email' },
                    { data: 'Address' },
                    { data: 'Bal', "className":'col-number', render: fcur },
                    { data : null, render: factive },
                ]
            });
            break; 
        case 'product': //create
            $('#example1').DataTable({
                data: <?php echo $data;?>,
                columns : [
                    { data: null,
                        render: function (data, type, row) {
                            return "<a href='{{ url('/product/edit') }}/"+data['id']+"'>"+data['Code']+"</a>";
                        }
                    },
                    { data : "Name" },
                    { data : "UOM" },
                    { data : "Category" },
                    { data : 'Qty', "className":'col-number', render: fnum },
                    { data : null, render: factive },
                ]
            });
            break;
        case 'xcoa':
            /*$('#example1').DataTable({
					//ajax:"{{$_url}}",
                    data: <?php echo $data;?>,
					columns: [
						{ data: null,
                            render: function (data, type, row) {
                                return "<a href='{{ url('/accountdetaillist') }}/"+data.id+"'>"+data.AccNo+"</a>";
                            }
						},
						{ data: 'AccName' },
						{ data: 'CatName' },
						{ data: 'Bal', "className":'col-number', render: fcurB },
                        { data: null,
                            render: function (data, type, row) {
                                return "<a href='{{ url('/account/edit') }}/"+data['id']+"'>edit</a>";
                            }
                        },
					]
            }); */
            var xdata = <?php echo $data;?>;
            {{-- <?php dump($data);?> --}}
            const gridOptions = {
                columnDefs: [
                    { field: 'AccNo', rowGroup: true, hide: true },
                    { field: 'AccName', rowGroup: true, hide: true },
                    {
                    field: 'Bal',
                        aggFunc: (params) => {
                            console.log(params)
                            let sum = 0;
                            params.values.forEach((value) => (sum += value));
                            return sum;
                        },
                    },
                ],
                xxcolumnDefs: [
                    { field: "AccNo", headerName: 'AccNo', width: 150 },
                    { field: "AccName", headerName: 'AccName', width: 150 },
                    { field: "Bal", headerName: 'Bal', width: 150 },
                ],
                //rowData: xdata,
                defaultColDef: {
                    flex: 1,
                    minWidth: 100,
                    sortable: true,
                    resizable: true,
                },
                autoGroupColumnDef: {
                    minWidth: 200,
                },
                sideBar: true,
                animateRows: true,
            }
            //var xgd =  document.querySelector('#xgrid');
            //new agGrid.Grid(xgd, gridOptions);

            // setup the grid after the page has finished loading
            alert('xxxx');
            document.addEventListener('DOMContentLoaded', function () {
                alert('ddddd');
                var gridDiv = document.querySelector('#xgrid');
                new agGrid.Grid(gridDiv, gridOptions);
                //fetch('https://www.ag-grid.com/example-assets/olympic-winners.json')
                fetch('http://localhost/lav7_PikeAdmin_multi/api/mastercoa')
                    .then((response) => response.json())
                    .then((data) => gridOptions.api.setRowData(data));
                    alert(data);
            });


            break;
        case 'bank':
            $('#example1').DataTable({
                data: <?php echo $data;?>,
                columns: [
                    { data: null,
                        render: function (data, type, row) {
                            return "<a href='{{ url('/accountdetaillist') }}/"+data['id']+"'>"+data['BankAccName']+"</a>";
                        }
					},
                    { data: "BankAccNo" },
                    { data: "AccNo" },
                    { data: "BankType" },
                    { data: 'Bal', "className":'col-number', render: fcurB },
                    { data: null,
                        render: function (data, type, row) {
                            return "<a href='{{ url('/bank/edit') }}/"+data['id']+"'>edit</a>";
                        }
					},
                ]
            });
            break;
		/*case 'bom':
            $('#example1').DataTable({
				"pageLength": 10,
                "columns": [
                        { "data": "pcode" },
                        { "data": "pname" },
                        { "data": "pcat" },
                        { "data": "ptype" }
                    ]
            });
            break;*/
    }
});
// END CODE FOR BASIC DATA TABLE
</script>
<!-- END Java Script for this page -->

</body>
</html>
