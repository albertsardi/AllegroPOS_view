@extends('temp-master')

@section('css')
    {{-- <link href="{{ asset('assets/plugin/jquery-ui/themes/smoothness/jquery-ui.css') }}" rel="stylesheet" type="text/css" > --}}
    <link href="{{ asset('assets/plugin/pqgrid/pqgrid.min.css') }}" rel="stylesheet" type="text/css" >
    {{-- <link href="{{ asset('assets/plugin/pqgrid/themes/bootstrap/pqgrid.css') }}" rel="stylesheet" type="text/css" > --}}
@stop

@section('content')
    @php Form::setBindData($data);@endphp
    <form id='formData'>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    {{ Form::hidden('jr', 'buy') }}   
    <!-- Panel Left -->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="card mb-3">
            <div class="card-header">
                <h3><i class="fa fa-check-square-o"></i> General data</h3>
            </div>
            <div class="card-body">
                {{ Form::text('TransNo', 'Transaction #', $data->TransNo, ['placeholder'=>'Transaction #']) }}
                {{ Form::date('TransDate', 'Date', $data->TranDate) }}
                {{ Form::text('TaxNo', 'Tax #', $data->TaxNo) }}
                {{-- {{ Form::select('Type', 'Type', $mType, $data->Type) }} --}}
                {{-- {{ Form::select('HppBy', 'HPP', $mHpp, $data->HppBy) }} --}}
                {{-- {{ Form::checkbox('ActiveProduct', 'Active Product') }} --}}
                {{-- {{ Form::checkbox('StockProduct', 'Have Stock', $data->StockProduct) }} --}}
                {{-- {{ Form::checkbox('canBuy', 'Product can buy', $data->canBuy) }} --}}
                {{-- {{ Form::checkbox('canSell', 'Product can sell', $data->canSell) }} --}}
            </div>
        </div><!-- end card-->
    </div>

    <!-- Panel Right -->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="card mb-3">
            <div class="card-header">
                <h3><i class="fa fa-check-square-o"></i> Other data</h3>
            </div>
            <div class="card-body">
                {{ Form::textwlookup('AccCode', 'Supplier', 'modal-account') }}
                {{ Form::select('Warehouse', 'Warehouse', $mCat, $data->Category) }}
                
                {{-- {{ Form::number('MinStock', 'Minimal Stock') }} --}}
                {{-- {{ Form::number('MaxStock', 'Maximal Stock') }} --}}
                {{-- {{ Form::number('SellPrice', 'Sell Price') }} --}}
                {{-- {{ Form::number('LastBuyPrice', 'Last Buy Price',['disabled'=>true]) }} --}}
                {{-- <br/><br/><br/><br/> --}}
                {{-- {{ Form::textwlookup('AccSellNo', 'Income Account No', 'modal-account') }} --}}
                {{-- {{ Form::textwlookup('AccInventoryNo', 'Inventory Account No', 'modal-account') }} --}}
            </div>
        </div><!-- end card-->
    </div>

    <!-- Panel Grid -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card mb-3">
            <div class="card-header">
                <h3><i class="fa fa-check-square-o"></i> Detail data</h3>
            </div>
            <div class="card-body">
                {{-- {{ Form::textwlookup('AccHppNo', 'HPP Account No', 'modal-account') }} --}}
                {{-- {{ Form::select('Category', 'Category', $mCat, $data->Category) }} --}}
                <div id="xgrid" style="margin:auto;"></div>
            </div>
            <div class="card-footer">
                <button id='cmAddrow' type='button' >Add new line</button>
            </div>
        </div><!-- end card-->
    </div>

    <!-- Panel Bottom -->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="card mb-3">
            <div class="card-body">
                {{ Form::number('SubTotal', 'Minimal Stock', ['disabled'=>true]) }}
                {{ Form::number('DiscAmount', 'Discount', ['disabled'=>true]) }}
                {{ Form::number('TaxAmount', 'Tax', ['disabled'=>true]) }}
                {{ Form::number('Total', 'Grand Total', ['disabled'=>true]) }}
            </div>
        </div><!-- end card-->
    </div>
    
    
    </form>
@stop

@section('modal')
   {{ Modal::open('modal-account', 'Account List') }}
      <table id="listCoa" class="table table-bordered table-hover display mx-10">
			<thead>
				<th>Account #</th><th>Account Name</th>
			</thead>
			<tbody></tbody>
		</table>
   {{ Modal::close() }}
@stop
                    
@section('js')
    <script src="{{ asset('assets/plugin/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugin/pqgrid/pqgrid.min.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
           //init page
            $(':input[type=number]').on('mousewheel',function(e){ $(this).blur();  });
            $('select.select2').select2({ theme: "bootstrap" });
            /*$.ajaxSetup({
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            }); */
           
            
            //load data
            //loaddata(post);
            //$.ajax({url: "http://localhost:8000/ajax_getProduct/C-11", 
            /*$.ajax({url: "{{ url('ajax_getProduct') }}/{{$id}}", 
                success: function(resp){
                    var res=JSON.parse(resp); 
                    //alert(res.status);
                    res=res.data;
                    ////console.log(res);
                    $.each(res, function( f, v ) {
                        $("input[name='"+f+"']").val(v);
                    })
                }
            });*/

            //init pqgrid
            //demo: http://www.ok-soft-gmbh.com/jqGrid/ActionButtons.htm
            //demo: https://paramquery.com/demos
            var colModel = [
            { dataIndx: "ProductCode", title: 'Product #', width: 270 },
            { dataIndx: "ProductName", title: 'Product Name', width: 270,  editable: false },
            { dataIndx: "Qty", dataType: 'integer', title: 'Quantity', width: 80 },
            { dataIndx: "Price", dataType: 'float', title: 'Price', width: 120 },
            { dataIndx: "Amount", dataType: 'float', title: 'Amount', width: 120, editable: true, format: 'Rp.##,###.00',
            /*formula: function(ui) {
                return ui.rowData.Price * ui.rowData.Qty;
            } ,
            render: function(ui) {
                //console.log(ui.rowData.Price)
                //console.log(ui.rowData.Qty)
                return (ui.rowData.Price * ui.rowData.Qty);
            } */
            },
            { title: "", editable: false, minWidth: 165, sortable: false,
                        render: function (ui) {
                            return "<button type='button' class='edit_btn'>Edit</button>\
                                <button type='button' class='delete_btn'>Delete</button>";
                        },
                        postRender: function (ui) {
                            var rowIndx = ui.rowIndx,
                                grid = this,
                                $cell = grid.getCell(ui);

                            //delete button
                            $cell.find(".delete_btn").button({ icons: { primary: 'ui-icon-close'} })
                            .bind("click", function (evt) {
                               alert('deelte row');
                                deleteRow(rowIndx, grid);
                            });

                            //edit button
                            $cell.find(".edit_btn").button({ icons: { primary: 'ui-icon-pencil'} })
                            .bind("click", function (evt) {
                                if (isEditing(grid)) {
                                    return false;
                                }
                                editRow(rowIndx, grid, true);
                            });

                            //if it has edit class, then edit the row.
                            if (grid.hasClass({ rowData: ui.rowData, cls: 'pq-row-edit' })) {
                                editRow(rowIndx, grid);
                            }
                        }
                    }
        ];
        var option = {
            colModel: colModel,
            dataModel: { data: {!!$griddata!!} },
            bootstrap: { on: true },
            showHeader: true,
            showBottom: true,
            rowBorders: true,
            columnBorders: true,
            title: 'Grid Order',
            width: '100%', //width of grid
            height: 400, //height of grid
            cellSave: function (e,ui) {
                var amount = (ui.rowData.Qty * ui.rowData.Price)
                this.updateRow({
                    rowIndx: ui.rowIndx,
                    newRow: {
                        Amount : amount, 
                        ProductCode : ui.rowData.ProductCode,
                        ProductName : ui.rowData.ProductName,
                        Qty : ui.rowData.Qty,
                        Price : ui.rowData.Price,
                    },
                    checkEditable:false
                })
            },
        }
        var xgd = $('#xgrid').pqGrid(option);
        $("#list").jqGrid('setRowData',ids[i],{act:be});

        function deleteRow(rowIndx, grid) {
            grid.addClass({ rowIndx: rowIndx, cls: 'pq-row-delete' });

            var ans = window.confirm("Are you sure to delete row No " + (rowIndx + 1) + "?");
            if (ans) {
                var ProductID = grid.getRecId({ rowIndx: rowIndx });

                $.ajax($.extend({}, ajaxObj, {
                    context: grid,
                    url: "/pro/products/delete", //for ASP.NET, java
                    //url: "/pro/products.php?pq_delete=1",//for PHP
                    data: { ProductID: ProductID },
                    success: function () {
                        this.refreshDataAndView(); //reload fresh page data from server.
                    },
                    error: function () {
                        this.removeClass({ rowIndx: rowIndx, cls: 'pq-row-delete' });
                    }
                }));
            }
            else {
                grid.removeClass({ rowIndx: rowIndx, cls: 'pq-row-delete' });
            }
        }


        //add new line
        $("button#cmAddrow").click(function(e){
            //alert('add new line');
            var newLine = {ProductCode: 'newcode', ProductName: 'Colgate',Qty:123 };
            xgd.pqGrid( "addRow", { newRow: newLine } ); 
        });
        //del line
        $(".delete_btn").click(function(e){
            alert('delte row');
            //xgd.pqGrid( "deleteRow", { rowIndx: 2 } );
        });


        //save data
        //original
        $("button#cmSave").click(function(e){
            e.preventDefault();
            var formdata=$('form').serialize();
            var name = $("input[name=Code]").val();
            var password = $("input[name=Name]").val();
            var email = $("input[name=Barcode]").val();
            //alert(name);
            $.ajax({
                type:'POST',
                //url:'/datasave_product', //using local
                url:'{{env('API_URL')}}/api/datasave',
                //data:{name:name, password:password, email:email},
                data: formdata,
                success:function(res){
                    alert(res.success);
                    //console.log(res.data);
                }
            });
        });
            //using procedure, tapi tidak ada output
            /*$("button#cmSave").click(function(e){
               e.preventDefault();
               var url='http://localhost:500/api/datasave_product';
               Ajax_post(url, 'formData');
               //console.log(res);
	         });*/

            
            /*var dataSource= "http://localhost:8000/ajax_getProduct/C-11";
            $.getJSON(dataSource, function(data, status) {
                for(var row=0;row<data.length;row++) {
                    //console.log(data);
                }
            })  */
            
            //cmSave click
            //$('button#cmxSave').click(function() {
                ////console.log('Saving ....');
                /*var dialog = bootbox.dialog({
                    message: '<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i>Saving, Please wait ...</p>',
                    closeButton: false
                });*/
             //});


                
               
                //Ajax_post( '{{env('API_URL')}}/api/product/datasave', 'formData');
               //var url= '{{env('API_URL')}}/api/datasave/product';
               
               /*$('form').submit(function(ee) {
                  var url= '//datasave_product';
                  var formId= 'formData';
                  var formdata=$("#"+formId).serialize();
                  $.ajax({
                     url: 'http://localhost:8000/datasave_product', 
                     data: formdata, 
                     type: 'POST', 
                     dataType: 'json',
                     success: function (e) {
                        //console.log(JSON.stringify(e));
                        app.locals='OK'
                        return 'OK'
                     },
                     error:function(e){
                        //console.log(JSON.stringify(e));
                        //return JSON.stringify(e)
                        return 'ERROR'
                     }
                  })
                  ee.preventDefault();
               });*/
               
				// modal populate
            $('#listCoa').DataTable({
               //processing: true,
               //serverSide: true,
               paging: true,
               pageLength: 10,
               //pagingType: "full_numbers",
               ajax: "{{env('API_URL')}}/api/coa",
               columns: [
                  {
                     data: null,
                     render: function (data, type, row) {
                        return "<a href=''>" + data['AccNo'] + "</a>";
                     }
                  },
                  { data: 'AccName' }
               ]
            });
                
            //tbLookup Event
            /*$('input[type=lookup]').change(function() {
                var nm=$(this).attr('name');
                var find=$(this).val();
                var row='';
                for(var a=0;a<mcoa.length;a++) {
                    row=mcoa[a];
                    if(row.AccNo==find) break;
                }
                $('#label-'+nm).text(row.AccName); 
                //alert(row.AccName);
            }) */
        });

        
    </script>
@stop

