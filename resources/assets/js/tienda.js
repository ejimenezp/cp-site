/**
 * 
 */
window.$ = window.jQuery = require('jquery');

require('bootstrap-sass');
require('jquery-serializejson');

require('jquery-ui/datepicker');

$( document ).ready(function() {

	$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	});

	var ticket_date = $("input[name=ticket_date]").val()

	var ticket = {
		date 	: ticket_date,
		total	: 0,
		articulos: [],
		bases	: [],
		ivas	: [],
		pago	: ""
	}
	var articles = ""  // para imprimir los articulos en el ticket
	var rates = []   // guarda qué ivas se han usado hasta el momento
	var ticket_pagado = false

	$("#ticket_date").html(ticket_date)

    $(".boton-articulo").click(function(){

    	if (ticket_pagado) {
    		alert("este ticket ya está pagado. Limpia o recarga la página")
    		return true;
    	}
        var iva = $(this).data('iva')
        var pvp = $(this).data('pvp')
    	if (rates[iva] === undefined) {  // inicializamos el acumulador de iva
    		ticket.bases[iva] = 0
    		ticket.ivas[iva] = 0
    		rates[iva] = true
    	}

    	articles = articles + $(this).data('nombre') + ' &nbsp ' + pvp +'<br/>'
        ticket.total = ticket.total + Number(pvp)

    	var this_base = Number(pvp)/(1 + Number(iva)/100)
    	var this_iva = pvp - this_base
        var impuestos = ""

        ticket.bases[iva] = ticket.bases[iva] + this_base
        ticket.ivas[iva] = ticket.ivas[iva] + this_iva

        for (var i in ticket.bases) {
        	impuestos = impuestos + ticket.bases[i].toFixed(2) + ' &nbsp ' + i + '% &nbsp ' + ticket.ivas[i].toFixed(2) + '<br/>'
        }

        $('#articles').html(articles)
        $('#total').html(ticket.total.toFixed(2))
        $('#impuestos').html(impuestos)

        // rellenamos array para enviar a servidor
        ticket.articulos.push($(this).data('id'))

    });


    $("#boton-limpiar").click(function(){
		ticket = {
			date 	: ticket_date,
			total	: 0,
			articulos: [],
			bases	: [],
			ivas	: []
		}
		articles = "";  // para imprimir los articulos en el ticket
		rates = [];   // guarda qué ivas se han usado hasta el momento
    	var impuestos = ""
    	ticket_pagado = false

        $('#ticket_id').html("--")
        $('#articles').html(articles)
        $('#total').html(total)
        $('#impuestos').html(impuestos)
	});



    $(".boton-pagar").click(function(){
    	if (ticket_pagado) {
    		alert("Este ticket ya está pagado. Limpia o recarga la página")
    	} else if (ticket.total != 0) {
	    	ticket.pago = $(this).data('pago')
            $("#forma_pago").html(ticket.pago)
	    	$.post("/tienda/addticket", ticket, function(result){
				$('#ticket_id').html(result)
			})
	    	ticket_pagado = true
            window.print()    	}
    });



    $( "#jqueryuidatepicker" ).datepicker({
    	dateFormat: "yy-mm-dd",
        firstDay: 1, // Start with Monday
    	onClose: function (date) {
    		if (ticket_pagado) {
    			alert("Este ticket ya está pagado. Limpia antes de cambiar la fecha")
			} else {
				ticket_date = date
				ticket.date = date
	    		$("#ticket_date").html(date)				
			}

    	}
    });


});
