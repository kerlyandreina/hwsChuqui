const Product = require('../models/Product');

// Get all products
const getAllProducts = async (req, res) => {
    try {
        const products = await Product.find();
        res.status(200).json({
            success: true,
            count: products.length,
            data: products
        });
    } catch (error) {
        res.status(500).json({
            success: false,
            message: 'Error getting products',
            error: error.message
        });
    }
};

// Find product by name and calculate days until expiration
const findProduct = async (req, res) => {
    try {
        const { name } = req.params;
        
        const product = await Product.findOne({ 
            name: { $regex: name, $options: 'i' } 
        });

        if (!product) {
            return res.status(404).json({
                success: false,
                message: 'Product not found'
            });
        }

        // Calculate days until expiration
        const today = new Date();
        const expirationDate = new Date(product.dateExpiration);
        const timeDiff = expirationDate.getTime() - today.getTime();
        const daysRemaining = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

        // Update product with days until expiration
        product.daysExpiration = daysRemaining;
        await product.save();

        res.status(200).json({
            success: true,
            data: {
                _id: product._id,
                name: product.name,
                price: product.price,
                dateExpiration: product.dateExpiration,
                daysExpiration: daysRemaining
            }
        });
    } catch (error) {
        res.status(500).json({
            success: false,
            message: 'Error finding product',
            error: error.message
        });
    }
};

// Find product by ID and calculate days until expiration
const findProductById = async (req, res) => {
    try {
        const { id } = req.params;
        
        const product = await Product.findById(id);

        if (!product) {
            return res.status(404).json({
                success: false,
                message: 'Product not found'
            });
        }

        // Calculate days until expiration
        const today = new Date();
        const expirationDate = new Date(product.dateExpiration);
        const timeDiff = expirationDate.getTime() - today.getTime();
        const daysRemaining = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

        // Update product with days until expiration
        product.daysExpiration = daysRemaining;
        await product.save();

        res.status(200).json({
            success: true,
            data: {
                _id: product._id,
                name: product.name,
                price: product.price,
                dateExpiration: product.dateExpiration,
                daysExpiration: daysRemaining
            }
        });
    } catch (error) {
        res.status(500).json({
            success: false,
            message: 'Error finding product',
            error: error.message
        });
    }
};

// Create a new product
const createProduct = async (req, res) => {
    try {
        const { name, price, dateExpiration } = req.body;

        const product = await Product.create({
            name,
            price,
            dateExpiration,
            daysExpiration: null
        });

        res.status(201).json({
            success: true,
            message: 'Product created successfully',
            data: product
        });
    } catch (error) {
        res.status(500).json({
            success: false,
            message: 'Error creating product',
            error: error.message
        });
    }
};

module.exports = {
    getAllProducts,
    findProduct,
    findProductById,
    createProduct
};
