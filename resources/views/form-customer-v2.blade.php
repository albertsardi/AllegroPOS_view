@extends('temp-master')

@section('css')
    <link href="/assets/css/style-other.css" rel="stylesheet" type="text/css"/> {% endblock %}
@stop

@section('content')
    @php Form::setBindData($data);@endphp
    <form id='formData' method='POST'>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    {{ Form::hidden('jr', 'customer') }}
    {{ Form::hidden('AccType', 'C') }}
    {{ Form::hidden('Token', session('token')) }}

    <!-- PANEL1 -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-user"></i> {{$data->AccName??''}} [{{$data->AccCode??''}}] -
            <a href="/dataedit/product/'{{$data->id??''}}'"
            class="tooltip-link float-right edit-link"
            data-toggle="pstooltip"
            title=""
            data-placement="top"
            data-original-title="Edit" >
            <i class="fa fa-fw fa-pencil"></i>
            </a>
        </div>
        <div class="card-body">
            @if($id=='new')
                {{ Form2::text('AccCode', 'Code' ) }}
            @else
                {{ Form2::text('AccCode', 'Code', ['readonly'=>true] ) }}
            @endif
            {{ Form2::text('AccName', 'Name') }}
            {{ Form2::select('Category', 'Category', $select->selCustomerSupplierCategory??[] ) }}
            {{ Form2::select('Salesman', 'Salesman', $select->selSalesman??[] ) }}
            {{ Form2::number('CreditLimit', 'Credit Limit') }}
            {{ Form2::number('CreditActive', 'Credit Active') }}
            {{ Form2::select('PriceChannel', 'Price Level', $select->selPriceLevel??[] ) }}
            <hr/>
            {{ Form2::text('Taxno', 'Tax No') }}
            {{ Form2::text('TaxName', 'Tax Name') }}
            {{ Form2::text('TaxAddr', 'Tax Address') }}
            <hr/>
            {{ Form2::textwlookup('AccNo', 'Account #', 'modal-account') }}
            <hr/>
            {{ Form2::text('Memo', 'Memo') }}

            @if($id!='new')
            <hr/>
            <div class="row mb-1">
                <div class="col-4 text-right"> Created </div>
                <div class="col-8"> {{ $data->CreatedDate ?? '-' }} By {{ $data->CreatedBy ?? '-' }}</div>
            </div>
            <div class="row mb-1">
                <div class="col-4 text-right"> Latest Update </div>
                <div class="col-8"> {{ $data->UpdatedDate ?? '' }} </div>
            </div>
            <div class="row mb-1">
                <div class="col-4 text-right"> Status </div>
                <div class="col-8">
                    <span class="badge badge-success rounded">
                        <i class="fa fa-check" aria-hidden="true"></i> Active
                    </span>
                </div>
            </div>
            @endif
        </div>
    </div><!-- end card-->

    @if($id!='new')
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-shopping-basket"></i> Orders
            <span class="badge badge-primary rounded">'+mOrder.length+'</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    Valid orders:
                    <span class="badge badge-success rounded">{{ $data->orderCount??0 }}</span>
                    for a total amount of <span id="total-order-amount">Rp {{ $data->orderTotAmount??0 }} </span>
                </div>
                <div class="col">
                    Invalid orders:
                    <span class="badge badge-danger rounded">5</span>
                </div>
            </div>
            <table id='table-order' class="table w-100">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Payment</th>
                    <th>Products</th>
                    <th>Total spent</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div><!-- end card-->
    @endif

    <!--
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-shopping-cart"></i> Carts
            <span class="badge badge-primary rounded">5</span>
        </div>
        <div class="card-body">
            <table id='table-cart' class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Carrier</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div> end card
    -->

    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-eye"></i> Add a private note
            {{-- {{ alert_info('', 'This note will be displayed to all employees but not to customers.') }} --}}
        </div>
        <div class="card-body">
            <form name="private_note" method="post" action="presta_1.7.8.5/admin396tciuup/index.php/sell/customers/2/set-private-note?_token=3c3131zih1h5I1ftl2sC0vH3cXmZKgJYMDj3GmProbQ" class="form-horizontal">
                <textarea id="private_note_note" name="private_note[note]" placeholder="Add a note on this customer. It will only be visible to you." class="form-control"></textarea>
                <button class="btn btn-primary float-right mt-3" id="save-private-note" type="submit"> Save </button>
                <div class="form-group row type-hidden " >
                    <label for="private_note__token" class="form-control-label "> </label>
                    <div class="col-sm">
                        <input type="hidden" id="private_note__token" name="private_note[_token]" class="form-control" value="LvbtE4jdzutkw6LXbaIt9w6a5aBGGNGgjgTrefANiW0" />
                    </div>
                </div>
            </form>
        </div>
    </div><!-- end card-->

    <!-- card group -->
    <!--
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-users"></i> Groups  <span class="badge badge-primary rounded">1</span>'+
            <a href="presta_1.7.8.5/admin396tciuup/index.php/sell/customers/2/edit?_token=3c3131zih1h5I1ftl2sC0vH3cXmZKgJYMDj3GmProbQ"
                class="tooltip-link float-right"
                data-toggle="pstooltip"
                data-placement="top"
                data-original-title="Edit">
                <i class="fa fa-fw fa-pencil"></i>
            </a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
                </thead>
                <tbody>
                    <tr class="customer-group">
                    <td class="customer-group-id">#3</td>
                    <td class="customer-group-name">
                    <a href="http://localhost/presta_1.7.8.5/admin396tciuup/index.php?controller=AdminGroups&amp;id_group=3&amp;viewgroup=1&amp;token=23aed44929ae7e63d47020d7b1941e39">
                        Customer
                    </a>
                    </td>
                </tr>
                        </tbody>
            </table>
        </div>
    </div><!-- end card
     -->

    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-map-marker"></i> Addresses <span class="badge badge-primary rounded">{{count($mAddress)}}</span>
            {{-- <a href="presta_1.7.8.5/admin396tciuup/index.php/sell/addresses/new?id_customer=2&amp;back=http%3A%2F%2Flocalhost%2Fprestashop_1.7.8.5%2Fadmin396tciuup%2Findex.php%2Fsell%2Fcustomers%2F2%2Fview%3F_token%3D3c3131zih1h5I1ftl2sC0vH3cXmZKgJYMDj3GmProbQ&amp;_token=3c3131zih1h5I1ftl2sC0vH3cXmZKgJYMDj3GmProbQ"
                class="tooltip-link float-right"
                data-toggle="pstooltip"
                title=""
                data-placement="top"
                data-original-title="Add">
                <i class="fa fa-fw fa-plus-circle"></i>
            </a> --}}
            <button type='button' data-toggle='modal' data-target='#modal-inputaddress' class='float-right btn btn-link btn-sm btnlookup'><i class="fa fa-fw fa-plus-circle"></i></button>
        </div>
        <div class="card-body">
            <form name="customer_address" method="post" action="" id="customer_address_filter_form" class="table-responsive form-horizontal">
                <table id="table-address" class="table w-100">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Location</th>
                        <th>Person</th>
                        <th>Address</th>
                        <th>Area</th>
                        <th>Phone number(s)</th>
                        <th>Fax</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </form>
        </div>
    </div><!-- end card-->

    <div class="card mb-3">
        <div class="card-header">
        </div>
        <div class="card-body">
        </div>
    </div><!-- end card-->
    </form>
@stop

@section('modal')
   @include('modal.modal-account')
   @include('modal.modal-inputaddress')
@stop


@section('js')
<script src="{{ asset('assets/js/lookup/lookup.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/textwlookup.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/helper_form.js') }}" type="text/javascript"></script>
{{-- <script src="{{ asset('assets/js/helper_address.js') }}" type="text/javascript"></script> --}}

<script type="text/javascript">
   $(document).ready(function() {
		//init page

        //init datagrid
        var fcur = $.fn.dataTable.render.number(',', '.', 0, 'Rp ');
        var fnum = $.fn.dataTable.render.number(',', '.', 0, '');
        var fdate = function(v) { return moment(v).format('DD/MM/YYYY') }
        $('#table-order').DataTable({
            paging: true,
            pagingType: "full_numbers",
            pageLength: 5,
            data: {!! $mOrder !!},
            columnDefs: [{width:20, targets:5}],
            columns: [
                {
                    data: null,
                    render: function (data, type, row) {
                        return "#" + data['TransNo'];
                    }
                },
                { data: 'TransDate', render: fdate },
                {
                    data: null,
                    render: function (data, type, row) {
                        return "Transfer";
                    }
                },
                { data: 'ProductCount', "className": 'col-number', render: fnum  },
                { data: 'Total', "className": 'col-number', render: fcur },
                {
                    data: null,
                    render: function (data, type, row) {
                        return `<a href=" {{ url('trans-edit/${row.TransNo}') }} "
                                class="btn tooltip-link dropdown-item grid-view-row-link"
                                data-toggle="pstooltip"
                                data-placement="top"
                                data-original-title="View">
                                <i class="fa fa-fw fa-search-plus"></i>
                            </a>`;
                    }
                },
            ]
        });

        $('#table-cart').DataTable({
            paging: true,
            pagingType: "full_numbers",
            pageLength: 5,
            //ajax: _api("SI"),
            data: [],
            columns: [
                {
                    data: null,
                    render: function (data, type, row) {
                    return "#" + data['TransNo'];
                    }
                },
                { data: 'TransDate', render: fdate },
                { data: 'DeliveryCode' },
                { data: 'Status' },
                { data: 'Total', "className": 'col-number', render: fcur },
                {
                    data: null,
                    render: function (data, type, row) {
                    return `<a href="presta_1.7.8.5/admin396tciuup/index.php/sell/orders/carts/000005/view?_token=3c3131zih1h5I1ftl2sC0vH3cXmZKgJYMDj3GmProbQ"
                            class="btn tooltip-link dropdown-item grid-view-row-link"
                            data-toggle="pstooltip"
                            data-placement="top"
                            data-original-title="View">
                                    <i class="fa fa-fw fa-search-plus"></i>
                        </a>`;
                    }
                },
            ]
        });

        $('#table-address').DataTable({
            paging: true,
            pagingType: "full_numbers",
            pageLength: 5,
            data: {!! $mAddress !!},
            columnDefs: [{width:20, targets:7}],
            columns: [
                {
                    data: null,
                    render: function (data, type, row) {
                    return "#" + row.id;
                    }
                },
                { data: 'Code' },
                { data: 'ContachPerson' },
                { data: 'Address' },
                { data: 'Area' },
                { data: 'Phone' },
                { data: 'Fax' },
                {
                    data: null,
                    render: function (data, type, row) {
                        /*return `<a href="presta_1.7.8.5/admin396tciuup/index.php/sell/addresses/5/edit?back=http%3A%2F%2Flocalhost%2Fprestashop_1.7.8.5%2Fadmin396tciuup%2Findex.php%2Fsell%2Fcustomers%2F2%2Fview%3F_token%3D3c3131zih1h5I1ftl2sC0vH3cXmZKgJYMDj3GmProbQ&amp;_token=3c3131zih1h5I1ftl2sC0vH3cXmZKgJYMDj3GmProbQ"
                                    data-confirm-message=""
                                    data-toggle="pstooltip"
                                    data-placement="top"
                                    data-original-title="Edit"
                                    data-clickable-row="1">
                                    <i class="fa fa-fw fa-pencil"></i>
                                </a>

                                <a class=""
                                href="#"
                                data-confirm-message="Are you sure you want to delete the selected item(s)?"
                                data-url="presta_1.7.8.5/admin396tciuup/index.php/sell/addresses/5/delete?back=http%3A%2F%2Flocalhost%2Fprestashop_1.7.8.5%2Fadmin396tciuup%2Findex.php%2Fsell%2Fcustomers%2F2%2Fview%3F_token%3D3c3131zih1h5I1ftl2sC0vH3cXmZKgJYMDj3GmProbQ&amp;_token=3c3131zih1h5I1ftl2sC0vH3cXmZKgJYMDj3GmProbQ"
                                data-method="POST"
                                data-title="Delete selection"
                                data-confirm-button-label="Delete"
                                data-confirm-button-class="btn-danger"
                                data-close-button-label="Cancel">
                                <i class="fa fa-fw fa-trash"></i>
                                </a>`;
                        } */
                        var dval = JSON.stringify(row).toString();
                        return `<button type='button' data-id=${row.id} class='btn btn-link btn-sm cmAddress-del'><i class="fa fa-fw fa-trash"></i></button>
                                <button type='button' data-toggle='modal' data-target='#modal-inputaddress' data-value='`+dval+`' class='btn btn-link btn-sm cmAddress-edit'><i class="fa fa-fw fa-pencil"></i></button>`;
                    }
                },
            ]
        });

        $("button#cmSave2").click(function(e){
            e.preventDefault();
            var formdata=$('form').serialize();
            $('#formData').submit();
        });

        $("button#cmSave").click(function(e){ //using ajax
            e.preventDefault();
            var formdata=$('form').serialize();
            var result = $('form').formsave('supplier', '{{$id}}' );
        });

        $("button#cmPrint").click(function(e){
            e.preventDefault();
            alert('print');
        });

        // Address
        $("a.cmAddress-Add").click(function(e){
            e.preventDefault();
            alert('add address');
        }); $("button.cmAddress-edit").click(function(e){
            e.preventDefault();
            alert('edit address');
            var dt = $(this).data('value')
            for(let row in dt) {
                $('input#AccAddress').val(dt.Address)
                $('input#ckDefAddr').val(1) //ini akan di rubah nanti
                $('input#'+row).val(dt[row])
            }
        });
        $("button#cmAddress-save").click(function(e){
            e.preventDefault();
            alert('save new address');
            //$('#modal-inputaddress').modal('hide')
        });
        $("button.cmAddress-del").click(function(e){
            e.preventDefault();
            alert('delete address');
            //$('#modal-inputaddress').modal('hide')
        });

        $('.modal').on('show.bs.modal', function (e) {
            lookup_target_button = $(e.relatedTarget) // Button that triggered the modal
        })

	});

    function afterModalClose(sel) {
        ////console.log(sel)
        if (sel.selModal == 'modal-account') {
            var btn = lookup_target_button;
            $('#'+btn.attr('id')).textwlookup(sel.selRow[0], sel.selRow[1])
        }
    };
</script>
@stop
