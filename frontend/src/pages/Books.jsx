// src/pages/Books.jsx
import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import api from '../api/api';

export default function Books() {
  const [books, setBooks] = useState([]);
  const [authors, setAuthors] = useState([]);
  const [search, setSearch] = useState('');
  const [author, setAuthor] = useState('');
  const [year, setYear] = useState('');
  const [sortBy, setSortBy] = useState('title');
  const [order, setOrder] = useState('asc');

  useEffect(() => {
    fetchAuthors();
    fetchBooks();
  }, [search, author, year, sortBy, order]);

  const fetchAuthors = async () => {
    const res = await api.get('/authors');
    setAuthors(res.data.data || res.data);
  };

  const fetchBooks = async () => {
    const res = await api.get('/books', {
      params: { search, author, year, sort_by: sortBy, order },
    });
    setBooks(res.data.data || res.data);
  };

  const deleteBook = async (id) => {
    if (!window.confirm('Delete this book?')) return;
    await api.delete(`/books/${id}`);
    fetchBooks();
  };

  return (
    <div>
      <h1 className="text-2xl font-bold mb-4">Books</h1>

      <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
        <input className="border p-2" placeholder="Search..." value={search} onChange={e => setSearch(e.target.value)} />
        <select className="border p-2" value={author} onChange={e => setAuthor(e.target.value)}>
          <option value="">All Authors</option>
          {authors.map(a => <option key={a.id} value={a.id}>{a.name}</option>)}
        </select>
        <input className="border p-2" placeholder="Year" value={year} onChange={e => setYear(e.target.value)} />
        <div className="flex gap-2">
          <select value={sortBy} onChange={e => setSortBy(e.target.value)} className="border p-2">
            <option value="title">Title</option>
            <option value="published_date">Published</option>
          </select>
          <select value={order} onChange={e => setOrder(e.target.value)} className="border p-2">
            <option value="asc">ASC</option>
            <option value="desc">DESC</option>
          </select>
        </div>
      </div>

      <table className="w-full border text-left">
        <thead className="bg-gray-100">
          <tr>
            <th className="border px-4 py-2">Title</th>
            <th className="border px-4 py-2">Author</th>
            <th className="border px-4 py-2">Year</th>
            <th className="border px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          {books.map(book => (
            <tr key={book.id}>
              <td className="border px-4 py-2">{book.title}</td>
              <td className="border px-4 py-2">{book.author.name}</td>
              <td className="border px-4 py-2">{book.published_date}</td>
              <td className="border px-4 py-2 space-x-2">
                <Link to={`/books/${book.id}`} className="text-blue-600">View</Link>
                <Link to={`/books/update/${book.id}`} className="text-yellow-600">Edit</Link>
                <button onClick={() => deleteBook(book.id)} className="text-red-600">Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
