loadPaymentMethods();
function loadPaymentMethods() {
	$.ajax({
		method:"GET",
		url:"https://api.mercadopago.com/sites/MLB/payment_methods",
		success: function(data)
		{
			var select = document.getElementById('select_payments');
			var i = data.length;
			while(--i)
			{
				if (data[i].id != "account_money")
				{
					var opt = new Option(data[i].name, data[i].id);
					opt.setAttribute('data-icon', data[i].thumbnail)
					select.appendChild(opt);	
				}
				
			}
			$('select').material_select();
		}
	})
}


