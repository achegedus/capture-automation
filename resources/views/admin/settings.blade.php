<?php
use Carbon\Carbon;
?>
<head>
    <style>
        .option {
            font-weight: normal;
        }
        
        .panel-body .form-group {
            margin-bottom: 7px;
        }
        
    </style>
</head>

<script>    
    
    $(function() {
        $("#alert").hide();  
        
        $('.datepick').datepicker({
            format: 'yyyy-mm-dd'
        });        
        
    });    
    
    $('#submitButton').click(function(){
        var id = document.getElementById("clientList").value; 
        $.ajax({
            type: "POST",
            url: "/admin/submit/" + id,
            data: $('#adminSettingsForm').serialize(),
            success: function() {
                $("#alert").show();
                $("#alert").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert").slideUp(500);
            });                   
            }
                
        });
            
    });
    
    // email plugin
    $('#example_email').multiple_emails();
    $('#current_emails').text($('#example_email').val());
    $('#example_email').change( function(){
        $('#current_emails').text($(this).val());
    });    
    
</script>    

<?php
$data = $client->clientEmail;
$explode = explode(',', $data);

$converted_email = array();
foreach($explode as $v) {
//        echo $v;
    $converted_email[] = $v;
}

$encoded_email = json_encode($converted_email);
?>


<h2 class="title">Edit Settings</h2>
<h5><span class="star">*</span>Indicates required fields.</h5>

<div class="row spacer"></div>

<div class="row" id="alert"><!-- This is where any alerts are displayed   -->
    <div class='alert alert-success alert-dismissable' id='successAlert'> 
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'></button>
        <strong>Success!</strong> Settings saved successfully.
    </div>
</div>

{!! Form::open(array('url' => '/admin/submit', 'id' => 'adminSettingsForm')) !!}

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('clientName', 'Client Name:') !!}
            {!! Form::text('clientName', $client->clientName, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('username', 'Active Directory Username:') !!}
            {!! Form::text('username', $client->username, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('clientEmail', 'Email Notifications:') !!}
            {!! Form::text('clientEmail', $encoded_email, ['class' => 'form-control', 'id' => 'example_email']) !!}
        </div>        
        <div class="form-group">
            {!! Form::label('catalogServiceID', 'Catalog Service:') !!}
            {!! Form::select('catalogServiceID', $catalogData, $client->catalogServiceID, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('datasource', 'Datasource:') !!}
            {!! Form::text('datasource', $client->datasource, ['class' => 'form-control']) !!}
        </div>              
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('ECMA_start', 'ECMA Start:') !!}
                    <div class="input-group date">
                        {!! Form::text('ECMA_start', Carbon::parse($client->ECMA_start)->toDateString(), ['class' => 'form-control datepick']) !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>                      
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('ECMA_renew', 'ECMA Renewal:') !!}
                    <div class="input-group date">
                        {!! Form::text('ECMA_renew', Carbon::parse($client->ECMA_renew)->toDateString(), ['class' => 'form-control datepick']) !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>                      
            </div>            
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('invoiceSchedule', 'Invoice Frequency:') !!}
                    {!! Form::select('invoiceSchedule', array('Monthly'=>'Monthly','Quarterly'=>'Quarterly','Annually'=>'Annually','ECMA'=>'ECMA'), $client->invoiceSchedule, 
                        ['class' => 'form-control']) !!}                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('SLA', 'SLA:') !!}
                    {!! Form::select('SLA', array('Pre'=>'Pre', 'Post'=>'Post'), $client->SLA, ['class' => 'form-control']) !!}                          
                </div>
            </div>
        </div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Options</h3>
			</div>
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::checkbox('multi_tenant', '1', $client->multi_tenant, ['id' => 'multi_tenant']) !!}
                        {!! Form::label('multi_tenant', 'Multi-owner Database', ['class' => 'option']) !!}
                    </div>
                    <div class="form-group">
                        OwnerID
                        {!! Form::text('ownerID', $client->ownerID, ['class' => 'form-control']) !!}                         
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('isHosted', '1', $client->isHosted, ['id' => 'isHosted']) !!}
                        {!! Form::label('isHosted', 'Hosted by EnergyCAP', ['class' => 'option']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('onHold', '1', $client->onHold, ['id' => 'onHold']) !!}
                        {!! Form::label('onHold', 'Processing Hold', ['class' => 'option']) !!}                        
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('batchOverride', '1', $client->batchOverride, ['id' => 'batchOverride']) !!}
                        {!! Form::label('batchOverride', 'Batch Override', ['class' => 'option']) !!}                        
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('prefixes', '1', '1', ['id' => 'prefixes']) !!}
                        {!! Form::label('prefixes', 'Change Batch Prefixes', ['class' => 'option']) !!}                        
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('feeOptions', '1', '1', ['id' => 'feeOptions']) !!}
                        {!! Form::label('feeOptions', 'Change Fee Options', ['class' => 'option']) !!}                        
                    </div>                    
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                       Kickout Grace Period
                        <div class="input-group">
                            {!! Form::number('gracePeriod', $client->kickoutGracePeriod, ['class' => 'form-control']) !!}
                            <span class="input-group-addon">Days</span>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('setAccountPeriod', '1', $client->setAccountPeriod, ['id' => 'setAccountPeriod']) !!}
                        {!! Form::label('setAccountPeriod', 'Set Account Period', ['class' => 'option']) !!}                        
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('transAlert', '1', $client->transactions_alert, ['id' => 'transAlert']) !!}
                        {!! Form::label('transAlert', 'Transactions Alert', ['class' => 'option']) !!}                        
                    </div>
                    <div class="form-group">
                        Usage Percentage
                        {!! Form::number('usagePercent', $client->usage_alert_percent, ['class' => 'form-control']) !!}                        
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('transVolume', '1', '1', ['id' => 'transVolume']) !!}
                        {!! Form::label('transVolume', 'Change Transaction Volumes', ['class' => 'option']) !!}                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        <span id="submitButton" type="button" class="btn btn-primary form-control">Save Settings</span>
    </div>

</div>

{!! Form::close() !!}


