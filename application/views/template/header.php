<html>
        <head>
                <title>CatLovers</title>
                <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
                <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
                <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
        </head>
        <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo base_url(); ?>main">CatLovers</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a href="<?php echo base_url(); ?>main"> Home </a>
            <a href="<?php echo base_url(); ?>upload"> Upload </a>
            <a href="<?php echo base_url(); ?>support"> Support Us </a>
        </li>
    </ul>
    <ul class="navbar-nav mr-auto">
        <form class="form-inline my-2 my-lg-0">
            <?php echo form_open('ajax'); ?>
            <input class="form-control mr-sm-2" type="search" id="search_text" placeholder="Search" name="search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"> Search</button>
            <?php echo form_close(); ?>
    </ul>
    
    </div>

    <ul class="navbar-nav my-lg-0">
    <?php if(!$this->session->userdata('logged_in')) : ?>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>register"> Register </a>
            <a href="<?php echo base_url(); ?>login"> Login </a>
          </li>
        </ul>
    <?php endif; ?>
    <?php if($this->session->userdata('logged_in')) : ?>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>favorite"> Favorite </a>
                <a href="<?php echo base_url(); ?>profile"> Profile </a>
                <a href="<?php echo base_url(); ?>logout"> Logout </a>
           </li>
        </ul>
    <?php endif; ?>
    </ul>
</nav>
<div class="container">
<div class="collapse" id="collapseExample">
  <div class="card card-body" id="result">

  </div>
</div>
<script>
    $(document).ready(function(){
    load_data();
        function load_data(query){
            $.ajax({
            url:"<?php echo base_url(); ?>ajax/fatch",
            method:"GET",
            data:{query:query},
            success:function(response){
                $('#result').html("");
                if (response == "" ) {
                    $('#result').html(response);
                }else{
                    var obj = JSON.parse(response);
                    if(obj.length>0){
                        var items=[];
                        $.each(obj, function(i,val){
                            items.push($("<h4>").text(val.title));
                            items.push($('<a href="' +'<?php echo base_url(); ?>detail/' + val.id + '" />Detail</a>'));
                    });
                    $('#result').append.apply($('#result'), items);         
                    }else{
                    $('#result').html("Not Found!");
                    }; 
                };
            }
        });
        }
        $('#search_text').keyup(function(){
            var search = $(this).val();
            if(search != ''){
                load_data(search);
            }else{
                load_data();
            }
        });
    });
</script>
