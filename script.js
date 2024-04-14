function changeQuantity(amount,index) {
    var quantityInput = document.getElementById('quantityInput-'+index);
    var quantity = document.getElementById('quantity-'+index);
    var currentQuantity = parseInt(quantityInput.value);
    
    if ((currentQuantity + amount) >= 1) {
        quantityInput.value = currentQuantity + amount;
        quantity.innerHTML=quantityInput.value

    }
    console.log(quantityInput.value)
  }
 