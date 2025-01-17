function showOrderDetails(orderID, name, data) {
  const orderDetailsPopUp = document.querySelector(".order-details");
  orderDetailsPopUp.innerHTML = "";

  //Upper container
  const upperCont = document.createElement("div");
  upperCont.classList.add("upperCont");

  const orderNum = document.createElement("h5");
  orderNum.classList.add("orderNum");
  orderNum.textContent = "Order ID: " + orderID;
  upperCont.appendChild(orderNum);

  const close = document.createElement("button");
  close.classList.add("close-button");
  close.addEventListener("click", function () {
    orderDetailsPopUp.classList.remove("active"),
      orderDetailsPopUp.replaceChildren();
  });
  upperCont.appendChild(close);

  //lower container
  const cardsContainer = document.createElement("div");
  cardsContainer.classList.add("cards-grid");

  const custName = document.createElement("div");
  custName.classList.add("customer-name");
  custName.textContent = name + " Order List";
  cardsContainer.appendChild(custName);

  data.forEach((element) => {
    createCards(
      element["product_image_base64"],
      element["product_name"],
      element["quantity"],
      element["total"],
      cardsContainer
    );
  });

  orderDetailsPopUp.appendChild(upperCont);
  orderDetailsPopUp.appendChild(cardsContainer);
}

//================================================
function createCards(
  imgsrc,
  productName,
  productQuantity,
  productTotal,
  cardContainer
) {
  const card = document.createElement("div");
  card.classList.add("order-card");

  //product image
  const image = document.createElement("img");
  image.classList.add("product-image");
  image.src = "data:image/png;base64," + imgsrc;
  console.log("Base64 Image:", imgsrc);
  card.appendChild(image);

  //product name
  const prodName = document.createElement("h4");
  prodName.classList.add("product-name");
  prodName.textContent = productName;
  card.appendChild(prodName);

  //product quantity
  const quantity = document.createElement("p");
  quantity.classList.add("product-quantity");
  quantity.textContent = "Qty: " + productQuantity;
  card.appendChild(quantity);

  //total
  const total = document.createElement("p");
  total.classList.add("total-price");
  total.textContent = "Total: " + productTotal;
  card.appendChild(total);

  cardContainer.appendChild(card);
}
