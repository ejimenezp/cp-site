/**
 * 
 */
window.$ = window.jQuery = require('jquery');

require('bootstrap-sass');
require('jquery-serializejson');
require('printThis');


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

//    	articles = articles + '<tr><td>'+ $(this).data('nombre') + '</td><td>' + pvp +'</td></tr>'
        $('#items_table > tbody:last, #screen_table > tbody:last').append('<tr><td>'+ $(this).data('nombre') + '</td><td class="text-right">' + pvp +'</td></tr>');
        ticket.total = ticket.total + Number(pvp)

    	var this_base = Number(pvp)/(1 + Number(iva)/100)
    	var this_iva = pvp - this_base
        var impuestos = ""

        ticket.bases[iva] = ticket.bases[iva] + this_base
        ticket.ivas[iva] = ticket.ivas[iva] + this_iva

        // empty tax table before updating
        $("#tax_table > tbody").empty();

        for (var i in ticket.bases) {
        	impuestos = impuestos + ticket.bases[i].toFixed(2) + ' &nbsp ' + i + '% &nbsp ' + ticket.ivas[i].toFixed(2) + '<br/>'
            $('#tax_table > tbody:last').append('<tr><td>'+ ticket.bases[i].toFixed(2) + '</td><td>' + i + '%</td><td>' + ticket.ivas[i].toFixed(2) +'</td></tr>');
        }

//        $('.articles').html(articles)
        $('.total').html(ticket.total.toFixed(2))
        // $('#impuestos').html(impuestos)

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

        $("#tax_table > tbody").empty();
        $("#screen_table > tbody").empty();
        $("#items_table > tbody").empty();
        $('#ticket_id').html("--")
        $('.total').html(0)

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
            $("#receipt").printThis()
        }
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
