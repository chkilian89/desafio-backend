



<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>



<script src="{{asset('assets/bootstrap-4.5/js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

<script>
    // PARA USAR ESSES PARAMETROS, UTILIZE EM SUA VIEWMODEL O METODO:
	// ko.applyBindingsWithValidation(vm,no html, _KNOCKOUT_OVERRIDE_VALIDATION);
	let _KNOCKOUT_OVERRIDE_VALIDATION = {
		registerExtenders         : true,
		messagesOnModified        : true,
		errorsAsTitle             : true, // enables/disables showing of errors as title attribute of the target element.
		errorsAsTitleOnModified   : false, // shows the error when hovering the input field (decorateElement must be true)
		messageTemplate           : null,
		insertMessages            : true, // automatically inserts validation messages as <span></span>
		parseInputAttributes      : false, // parses the HTML5 validation attribute from a form element and adds that to the object
		writeInputAttributes      : false, // adds HTML5 input validation attributes to form elements that ko observable's are bound to
		decorateInputElement      : true, // false to keep backward compatibility
		decorateElementOnModified : true, // true to keep backward compatibility
		errorClass                : 'validationMessage', // single class for error message and element
		errorElementClass         : 'validationElement', // class to decorate error element
		errorMessageClass         : 'validationMessage', // class to decorate error message
		allowHtmlMessages         : true, // allows HTML in validation messages
		grouping: {
			deep: false,        //by default grouping is shallow
			observable: true,   //and using observables
			live: false		    //react to changes to observableArrays if observable === true
		},
		validate: {
			// throttle: 10
		}
	};
</script>


<!-- Page level custom scripts -->
