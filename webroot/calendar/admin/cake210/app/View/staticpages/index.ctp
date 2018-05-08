<div class="users">
<div>
		<h1>Carshare Administration</h1>
			<center><a href="../../../index.php">Return To Calendar</a></center>
		<br/>
		<br/>
		<b>Announcements</b>
		<ul>
			<li><?php echo $this->html->link('Announcements','/announcements/')?></a>
			<li><?php echo $this->html->link('Announcement Dates','/announcementdates/')?></a>			
		</ul>
		<br/>
		<br/>
		<b>Edit Data</b>
		<ul>
			<li><?php echo $this->html->link('Vehicles','/vehicles/')?></a>
			<li><?php echo $this->html->link('Locations','/locations/')?></a><ul>
			<li><?php echo $this->html->link('Position Locations On Map','/editvehiclelocations/')?></a>
			</ul>
			<li><?php echo $this->html->link('Bookable Objects','/bookables/')?></a>
		</ul>
		<br/>
		<br/>
		<b>Edit Users</b>
		<ul>
			<li><?php echo $this->html->link('Groups','/groups/')?></a>
			<li><?php echo $this->html->link('Users','/users/')?></a>
		</ul>
		<br/>
		<br/>
		<b>Administer Bookings</b>
		<ul>
			<li><?php echo $this->html->link('Administer bookings','/administerbookings/')?></a>
		</ul>
		<br/>
		<b>Logs</b>
		<ul>
			<li><?php echo( $this->html->link('Logs','/logs/')); ?></a></li>
			
			<li><?php echo( $this->html->link("View couldn't book car log",'/couldntbookcar/')); ?></a></li>
			
		</ul>				
		<br/>
		<br/>
		<b>Billing</b>
		<p align='center'>
			<ul>
				<li><?php echo $this->html->link('List invoices for user','/listinvoices/')?></a>		
			</ul>
			<br/>
			<ul>
				<li><?php echo $this->html->link('Upload chart of accounts','/chartofaccounts/')?></a>		
			</ul>
			<br/>
			<ol>
				<li><?php echo $this->html->link('Create a billing object','/billings/')?></a>
				<li><?php echo $this->html->link('Add extra items to invoices','/invoiceextraitems/')?></a>
				<li><?php echo $this->html->link('Preview invoices','/previewinvoice/')?></a>
				<li><?php echo $this->html->link('Generate Invoices, Create IIF files, Email to members','/generateinvoices/inv_list')?></a>
				<li>Remember to make a quickbooks backup so we can backout changes
				<li><?php echo $this->html->link('Download IIF files for generated invoices','/listinvoices/')?></a>
				<li>Import IIF file into quickbooks and check that items were distributed to correct accounts and correct invoices were generated. 
				<ul>
					<li><font color='red'>LOOK FOR UNUSUAL "bank" ACCOUNTS IN THE CHART OF ACCOUNTS.</font> If these are present then there must be a mismatch between accounts on the website and accounts in Quickbooks.</li>
					<li>If one invoice does not import, check that the user is not also a 'Vendor' in Quickbooks. Quickbooks will not allow you to invoice a vendor</li>
				</ul>
				</ol>	
		</p>
</div>