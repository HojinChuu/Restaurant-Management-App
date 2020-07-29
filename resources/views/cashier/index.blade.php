@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="table-detail"></div>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <button class="btn btn-primary btn-block" id="btn-show-tables">
                View All Tables
            </button>
        </div>
        <div class="col-md-7">

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

    })
</script>

@endsection
