<div class="users">
<div>
		<h1>Carshare Administration</h1>
			<center><a href="../../../../index.html">Return To Calendar</a></center>
		<br/>
		<br/>
		<b>Announcements</b>
		<ul>
			<li><?php echo $html->link('Announcements','/announcements/')?></a>
			<li><?php echo $html->link('Announcement Dates','/announcementdates/')?></a>			
		</ul>
		<br/>
		<br/>
		<b>Edit Data</b>
		<ul>
			<li><?php echo $html->link('Vehicles','/vehicles/')?></a>
			<li><?php echo $html->link('Locations','/locations/')?></a><ul>
			<li><?php echo $html->link('Position Locations On Map','../../../index.php?action=edit_vehicle_locations')?></a>
			</ul>
			<li><?php echo $html->link('Bookable Objects','/bookables/')?></a>
		</ul>
		<br/>
		<br/>
		<b>Edit Users</b>
		<ul>
			<li><?php echo $html->link('Groups','/groups/')?></a>
			<li><?php echo $html->link('Users','/users/')?></a>
		</ul>
		<br/>
		<br/>
		<b>Administer Bookings</b>
		<ul>
			<li><?php echo $html->link('Administer bookings','../../../index.php?action=car_month_usage_form')?></a>
		</ul>		
		<br/>
		<br/>
		<b>Billing</b>
		<p align='center'>
			<ul>
				<li><?php echo $html->link('List invoices for user','../../../index.php?action=list_invoices_form')?></a>		
			</ul>
			<br/>
			<br/>
			<ol>
				<li><?php echo $html->link('Create a billing object','/billings/')?></a>
				<li><?php echo $html->link('Add extra items to invoices','/invoiceextraitems/')?></a>
				<li><?php echo $html->link('Preview invoices','../../../index.php?action=preview_invoice_form')?></a>
				<li><?php echo $html->link('Generate Invoices, Create IIF files, Email to members','../../../index.php?action=generate_invoices_form')?></a>
				<li>Remember to make a quickbooks backup so we can backout changes
				<li><?php echo $html->link('Download IIF files for generated invoices','../../../index.php?action=list_invoices_form')?></a>
				<li>Import IIF file into quickbooks and check that items were distributed to correct accounts and correct invoices were generated.
			</ol>	
		</p>
</div>