function IsDate(oTextbox) { 
	var regex = new RegExp("^(?:(?:([0-9]{4}(-|\/)(?:(?:0?[1,3-9]|1[0-2])(-|\/)(?:29|30)|((?:0?[13578]|1[02])(-|\/)31)))|([0-9]{4}(-|\/)(?:0?[1-9]|1[0-2])(-|\/)(?:0?[1-9]|1\\d|2[0-8]))|(((?:(\\d\\d(?:0[48]|[2468][048]|[13579][26]))|(?:0[48]00|[2468][048]00|[13579][26]00))(-|\/)0?2(-|\/)29))))$"); 
	var dateValue = oTextbox.value; 
	if (!regex.test(dateValue)) { 
	alert("日期有误！"); 
	dateValue = ""; 
	this.focus(); 
	return; 
	} 
}
function checkSubmitMobil() { 
	if ($("#mobile").val() == "") { 
		alert("手机号码不能为空！"); 
		$("#mobile").focus(); 
		return false; 
	} 
	if (!$("#mobile").val().match(/^(((13[0-9]{1})|159|153)+\d{8})$/)) { 
		alert("手机号码格式不正确！"); 
		$("#mobile").focus(); 
		return false; 
	} 
	return true; 
} 
function IsNumber(){
	if () {};
	alert(isNaN($('#id').val()));
}