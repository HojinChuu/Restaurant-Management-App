@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="table-detail"></div>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <button class="btn btn-primary btn-block" id="btn-show-tables">
                View All Tables
            </button>
            <div id="selected-table"></div>
            <div id="order-detail"></div>
        </div>
        <div class="col-md-7">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @foreach ($categories as $category)
                        <a class="nav-item nav-link" data-id="{{ $category->id }}" data-toggle="tab">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </nav>
            <div id="list-menu" class="row mt-2"></div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <h3 class="totalAmount"></h3>
        <h3 class="changeAmount"></h3>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">$</span>
            </div>
            <input type="number" name="" id="recieved-amount" class="form-control">
        </div>
        <div class="form-group">
            <label for="payment">Payment Type</label>
            <select name="" id="payment-type" class="form-control">
                <option value="cash">Cash</option>
                <option value="credit card">Credit card</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-save-payment" disabled>Save Payment</button>
    </div>
    </div>
</div>
</div>

<script>
    $(document).ready(() => {

        // hide table button 
        $("#table-detail").hide();

        // show table button 
        $("#btn-show-tables").click(() => {
            if($("#table-detail").is(":hidden")) {
                $.get("/cashier/getTable", (data) =>{
                    $("#table-detail").html(data)
                    $("#table-detail").slideDown('slow')
                    $("#btn-show-tables").html('Hide Table').removeClass('btn-primary').addClass('btn-danger')
                }) 
            } else {
                $("#table-detail").slideUp('slow')
                $("#btn-show-tables").html('View All Tables').removeClass('btn-danger').addClass('btn-primary')
            }
        })

        // load menus by category
        $(".nav-link").click(function() {
            // console.log(e.target.dataset.id)
            $.get(`/cashier/getMenuByCategory/${$(this).data("id")}`, (data) => {
                $("#list-menu").hide()
                $("#list-menu").html(data)
                $("#list-menu").fadeIn('fast')
            })
        })

        var SELECTED_TABLE_ID = "";
        var SELECTED_TABLE_NAME = "";
        var SALE_ID = "";

        // show table data
        $("#table-detail").on("click", ".btn-table", function() {
            SELECTED_TABLE_ID = $(this).data("id")
            SELECTED_TABLE_NAME = $(this).data("name")
            $("#selected-table").html('<br><h3>Table: '+ SELECTED_TABLE_NAME +'</h3><hr>')

            $.get("/cashier/getSaleDetailsByTable/" + SELECTED_TABLE_ID, function(data) {
                $("#order-detail").html(data)
            })
        })

        // menu click
        $("#list-menu").on("click", ".btn-menu", function() {
            if(SELECTED_TABLE_ID == "") {
                alert('You need to select a table for the customer first')
            } else {
                var menu_id = $(this).data("id")
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "menu_id" : menu_id,
                        "table_id" : SELECTED_TABLE_ID,
                        "table_name" : SELECTED_TABLE_NAME,
                        "quantity" : 1
                    },
                    url: "/cashier/orderFood",
                    success: function(data) {
                        $("#order-detail").html(data)
                    }
                })
            }
        })

        $("#order-detail").on('click', ".btn-confirm-order", function() {
            var SaleID = $(this).data('id')
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "sale_id" : SaleID,
                },
                url: "/cashier/confirmOrderStatus",
                success: function(data) {
                    $("#order-detail").html(data)
                }
            })
        })

        $("#order-detail").on("click", ".btn-delete-saledetail", function() {
            var saleDetailID = $(this).data("id")
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "saleDetail_id" : saleDetailID,
                },
                url: "/cashier/deleteSaleDetail",
                success: function(data) {
                    $("#order-detail").html(data)
                }
            })
        })

        // click on the payment button
        $("#order-detail").on("click", ".btn-payment", function() {
            var totalAmount = $(this).attr('data-totalAmount')
            $(".totalAmount").html("Total Amount " + totalAmount)
            $('#recieved-amount').val('')
            $(".changeAmount").html('')
            SALE_ID = $(this).data('id')
        })

        // calcuate change
        $("#recieved-amount").keyup(function() {
            var totalAmount = $(".btn-payment").attr('data-totalAmount')
            var recievedAmount = $(this).val()
            var changeAmount = recievedAmount - totalAmount

            $(".changeAmount").html("Total Change : $ " + changeAmount)

            if(changeAmount >= 0) {
                $('.btn-save-payment').prop('disabled', false)
            } else {
                $('.btn-save-payment').prop('disabled', true)
            }
        })

        // save Payment
        $(".btn-save-payment").click(function() {
            var recievedAmount = $("#recieved-amount").val()
            var paymentType = $("#payment-type").val()
            var saleId = SALE_ID
            
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "saleID": saleId,
                    "recievedAmount": recievedAmount,
                    "paymentType": paymentType
                },
                url: "/cashier/savePayment",
                success: function(data) {
                    window.location.href= data
                }
            })
        })
    })
</script>

@endsection
