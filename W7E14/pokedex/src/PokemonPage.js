import './App.css';
import {useEffect, useState} from "react";
import PokemonCard from "./PokemonCard";

function PokemonPage() {
    const [pokemons, setPokemons] = useState([]);

    useEffect(() => {
        fetch('https://pokeapi.co/api/v2/pokemon?limit=700&offset=0')
            .then(data => data.json())
            .then(pokemonData => setPokemons(pokemonData.results))
    }, []);

    return (
        <div className="container">
            <h1 className="text-center">Pokedex</h1>
            {pokemons?.length < 200 ? (
                <div className="text-center mt-5">
                    <h3>Loading...</h3>
                </div>
            ) : (
                <div className="row">
                    {pokemons.map(pokemon => (
                        <div className="col-md-2" key={pokemon.name}>
                            <PokemonCard name={pokemon.name} url={pokemon.url}/>
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
}

export default PokemonPage;
