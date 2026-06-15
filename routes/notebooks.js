const express = require('express');
const router = express.Router();
const Notebook = require('../models/Notebook');


// GET /api/notebooks  - Listar todos los notebooks
router.get('/', async (req, res) => {
    try {
        const notebooks = await Notebook.find({});
        res.json(notebooks);
    } catch (error) {
        res.status(500).json({ message: 'Server error', error });
    }
});

// POST /api/notebooks  - Crear un nuevo notebook
router.post('/', async (req, res) => {
    try {
        const notebook = new Notebook(req.body);
        const saved = await notebook.save();
        res.status(201).json(saved);
    } catch (error) {
        res.status(400).json({ message: 'Error al crear notebook', error });
    }
});

// GET /api/notebooks/:id  - Buscar un notebook por id
router.get('/:id', async (req, res) => {
    try {
        console.log('Search by id:', parseInt(req.params.id));
        const notebook = await Notebook.findOne({ id: parseInt(req.params.id) });
        if (!notebook) {
            return res.status(404).json({ message: 'Notebook not found' });
        }
        res.json(notebook);
    } catch (error) {
        res.status(500).json({ message: 'Server error', error });
    }
});

// PUT /api/notebooks/:id  - Actualizar un notebook por id
router.put('/:id', async (req, res) => {
    try {
        const updated = await Notebook.findOneAndUpdate(
            { id: parseInt(req.params.id) },
            req.body,
            { new: true, runValidators: true }
        );
        if (!updated) {
            return res.status(404).json({ message: 'Notebook not found' });
        }
        res.json(updated);
    } catch (error) {
        res.status(400).json({ message: 'Error al actualizar notebook', error });
    }
});

// DELETE /api/notebooks/:id  - Eliminar un notebook por id
router.delete('/:id', async (req, res) => {
    try {
        const deleted = await Notebook.findOneAndDelete({ id: parseInt(req.params.id) });
        if (!deleted) {
            return res.status(404).json({ message: 'Notebook not found' });
        }
        res.json({ message: 'Notebook eliminado exitosamente', notebook: deleted });
    } catch (error) {
        res.status(500).json({ message: 'Server error', error });
    }
});


module.exports = router;

