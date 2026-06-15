const mongoose = require('mongoose');

const NotebooksSchema = new mongoose.Schema({
  id: { type: Number, required: true, unique: true },
  title: { type: String, required: true },
  author: { type: String, required: true },
  pages: { type: Number, required: true },
  coverType: { type: String, required: true },
  genre: { type: String, required: true },
  language: { type: String, required: true },
  publisher: { type: String, required: true },
  year: { type: Number, required: true },
  price: { type: Number, required: true },

}, { collection: 'notebooks' });

module.exports = mongoose.model('Notebooks', NotebooksSchema);
