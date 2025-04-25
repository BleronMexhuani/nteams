// src/App.jsx
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import Authors from './pages/Authors';
import CreateAuthor from './pages/CreateAuthor';
import UpdateAuthor from './pages/UpdateAuthor';
import AuthorDetail from './pages/AuthorDetail';

import Books from './pages/Books';
import CreateBook from './pages/CreateBook';
import UpdateBook from './pages/UpdateBook';
import BookDetail from './pages/BookDetail';

export default function App() {
  return (
    <Router>
      <div className="min-h-screen bg-gray-100 p-6">
        {/* Navbar */}
        <nav className="flex justify-between items-center bg-blue-600 text-white p-4 rounded-lg shadow-lg mb-6">
          <div className="text-xl font-bold">Library</div>
          <div className="space-x-6">
            <Link to="/authors" className="hover:text-gray-300">Authors</Link>
            <Link to="/books" className="hover:text-gray-300">Books</Link>
            <Link to="/authors/create" className="bg-green-500 hover:bg-green-600 px-4 py-2 rounded text-white">+ Add Author</Link>
            <Link to="/books/create" className="bg-green-500 hover:bg-green-600 px-4 py-2 rounded text-white">+ Add Book</Link>
          </div>
        </nav>

        <div className="container mx-auto">
          <Routes>
            <Route path="/authors" element={<Authors />} />
            <Route path="/authors/create" element={<CreateAuthor />} />
            <Route path="/authors/update/:id" element={<UpdateAuthor />} />
            <Route path="/authors/:id" element={<AuthorDetail />} />

            <Route path="/books" element={<Books />} />
            <Route path="/books/create" element={<CreateBook />} />
            <Route path="/books/update/:id" element={<UpdateBook />} />
            <Route path="/books/:id" element={<BookDetail />} />
          </Routes>
        </div>
      </div>
    </Router>
  );
}
