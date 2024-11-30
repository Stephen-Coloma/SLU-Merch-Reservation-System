import Database from "../database/database.js";

//to be implemented by stephen
const seeAllProductsController = async(req, res)=>{
    const db = Database.getInstance();
    const result =  await db.getAllProductsOfOrg(req.params.orgid);

    if(result){
        res.json(result)
    }else{
        res.send(200)
    }    
}

//to be implemented by leonhard
const viewProductController = async(req, res)=>{
    try {
        const orgID = req.params.orgid;
        const prodID = req.params.prodid;
        
        const db = Database.getInstance();

        const result = await db.getProductDetails(prodID);

        if (result) {
            return res.status(200).json({
                org_id: orgID,
                product_id: prodID,
                product_name: result.product_name,
                product_image: result.product_image,
                product_description: result.product_description,
                product_price: result.price,
                product_quantity: result.quantity,
            });
        } else {
            return res.status(400).json({
                message: "Product not found",
            });
        }
    } catch(error) {
        return res.status(500).json({
            message: "Internal Server Error",
            error: error.message,
        });
    }
}

const completeOrderController = async(req, res) => {
    try {
        const order = req.body;

        const db = Database.getInstance();

        let overallTotal = 0;
        const products = order.products;

        for (const product of products) {
            const price = await db.getProductPrice(product.product_id);
            const productTotal = product.quantity * price;

            product.total = productTotal;
            overallTotal += productTotal;
        }

        const createdAt = new Date().toISOString();

        const orderData = {
            customer_id: order.user_id,
            created_at: createdAt,
            total: overallTotal,
            status: 'Pending',
            claimed_at: null,
            schedule_id: order.schedule_id,
            products: products,
        };

        const result = await db.placeOrder(orderData);

        if (result) {
            return res.status(200).json({
                message: "Order placed successfully"
            });
        } else {
            return res.status(400).json({
                message: "Failed to handle request"
            });
        }
    } catch(error) {
        return res.status(500).json({
            message: "Internal Server Error",
            error: error.message,
        });
    }
}

export  {seeAllProductsController, viewProductController, completeOrderController};