import {useEffect, useState} from 'react';
import {Link, useParams} from 'react-router-dom';
import './PokemonDetails.css';
import PokemonPage from "./PokemonPage"; // Custom CSS file for additional styling

function PokemonDetails() {
    const {name} = useParams();
    const [pokemon, setPokemon] = useState(null);

    useEffect(() => {
        fetch(`https://pokeapi.co/api/v2/pokemon/${name}`)
            .then(response => response.json())
            .then(data => setPokemon(data));
    }, [name]);

    if (!pokemon) return <div>Loading...</div>;

    return (
        <div className={`bg-${pokemon.types[0].type.name} pb-5`}>
            <Link to="/" className="btn btn-secondary mt-2 ms-2">All Pokemons</Link>
            <div className="container">
                <div className="card shadow-lg p-3 bg-white rounded">
                    <h1 className="text-center">
                        {pokemon.name?.charAt(0).toUpperCase() + pokemon.name?.slice(1)}
                    </h1>
                    <div className="text-center mb-3">
                        <img src={pokemon.sprites.other.home.front_default} alt={pokemon.name} className="pokemon-img"/>
                    </div>
                    <div className="card-body">
                        <h5 className="card-title">Overview</h5>
                        <ul className="list-group mt-3">
                            <li className="list-group-item">Height: {pokemon.height / 10} m</li>
                            <li className="list-group-item">Weight: {pokemon.weight / 10} kg</li>
                            <li className="list-group-item">Base Experience: {pokemon.base_experience}</li>
                            <li className="list-group-item">
                                Types: {pokemon.types.map(type => <span key={type.type.name}
                                                                        className={`badge bg-${type.type.name}`}>{type.type.name}</span>).reduce((prev, curr) => [prev, ', ', curr])}
                            </li>
                            <li className="list-group-item">
                                Abilities: {pokemon.abilities.map(ability => <span key={ability.ability.name}
                                                                                   className="badge bg-secondary">{ability.ability.name}</span>).reduce((prev, curr) => [prev, ', ', curr])}
                            </li>
                        </ul>
                        <h5 className="card-title mt-4">Stats</h5>
                        <ul className="list-group mt-3">
                            {pokemon.stats.map(stat => (
                                <li key={stat.stat.name} className="list-group-item d-flex justify-content-between">
                                    <span>{stat.stat.name.charAt(0).toUpperCase() + stat.stat.name.slice(1)}</span>
                                    <span>{stat.base_stat}</span>
                                </li>
                            ))}
                        </ul>
                        <h5 className="card-title mt-4">Moves</h5>
                        <ul className="list-group mt-3">
                            {pokemon.moves.slice(0, 50).map(move => (
                                <li key={move.move.name} className="list-group-item">{move.move.name}</li>
                            ))}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default PokemonDetails;
