// src/pages/AuthorDetail.jsx
import { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import api from '../api/api';

export default function AuthorDetail() {
  const { id } = useParams();
  const [author, setAuthor] = useState(null);
  const [books, setBooks] = useState([]);

  useEffect(() => {
    fetchAuthor();
    fetchBooks();
  }, [id]);

  const fetchAuthor = async () => {
    const res = await api.get(`/authors/${id}`);

    setAuthor(res.data.data);
  };

  const fetchBooks = async () => {
    const res = await api.get('/books', {
      params: {
        author: id,
      },
    });
    setBooks(res.data.data || res.data);
  };

  if (!author) return <p>Loading author...</p>;

  return (
    <div>
      <h2 className="text-2xl font-bold mb-2">{author.name}</h2>
      <p className="mb-2"><strong>Biography:</strong> {author.biography}</p>
      <p className="mb-4"><strong>Birthdate:</strong> {author.birthdate}</p>

      <h3 className="text-xl font-semibold mb-2">Books by {author.name}</h3>
      <ul className="list-disc pl-6">
        {books.map(book => (
          <li key={book.id}>
            <Link to={`/books/${book.id}`} className="text-blue-600">{book.title}</Link>
          </li>
        ))}
      </ul>
    </div>
  );
}
