// Frontend MVC - Controller
const API_URL = '/api/products';

// Model - Data handling
const ProductModel = {
    async getAllProducts() {
        try {
            const response = await fetch(API_URL);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error fetching products:', error);
            throw error;
        }
    },

    async findProductByName(name) {
        try {
            const response = await fetch(`${API_URL}/search/${encodeURIComponent(name)}`);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error finding product:', error);
            throw error;
        }
    },

    async findProductById(id) {
        try {
            const response = await fetch(`${API_URL}/${id}`);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error finding product by ID:', error);
            throw error;
        }
    }
};

// View - UI Rendering
const ProductView = {
    elements: {
        searchInput: document.getElementById('searchInput'),
        findBtn: document.getElementById('findBtn'),
        cancelBtn: document.getElementById('cancelBtn'),
        resultSection: document.getElementById('resultSection'),
        productResult: document.getElementById('productResult'),
        loadProductsBtn: document.getElementById('loadProductsBtn'),
        productsList: document.getElementById('productsList')
    },

    showLoading(container) {
        container.innerHTML = '<div class="loading">Loading...</div>';
    },

    showError(container, message) {
        container.innerHTML = `<div class="error-message">❌ ${message}</div>`;
    },

    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
    },

    getDaysClass(days) {
        if (days < 0) return 'expired';
        if (days <= 7) return 'danger';
        if (days <= 30) return 'warning';
        return 'safe';
    },

    getDaysMessage(days) {
        if (days < 0) return ` EXPIRED ${Math.abs(days)} days ago`;
        if (days === 0) return ' EXPIRES TODAY!';
        if (days === 1) return ' Expires tomorrow!';
        return ` ${days} days remaining`;
    },

    renderProduct(product) {
        const daysClass = this.getDaysClass(product.daysExpiration);
        const daysMessage = this.getDaysMessage(product.daysExpiration);

        this.elements.productResult.innerHTML = `
            <h3 class="product-name"> ${product.name}</h3>
            <div class="product-info">
                <div class="info-item">
                    <span class="info-label"> Price:</span>
                    <span class="info-value">$${product.price.toFixed(2)}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"> Expiration Date:</span>
                    <span class="info-value">${this.formatDate(product.dateExpiration)}</span>
                </div>
            </div>
            <div class="days-remaining ${daysClass}">
                ${daysMessage}
            </div>
        `;

        this.elements.resultSection.classList.remove('hidden');
    },

    hideResult() {
        this.elements.resultSection.classList.add('hidden');
        this.elements.productResult.innerHTML = '';
    },

    clearSearch() {
        this.elements.searchInput.value = '';
    },

    renderProductsList(products) {
        if (products.length === 0) {
            this.elements.productsList.innerHTML = '<p>No products available.</p>';
            return;
        }

        this.elements.productsList.innerHTML = products.map(product => `
            <div class="product-item" data-id="${product._id}" data-name="${product.name}">
                <h3> ${product.name}</h3>
                <p class="price">$${product.price.toFixed(2)}</p>
                <p> Expires: ${this.formatDate(product.dateExpiration)}</p>
                <p style="font-size: 0.8rem; color: #888;">Click to see days remaining</p>
            </div>
        `).join('');
    }
};

// Controller - Application Logic
const ProductController = {
    init() {
        this.bindEvents();
        console.log('Application initialized successfully');
    },

    bindEvents() {
        // Event: Find product
        ProductView.elements.findBtn.addEventListener('click', () => {
            this.handleSearch();
        });

        // Event: Enter key in search
        ProductView.elements.searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.handleSearch();
            }
        });

        // Event: Cancel search
        ProductView.elements.cancelBtn.addEventListener('click', () => {
            this.handleCancelSearch();
        });

        // Event: Load all products
        ProductView.elements.loadProductsBtn.addEventListener('click', () => {
            this.loadAllProducts();
        });

        // Event: Click on product in list
        ProductView.elements.productsList.addEventListener('click', (e) => {
            const productItem = e.target.closest('.product-item');
            if (productItem) {
                const productId = productItem.dataset.id;
                this.handleProductClick(productId);
            }
        });
    },

    async handleSearch() {
        const searchTerm = ProductView.elements.searchInput.value.trim();

        if (!searchTerm) {
            alert('Please enter the product name to search.');
            return;
        }

        ProductView.showLoading(ProductView.elements.productResult);
        ProductView.elements.resultSection.classList.remove('hidden');

        try {
            const result = await ProductModel.findProductByName(searchTerm);

            if (result.success) {
                ProductView.renderProduct(result.data);
            } else {
                ProductView.showError(ProductView.elements.productResult, result.message);
            }
        } catch (error) {
            ProductView.showError(ProductView.elements.productResult, 'Server connection error');
        }
    },

    handleCancelSearch() {
        ProductView.clearSearch();
        ProductView.hideResult();
    },

    async loadAllProducts() {
        ProductView.showLoading(ProductView.elements.productsList);

        try {
            const result = await ProductModel.getAllProducts();

            if (result.success) {
                ProductView.renderProductsList(result.data);
            } else {
                ProductView.showError(ProductView.elements.productsList, 'Error loading products');
            }
        } catch (error) {
            ProductView.showError(ProductView.elements.productsList, 'Server connection error');
        }
    },

    async handleProductClick(productId) {
        ProductView.showLoading(ProductView.elements.productResult);
        ProductView.elements.resultSection.classList.remove('hidden');

        try {
            const result = await ProductModel.findProductById(productId);

            if (result.success) {
                ProductView.renderProduct(result.data);
                // Scroll to result
                ProductView.elements.resultSection.scrollIntoView({ behavior: 'smooth' });
            } else {
                ProductView.showError(ProductView.elements.productResult, result.message);
            }
        } catch (error) {
            ProductView.showError(ProductView.elements.productResult, 'Server connection error');
        }
    }
};

// Initialize the application when the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    ProductController.init();
});
