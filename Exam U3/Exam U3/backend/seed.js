const mongoose = require('mongoose');
const Product = require('./models/Product');
const products = require('./data/products.json');
const connectDB = require('./config/database');

// Conectamos a la base de datos
connectDB().then(async () => {
    try {
        // Borramos los datos antiguos por si acaso
        await Product.deleteMany();
        console.log('Datos antiguos borrados.');

        // Insertamos los datos del archivo products.json
        await Product.insertMany(products);
        console.log('¡Productos importados correctamente a tu nueva base de datos!');
        
        process.exit();
    } catch (error) {
        console.error('Error al importar:', error);
        process.exit(1);
    }
});
