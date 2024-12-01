document.addEventListener('DOMContentLoaded', function () {
  const currentPath = window.location.pathname;
  if (currentPath.includes('/pages/mycart.html')) {
    showCart(); 
  }
});

const data = {
  orgArray: [
    {
      organization_name: "ICON",
      organization_id: "1",
      products: [
        {
          product_id: 1,
          product_name: "ICON Hoodie", // Example name
          product_image: "../resources/images/products/hoodie.png", // Replace with actual blob URL or data
          product_price: 200,
          product_quantity: 10,
          total: 2000
        },
        {
          product_id: 2,
          product_name: "ICON Hoodie", // Example name
          product_image: "../resources/images/products/hoodie.png", // Replace with actual blob URL or data
          product_price: 150,
          product_quantity: 5,
          total: 750
        }
      ]
    },
    {
      organization_name: "KASAMA",
      organization_id: "3",
      products: [
        {
          product_id: 3,
          product_name: "KASAMA Tumbler", // Example name
          product_image: "../resources/images/products/hoodie.png", // Replace with actual blob URL or data
          product_price: 300,
          product_quantity: 2,
          total: 600
        },
        {
          product_id: 4,
          product_name: "Product 4", // Example name
          product_image: "../resources/images/products/hoodie.png", // Replace with actual blob URL or data
          product_price: 100,
          product_quantity: 20,
          total: 2000
        }
      ]
    }
  ]
};

function showCart(){
  const mainContainer =  document.querySelector('.card-content-container');

  const innerContainer = document.createElement('div');
  innerContainer.classList.add("inner-container");

  //Card Header
  const cardHeader = document.createElement('div');
  cardHeader.classList.add('card-header');

  const cardTitle = document.createElement('h1');
  cardTitle.textContent = "Your Cart";
  cardHeader.appendChild(cardTitle);

  const cardHeaderImage = document.createElement('img');
  cardHeaderImage.src = "../resources/images/cart/cart-header-icon.png";
  cardHeader.appendChild(cardHeaderImage);
  innerContainer.appendChild(cardHeader);

  //Item Cards
  data.orgArray.forEach((datum) => {
    const itemCardContainer = document.createElement('div');
    itemCardContainer.classList.add('item-card-container');

    const innerItemCardContainer = document.createElement('div');
    innerItemCardContainer.classList.add('inner-item-card-container');

    //product title
    const productTitle = document.createElement('div');
    productTitle.classList.add('product-title'); 

    //Left Header
    const leftHeader = document.createElement('h1');
    leftHeader.classList.add('booth-name')
    leftHeader.textContent = `Item's from ${datum.organization_name}`;

    productTitle.appendChild(leftHeader);

    //Right Header
    const rightHeader = document.createElement('div');
    rightHeader.classList.add('column-headers');

    const columnHeaderPrice = document.createElement('h1');
    columnHeaderPrice.classList.add("column-price-header");
    columnHeaderPrice.textContent = "Price";
    rightHeader.appendChild(columnHeaderPrice);

    const columnHeaderQuantity = document.createElement('h1');
    columnHeaderQuantity.classList.add("column-quantity-header");
    columnHeaderQuantity.textContent = "Quantity";
    rightHeader.appendChild(columnHeaderQuantity);

    const columnHeaderTotal = document.createElement('h1');
    columnHeaderTotal.classList.add("column-total-header");
    columnHeaderTotal.textContent = "Total";
    rightHeader.appendChild(columnHeaderTotal);

    productTitle.appendChild(rightHeader);

    innerItemCardContainer.appendChild(productTitle);

    itemCardContainer.appendChild(innerItemCardContainer);

    datum.products.forEach((product) => {
      const productContainer = document.createElement('div');
      productContainer.classList.add('product-container');

      //product info
      const productInfoContainer = document.createElement('div');
      productInfoContainer.classList.add('product-info-container');

      const imageContainer = document.createElement('div');
      imageContainer.classList.add('image-container');

      const productImage = document.createElement('img');
      productImage.src = product.product_image;
      imageContainer.appendChild(productImage);

      const productName = document.createElement('p');
      productName.textContent = product.product_name;

      productInfoContainer.appendChild(imageContainer);
      productInfoContainer.appendChild(productName);

      //product actions
      const productActionsContainer = document.createElement('div');
      productActionsContainer.classList.add('product-actions-container');

      //Product Price
      const productPrice = document.createElement('p');
      productPrice.classList.add('product-price');
      productPrice.textContent = `P ${product.product_price}`;
      productActionsContainer.appendChild(productPrice);

      //Product Quantity
      const productQuantity = document.createElement('div');
      productQuantity.classList.add('product-quantity');

      const minusButton = document.createElement("button");
      minusButton.classList.add("qty-count--minus");
      minusButton.textContent = "-";
      productQuantity.appendChild(minusButton);

      const quantityInput = document.createElement("input");
      quantityInput.classList.add("input-box");
      quantityInput.setAttribute("type", "number");
      quantityInput.setAttribute("min", "1");
      quantityInput.setAttribute("value", product.product_quantity);
      quantityInput.setAttribute("max", product.product_quantity);
      productQuantity.appendChild(quantityInput);

      const plusButton = document.createElement("button");
      plusButton.classList.add("qty-count--plus");
      plusButton.textContent = "+";
      productQuantity.appendChild(plusButton);

      productActionsContainer.appendChild(productQuantity);
       
      plusButton.addEventListener("click", () => {
        let currentQuantity = parseInt(quantityInput.value);
        if(currentQuantity < product.product_quantity){
          currentQuantity++;
          quantityInput.value = currentQuantity;
          updateTotal(quantityInput.value, product.product_price);
          updateSubTotal();
        }
      });

      minusButton.addEventListener("click", () => {
        let currentQuantity = parseInt(quantityInput.value);
        if(currentQuantity > 1){
          currentQuantity--;
          quantityInput.value = currentQuantity;
          updateTotal(quantityInput.value, product.product_price);
          updateSubTotal();
        }
      });

      function updateTotal(quantity,price){
        let productPriceTotal = quantity * price;
        productTotal.textContent =`P${productPriceTotal}`;
        product.total = productPriceTotal;
      }

      function updateSubTotal(){
        let subtotal = datum.products.reduce((acc, product) => acc + product.total, 0);
        priceTotal.textContent = `P${subtotal}`;
      }

      //Product Total
      const productTotal = document.createElement('p')
      productTotal.classList.add('product-total');
      productTotal.textContent = `P${product.total}`;
      productActionsContainer.appendChild(productTotal);

      productContainer.appendChild(productInfoContainer);
      productContainer.appendChild(productActionsContainer);

      innerItemCardContainer.appendChild(productContainer);
      itemCardContainer.appendChild(innerItemCardContainer);
    });

    //Item Card Footer
    const itemCardFooter  = document.createElement('div');
    itemCardFooter.classList.add('item-card-footer');

    const subtotalSection = document.createElement('div')
    subtotalSection.classList.add('subtotal-section');

    const priceTotalLabel = document.createElement('p');
    priceTotalLabel.textContent = "Subtotal";
    subtotalSection.appendChild(priceTotalLabel);

    //Computes for the subtotal
    const totalPrice = datum.products.reduce((acc, product) => acc + product.total, 0);

    const priceTotal = document.createElement('p');
    priceTotal.textContent = `P${totalPrice}`;
    subtotalSection.appendChild(priceTotal);

    itemCardFooter.appendChild(subtotalSection);

    const checkoutButton = document.createElement('button');
    checkoutButton.classList.add('checkout-button');
    checkoutButton.textContent = "CHECKOUT";
    itemCardFooter.appendChild(checkoutButton);

    innerItemCardContainer.appendChild(itemCardFooter);
    itemCardContainer.appendChild(innerItemCardContainer);

    innerContainer.appendChild(itemCardContainer);
  });

  mainContainer.appendChild(innerContainer);
}