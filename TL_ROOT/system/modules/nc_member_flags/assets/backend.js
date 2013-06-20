/**
 * Toggle a flag of a member
 * @param object
 * @param string
 * @param string
 * @param string
 * @return boolean
 */
AjaxRequest.toggleMemberFlag = function (el, flag, id, table) {
    el.blur();
    var img = null;
    var image = $(el).getFirst('img');
    var publish = !(image.className.indexOf('inactive') != -1);
    var div = el.getParent('div');

    var oldsrc = image.src;
	var newsrc = image.name;
	image.src = newsrc;
	image.name = oldsrc;
	image.className = publish ? 'inactive' : 'active';
	
	var requestObj = {
		'item'              : id, 
		'member_flag_state' : publish ? 1 : 0,
		'flag_id'           : flag
	};
    // Send request
    new Request({'url':window.location.href}).get(requestObj);

    return false;
}