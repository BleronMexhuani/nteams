// src/pages/BookDetail.jsx
import { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import api from '../api/api';

export default function BookDetail() {
  const { id } = useParams();
  const [book, setBook] = useState(null);

  useEffect(() => {
    api.get(`/books/${id}`).then(res => setBook(res.data));
  }, [id]);

  if (!book) return <p>Loading book...</p>;

  return (
    <div>
      <h2 className="text-2xl font-bold mb-2">{book.title}</h2>
      <p><strong>Author:</strong> {book.author_name}</p>
      <p><strong>ISBN:</strong> {book.isbn}</p>
      <p><strong>Description:</strong> {book.description}</p>
      <p><strong>Published Date:</strong> {book.published_date}</p>
      {book.cover_url && (
        <img src={book.cover_url} alt="cover" className="mt-4 w-48 h-auto" />
      )}
    </div>
  );
}
