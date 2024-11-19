<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order History</title>
        <link rel="stylesheet" href="../../assets/css/globals.css">
        <link rel="stylesheet" href="../../assets/css/order-history.css">
    </head>
    <body>
        <?php
            include('../orders/orders-backend.php');
            include('../sidenav/side-nav-backend.php');
            include('../sidenav/side-nav.php');
            include('../order-details/order-details.php');
            include('../order-history/filter.php');
        ?>

        <section id="left-container">
            <?php
                include('../topbar/topbar.php')
            ?>

            <main id="orders-content">
                <div class="top-container">
                    <h2>Orders</h2>
                    <!-- INPUT FOR SEARCH -->
                    <div class="search-container">

                        <input type="text" id="order-search" size="30" placeholder="Search by Name or Order ID">
                        <img class="filter" id="filter-image" src="../../assets/images/orders-icons/filter-horizontal-svgrepo-com.svg" alt="">

                    </div>
                </div>
                <div class="orders-container"></div>
                <div class="page-number">
                    <button class="previous-button">Prev</button>
                    <div class="pages-container"></div>
                    <button class="next-button">Next</button>
                </div>
            </main>
        </section>

        <script src="../order-details-popup/order-details.js"></script>
        <script src="../order-history/filter.js"></script>

        <script type="module">
            
            <?php
                
                $db = Database::getInstance();
               
                $orders = $db -> getClaimedOrders($_SESSION['ORG_ID']); 
                $data = $db -> getClaimedProducts($_SESSION['ORG_ID']); 
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $selectedRadio = isset($_POST['selectedRadio']) ? $_POST['selectedRadio'] : 'All Time';
                    $selectedLocation = isset($_POST['selectedLocation']) ? $_POST['selectedLocation'] : 'All';
            
                    $filtersArray = [$selectedLocation,$selectedRadio];

                
                    $orders = $db->getClaimedOrdersFiltered($_SESSION['ORG_ID'], $filtersArray);
                    $data = $db->getClaimedProducts($_SESSION['ORG_ID']);
                }    
            ?>        

            const orders = <?php echo json_encode($orders);?>;
            console.log(orders);

            //sample data, you can modify it to simulate certain cases
            // const orders = [{first_name: "One", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "First"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Second"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"}, 
            //                 {first_name: "Two", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Three", order_id: 4, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"}, 
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Four", order_id: 3, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"}, 
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Five", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 3, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Six", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"}, 
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Seven", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"}, 
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 3, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Eight", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Nine", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"}, 
            //                 {first_name: "Sanchie", order_id: 2, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Sample MIddle"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Ten", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"}, 
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Eleven", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 3, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"}, 
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Twelve", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"}, 
            //                 {first_name: "Sanchie", order_id: 8, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Thirteen", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 9, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 10, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 11, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Fourteen", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 14, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 1, created_at: "11/12/2024", status: "Pending", location: "Devesse Lobby"},
            //                 {first_name: "Sanchie", order_id: 17, created_at: "11/12/2024", status: "Pending", location: "Sample Last"}, 
            //             ]
            

            window.onload = function () {
                displayOrdersForPage(1,orders); // Display the first page onload
                addPageButtons(orders)
                const searchInput = document.getElementById('order-search');
                searchInput.addEventListener('input', searchOrders); 
            };

            function displayOrdersForPage(pageNumber, orders) {
                const ordersContainer = document.querySelector('.orders-container');
                ordersContainer.innerHTML = '';  // Clear previous orders

                const ordersPerPage = 8;
                const start = (pageNumber - 1) * ordersPerPage; //determines the first index of the array to be shown
                const end = start + ordersPerPage; //determines the last index of the array that is not going to be shown

                const pageOrders = orders.slice(start, end);//splits the orders into necessary starting and ending point 
                pageOrders.forEach(order => {
                    addCard(order.first_name, order.order_id, order.created_at, order.status, order.location);
                });
            }

            function addCard(name, orderId, orderDateValue, statusValue, locationName) {
            const container = document.querySelector(".orders-container");

            const newDiv = document.createElement("div");
            newDiv.classList.add("card");

            const vName = document.createElement("h4");
            vName.classList.add("vendor-name");
            vName.textContent = name;
            newDiv.appendChild(vName);

            const oID = document.createElement("p");
            oID.classList.add("order-id");
            oID.textContent = "Order ID: "+orderId;
            newDiv.appendChild(oID);

            // a grid for the details of an order
            const gridContainer = document.createElement('div');    
            gridContainer.classList.add("details-grid");
                
            const locationLabel = document.createElement('p');
            locationLabel.textContent = "Pick up Location";
            gridContainer.appendChild(locationLabel);

            const location = document.createElement('p');
            location.textContent=locationName;
            gridContainer.appendChild(location);

            const dateLabel = document.createElement('p');
            dateLabel.textContent = "Ordered at";
            gridContainer.appendChild(dateLabel);

            const orderDate = document.createElement("p");
            orderDate.classList.add("order-date");
            orderDate.textContent = orderDateValue;
            gridContainer.appendChild(orderDate);

            const statusLabel = document.createElement('p');
            statusLabel.textContent = "Status";
            gridContainer.appendChild(statusLabel);

            const status = document.createElement("p");
            status.classList.add("status");
            status.textContent = statusValue;
            gridContainer.appendChild(status);

            newDiv.appendChild(gridContainer)

            const viewButton = document.createElement("button");
            viewButton.classList.add("view-button");
            viewButton.textContent = "View Order List";
        
            const popUpCard = document.querySelector('.order-details');
        
            viewButton.addEventListener('click', function(){  
                popUpCard.classList.add('active');
                
                const data = <?php echo json_encode($data);?>
                
                console.log(data);

                productsCard(data, orderId);
            
            })

            newDiv.appendChild(viewButton); 

            container.appendChild(newDiv);
            }
  
            function productsCard(data, orderIden){
                const filtered = data.filter(data => data['order_id'] === orderIden);
                console.log(filtered)
                showOrderDetails(filtered[0].order_id, filtered[0].first_name, filtered)
                
            }

            function addPageButtons(ordersSample){
                const pagesContainer = document.querySelector('.pages-container');
                const ordersPerPage = 8;
                const totalPages = Math.ceil(ordersSample.length / ordersPerPage);
                const maxButtons =11;
               
                function renderButtons(currentPageNumber) {
                    pagesContainer.innerHTML = '';
                    let startPage = 1;
                    let endPage = totalPages;
                    if(totalPages>maxButtons){
                        if(currentPageNumber<=6){ //page 1-6 show 1-9 buttons
                        startPage = 1;
                        endPage = 9;
                        }else if(currentPageNumber>= totalPages - 5){ //16 buttons, in 16th it shows 8-16
                            startPage =totalPages-8;
                            endPage =totalPages;

                        }else{//middle
                            startPage = currentPageNumber-4;
                            endPage =currentPageNumber+4;
                        }
                    }

                    if (startPage > 1) {
                        //always display first button
                        const firstButton = document.createElement('button');
                        firstButton.textContent = '1';
                        firstButton.addEventListener('click', () => {
                            displayOrdersForPage(1, ordersSample);
                            renderButtons(1);
                        });
                        pagesContainer.appendChild(firstButton);
                        //display ellipsis whenever second button is not 2
                        if (startPage > 2) {
                            const ellipsis = document.createElement('span');
                            ellipsis.textContent = '...';
                            ellipsis.classList.add('ellipsis');
                            pagesContainer.appendChild(ellipsis);
                        }
                    }

                    for (let i = startPage; i <= endPage; i++) {
                        const pageButton = document.createElement('button');
                        pageButton.textContent = i;
                        if (i === currentPageNumber) pageButton.classList.add('active');
                        
                        pageButton.addEventListener('click', () => {
                            currentPage = i;
                            displayOrdersForPage(i, ordersSample);
                            renderButtons(i);
                            pageButton.classList.add('active');/* -------------- */
                        });

                        pagesContainer.appendChild(pageButton);
                     }
                    
                    if (endPage < totalPages) {
                        //also adds an ellipsis in the end
                        if (endPage < totalPages - 1) {
                            const ellipsis = document.createElement('span');
                            ellipsis.textContent = '...';
                            ellipsis.classList.add('ellipsis');
                            pagesContainer.appendChild(ellipsis);
                        }

                        const lastButton = document.createElement('button');
                        lastButton.textContent = totalPages;
                        lastButton.addEventListener('click', () => {
                            currentPage = totalPages;
                            displayOrdersForPage(totalPages, ordersSample);
                            renderButtons(totalPages);
                        });
                        pagesContainer.appendChild(lastButton);
                    }

                }
                renderButtons(currentPage);  // Initialize buttons for the first page
            }
           
            let searchedOrders = []; 

            function searchOrders() {
                const searchTerm = document.getElementById('order-search').value.toLowerCase();
             
                console.log("Search Term:", searchTerm);
                //filter based on search
                searchedOrders = orders.filter(order => {
                    const orderIdMatch = order.order_id.toString().includes(searchTerm);
                    const orderBuyer = order.first_name.toLowerCase().includes(searchTerm);
                    const searchedOrder = orderIdMatch || orderBuyer;
                    if (searchedOrder) {
                        // console.log("Order buyer: ", orderBuyer);
                        // console.log("Matched Order:", order);  // Debug statement for matched order
                        console.log(searchedOrder);
                    }
                    return searchedOrder;
                });

                console.log("Filtered Orders:", searchedOrders);
                displayOrdersForPage(1, searchedOrders);  
                addPageButtons(searchedOrders);  
            }

            let currentPage = 1;

            //logic for pagination updates
            function updatePagination(orders, direction = null) {
                const totalPages = Math.ceil(orders.length / 8);

                if (direction === 'next' && currentPage < totalPages) {
                    currentPage++;
                } else if (direction === 'previous' && currentPage > 1) {
                    currentPage--;
                }

                displayOrdersForPage(currentPage, orders);
                addPageButtons(orders);
            }

            // event listeners for next and previous buttons
            document.querySelector('.previous-button').addEventListener('click', () => {
                const ordersToDisplay = filteredOrders.length ? filteredOrders : orders;
                updatePagination(ordersToDisplay, 'previous');
            });

            document.querySelector('.next-button').addEventListener('click', () => {
                const ordersToDisplay = filteredOrders.length ? filteredOrders : orders;
                updatePagination(ordersToDisplay, 'next');
            });

        </script>
    </body>
    </html>