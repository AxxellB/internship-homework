import './App.css';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import TaskManager from "./TaskManager";
import TaskForm from "./TaskForm";

function App() {
  return (
      <Router>
        <Routes>
          <Route path="/" element={<TaskManager />} />
          <Route path="/task-create" element={<TaskForm />} />
        </Routes>
      </Router>
  );
}

export default App;
