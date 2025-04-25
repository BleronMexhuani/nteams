// src/pages/CreateAuthor.jsx
import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../api/api';

export default function CreateAuthor() {
  const navigate = useNavigate();
  const [form, setForm] = useState({
    name: '',
    biography: '',
    birthdate: '',
  });

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    await api.post('/authors', form);
    navigate('/authors');
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4 max-w-md">
      <h2 className="text-xl font-bold">Create New Author</h2>

      <input name="name" onChange={handleChange} value={form.name} className="w-full border p-2" placeholder="Name" required />
      <textarea name="biography" onChange={handleChange} value={form.biography} className="w-full border p-2" placeholder="Biography" required />
      <input type="date" name="birthdate" onChange={handleChange} value={form.birthdate} className="w-full border p-2" required />

      <button type="submit" className="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
    </form>
  );
}
