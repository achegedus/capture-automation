<h2 class="title">Edit Settings</h2>
<h5><span class="star">*</span>Indicates required fields.</h5>

<div class="row spacer"></div>

<div id="alert"><!-- This is where any alerts are displayed   --></div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="clientName">Client Name<span class="star">*</span></label>
        </div>
        <div class="form-group">
            <label>Active Directory Username<span class="star">*</span></label>
        </div>

        <div data-toggle="tooltip" title="If entering multiple emails press ENTER after each new entry" id="email"
             class="form-group">
            <label for="example_email">Email Notifications<span class="star">*</span></label>
        </div>
        <div class="form-group">
			<span class="fieldbox">
				<label for="state">Catalog Service<span class="star">*</span></label>
                <select id="catalogService" name="catalogService" class="form-control">
                    <option disabled selected> -- select an option --</option>
                </select>
			</span>
        </div>

        <div class="form-group" id="datasourceBox">
            <label for="datasource">Datasource<span class="star">*</span></label>
        </div>
        <div id="prefixesPanel" class="panel panel-default" style="display: none">
            <div class="panel-heading">
                <h3 class="panel-title">Prefixes</h3>
            </div>
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="form-group">
                        Live Batch Prefix
                        <div class="input-group date">

                            <span class="input-group-addon">_</span>
                        </div>
                    </div>
                    <div class="form-group">
                        Historical Batch Prefix
                        <div class="input-group date">

                            <span class="input-group-addon">_</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        Maintenance Batch Prefix
                        <div class="input-group date">

                            <span class="input-group-addon">_</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="setVolumePanel" class="panel panel-default" style="display: none">
            <div class="panel-heading">
                <h3 class="panel-title">Proposed Volumes</h3>
            </div>
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="form-group">
                        Accounts
                        <div class="input-group date">

                        </div>
                    </div>
                    <div class="form-group">
                        Live Bills
                        <div class="input-group date">

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        Historical Bills
                        <div class="input-group date">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="ecmaStart">ECMA Start<span class="star">*</span></label>
                    <div class="input-group date">

                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="ecmaRenewal">ECMA Renewal<span class="star">*</span></label>
                    <div class="input-group date">

                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <span class="fieldbox">
                        
                        <label for="state">Invoice Frequency<span class="star"></span></label>
                        <select id="invoiceFreq" name="invoiceFreq" class="form-control">
                            <option disabled selected> -- select an option --</option>
                        </select>
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <span class="fieldbox">
                        <label for="state">SLA<span class="star"></span></label>
                        <select id="sla" name="sla" class="form-control">
                            <option disabled selected> -- select an option --</option>

                        </select>
                    </span>
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
                        <div class="checkbox">
                            <label>

                                Multi-owner Database
                            </label>
                        </div>
                        <div id="ownerBox" class="form-group" style="display: none">
                            <span class="fieldbox">
                                <label for="state">OwnerID<span class="star">*</span></label>
                                
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>

                                Hosted by EnergyCAP
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>

                                Processing Hold
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>

                                Batch Override
                            </label>
                        </div>
                    </div>
                    <div id="setPrefixes" class="form-group">
                        <div class="checkbox">
                            <label>

                                Change Batch Prefixes
                            </label>
                        </div>
                    </div>
                    <div id="setFeesForm" class="form-group">
                        <div class="checkbox">
                            <label>

                                Change Fee Options
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        Kickout Grace Period
                        <div class="input-group">

                            <span class="input-group-addon">Days</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>

                                Set Account Period
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>

                                Transactions Alert
                            </label>
                        </div>
                        <div id="usagePercent" class="form-group" style="display: none">
                            <span class="fieldbox">
                                <label for="state">Usage Percentage<span class="star">*</span></label>
                                
                            </span>
                        </div>
                        <div id="setVolumesForm" class="form-group">
                            <div class="checkbox">
                                <label>

                                    Change Transaction Volumes
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="feesPanelDiv">
            <!-- this is where the Fee Options panel will be loaded -->
        </div>
    </div>
</div>    
