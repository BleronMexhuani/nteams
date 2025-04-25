// src/components/Navbar.jsx
import { Link } from 'react-router-dom';

export default function Navbar() {
  return (
    <nav className="bg-blue-600 text-white p-4 flex gap-4">
      <Link to="/" className="font-bold">Home</Link>
      <Link to="/authors">Authors</Link>
      <Link to="/books">Books</Link>
      <Link to="/authors/create">Create Author</Link>
      <Link to="/books/create">Create Book</Link>
    </nav>
  );
}
