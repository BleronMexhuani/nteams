// src/pages/Authors.jsx
import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import api from '../api/api';

export default function Authors() {
  const [authors, setAuthors] = useState([]);
  const [search, setSearch] = useState('');
  const [sortBy, setSortBy] = useState('name');
  const [order, setOrder] = useState('asc');

  useEffect(() => {
    fetchAuthors();
  }, [search, sortBy, order]);

  const fetchAuthors = async () => {
    try {
      const response = await api.get('/authors', {
        params: {
          search,
          sort_by: sortBy,
          order,
        },
      });
      setAuthors(response.data.data || response.data); // depending on how your API formats
    } catch (error) {
      console.error('Failed to fetch authors', error);
    }
  };

  const deleteAuthor = async (id) => {
    if (!window.confirm('Are you sure you want to delete this author?')) return;
    await api.delete(`/authors/${id}`);
    fetchAuthors(); // refresh list
  };

  return (
    <div>
      <h1 className="text-2xl font-bold mb-4">Authors</h1>

      <div className="flex gap-4 mb-4">
        <input
          className="border px-2 py-1"
          type="text"
          placeholder="Search author..."
          value={search}
          onChange={(e) => setSearch(e.target.value)}
        />
        <select value={sortBy} onChange={(e) => setSortBy(e.target.value)} className="border px-2 py-1">
          <option value="name">Name</option>
          <option value="birthdate">Birthdate</option>
        </select>
        <select value={order} onChange={(e) => setOrder(e.target.value)} className="border px-2 py-1">
          <option value="asc">ASC</option>
          <option value="desc">DESC</option>
        </select>
      </div>

      <table className="w-full border text-left">
        <thead className="bg-gray-100">
          <tr>
            <th className="border px-4 py-2">Name</th>
            <th className="border px-4 py-2">Birthdate</th>
            <th className="border px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          {authors.map((author) => (
            <tr key={author.id}>
              <td className="border px-4 py-2">{author.name}</td>
              <td className="border px-4 py-2">{author.birthdate}</td>
              <td className="border px-4 py-2 space-x-2">
                <Link to={`/authors/${author.id}`} className="text-blue-600">View</Link>
                <Link to={`/authors/update/${author.id}`} className="text-yellow-600">Edit</Link>
                <button onClick={() => deleteAuthor(author.id)} className="text-red-600">Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
