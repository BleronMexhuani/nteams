// src/pages/CreateBook.jsx
import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../api/api';

export default function CreateBook() {
  const navigate = useNavigate();
  const [authors, setAuthors] = useState([]);
  const [form, setForm] = useState({
    author_id: '',
    title: '',
    isbn: '',
    description: '',
    published_date: '',
    cover_url: '',
  });

  useEffect(() => {
    api.get('/authors').then(res => setAuthors(res.data.data || res.data));
  }, []);

  const handleChange = (e) => {
    setForm({...form, [e.target.name]: e.target.value});
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    await api.post('/books', form);
    navigate('/books');
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4 max-w-md">
      <h2 className="text-xl font-bold">Create New Book</h2>

      <select name="author_id" value={form.author_id} onChange={handleChange} className="w-full border p-2" required>
        <option value="">Select Author</option>
        {authors.map(author => <option key={author.id} value={author.id}>{author.name}</option>)}
      </select>
      <input name="title" value={form.title} onChange={handleChange} className="w-full border p-2" placeholder="Title" required />
      <input name="isbn" value={form.isbn} onChange={handleChange} className="w-full border p-2" placeholder="ISBN" />
      <textarea name="description" value={form.description} onChange={handleChange} className="w-full border p-2" placeholder="Description" />
      <input type="date" name="published_date" value={form.published_date} onChange={handleChange} className="w-full border p-2" />
      <input name="cover_url" value={form.cover_url} onChange={handleChange} className="w-full border p-2" placeholder="Cover URL" />

      <button type="submit" className="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
    </form>
  );
}
