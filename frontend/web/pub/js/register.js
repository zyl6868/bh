// JavaScript Document
$(function(){
	$('form').validationEngine({
        validateNonVisibleFields:true,
            promptPosition:"centerRight",
		maxErrorsPerField:1,
		showOneMessage:true,
		addSuccessCssClassToField:'ok'
	})


});