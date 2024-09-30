import { Link } from 'react-router-dom';
import { useEffect, useState } from 'react';

function PokemonCard({ name, url }) {
    const [pokemon, setPokemon] = useState([]);

    useEffect(() => {
        fetch(url)
            .then(response => response.json())
            .then(data => setPokemon(data));
    }, [url]);

    return (
        <Link to={`/pokemon/${name}`} className="text-decoration-none">
            <div className="card border-primary m-2" style={{ width: '150px' }}>
                <div className="card-body text-center">
                    <img
                        src={pokemon.sprites?.front_default}
                        alt={pokemon.name}
                        className="img-fluid"
                    />
                    <span className="mt-2 d-block text-center">{name}</span>
                </div>
            </div>
        </Link>
    );
}

export default PokemonCard;
