const express = require('express');
const router = express.Router();
const {
    getAllProducts,
    findProduct,
    findProductById,
    createProduct
} = require('../controllers/productController');

// GET - Get all products
router.get('/', getAllProducts);

// GET - Find product by name
router.get('/search/:name', findProduct);

// GET - Find product by ID
router.get('/:id', findProductById);

// POST - Create a new product
router.post('/', createProduct);

module.exports = router;
