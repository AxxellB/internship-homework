import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import PokemonPage from "./PokemonPage";
import PokemonDetails from "./PokemonDetails";

function App() {
    return (
        <Router>
            <Routes>
                <Route path="/" element={<PokemonPage />} />
                <Route path="/pokemon/:name" element={<PokemonDetails />} />
            </Routes>
        </Router>
    );
}

export default App;