function link_to(controller_name, action_name)
{
	link_to(controller_name, action_name, {});
}

function link_to(controller_name, action_name, params)
{
	$.getScript( "js/ui/"+controller_name+'.js' )
		.done(function( script, textStatus ) {
			eval(capitaliseFirstLetter(controller_name)+'.'+action_name+'()');
		})
		.fail(function( jqxhr, settings, exception ) {
			alert('Error loading script: '+controller_name+'.'+action_name);
	});
}

function capitaliseFirstLetter(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

$( document ).ready(function() {
	link_to('calendar', 'layout');
});