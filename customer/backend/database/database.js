import mysql from 'mysql2'
import { databaseConfig } from '../config.js';
import Product from '../classes/Product.js'

class Database {
    $dbInstance;

    constructor() {
        this.connection = mysql.createConnection(databaseConfig);
        this.connection.connect((err) => {
            if (err) {
                console.error('Error connecting to the database:', err.message);
            } else {
                console.log('Connected to the database.');
            }
        });
    }

    static getInstance() {
        if (!Database.dbInstance) {
            Database.dbInstance = new Database();
        }
        return Database.dbInstance;
    }

    // login methoid
    async login(username, password) {
        const query = 'SELECT * FROM users WHERE username = ? AND password = ?';
        
        //make the arguments an array
        const params = [username, password]
        const result = await this.execute(query, params);

        return result[0];
    }
    async getAllProductsOfOrg(organizationID){
        const query = 'SELECT product_id, product_name,product_description, price, quantity, product_image FROM products WHERE organization_id =? AND status = "Available"';
    
        const params = [organizationID]
        try {
            const result = await this.execute(query, params);

            if(result.length == 0){
                return false;
            }

            const products =[];

            for (let i = 0; i< result.length; i++){
                const item = result[i];

                const product = new Product(
                    item.product_id, 
                    item.product_name, 
                    null,
                    null, 
                    item.price, 
                    item.quantity, 
                    item.product_image, 
                    null);
                products.push(product);
            }

            return products;
            
        } catch (error) {
            console.error('Error executing query:', error);
            return false;
        }
    }
    async getProductDetails(productID){
        const query = 'SELECT product_id, product_name, product_image, product_description, price, quantity FROM products WHERE product_id =?';
        const params = [productID];
        const result = await this.execute(query, params);
        return result[0];
    }
    async getProductPrice(productID) {
        const query = `SELECT price FROM products WHERE product_id = ?;`;
        const params = [productID];
        const result = await this.execute(query, params);
        return result[0];
    }
    async getFirstProductsOfEachOrg(){
        const query = `
                SELECT 
                    p.product_id, 
                    p.product_name,
                    p.product_description,
                    p.quantity,
                    p.price, 
                    p.organization_id,
                    p.product_image,
                    o.organization_name
                FROM (
                    SELECT 
                        product_id, 
                        product_name, 
                        product_description, 
                        quantity, 
                        price, 
                        organization_id, 
                        product_image, 
                        ROW_NUMBER() OVER (PARTITION BY organization_id ORDER BY product_id ASC) AS row_num 
                    FROM products WHERE status = 'Available'
                ) AS p
                JOIN organizations o USING(organization_id)
                WHERE p.row_num <= 4; `;   
        try {
            const results = await this.execute(query);
            return results; 

        }catch(err){
            console.log("Error executing queyr");
        }
    }
    async getValidSchedules(orgID) {
        const currentDateTime = new Date();
        const query = `
            SELECT schedule_id, date, start_time, end_time, location FROM organization_schedules 
            WHERE organization_id = ? 
            AND (
                date > CURRENT_DATE OR
                (date = CURRENT_DATE AND start_time > NOW())
            );
        `;

        const params = [orgID, currentDateTime, currentDateTime];

        try {
            const result = await this.execute(query, params);
            return result;
        } catch(error) {
            console.log("Failed to fetch schedules");
        }
    }
    async placeOrder(order) {
        try {
            await this.execute("START TRANSACTION");
    
            const orderQuery = `
                INSERT INTO orders (customer_id, created_at, total, status, claimed_at, schedule_id) 
                VALUES (?, NOW(), ?, 'Pending', NULL, ?);
            `;
    
            const orderParams = [
                order.customer_id,
                order.total,
                order.schedule_id,
            ];
    
            const result = await this.execute(orderQuery, orderParams);
    
            const orderID = result.insertId;
    
            const orderProductsQuery = `
                INSERT INTO order_products (order_id, product_id, quantity, total) 
                VALUES (?, ?, ?, ?);
            `;
    
            const orderProductsInsertPromises = order.products.map(product => {
                const orderProductsParams = [orderID, product.product_id, product.quantity, product.total];
                return this.execute(orderProductsQuery, orderProductsParams);
            });
    
            await Promise.all(orderProductsInsertPromises);
    
            await this.execute("COMMIT");
    
            return result;
        } catch (error) {
            await this.execute("ROLLBACK");
            console.error("Error placing order:", error);
        }
    }
    // ETO ANG TEMPLATE FOR EXECUTING A QUERY. returns a promise object
    execute(query, params = []) {       
        return new Promise((resolve, reject) => {
            this.connection.query(query, params, (err, results) => {
                if (err) {
                    return reject(err);
                }
                resolve(results);
            });
        });
    }
}

export default Database;