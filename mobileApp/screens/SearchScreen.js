import { useEffect, useState } from 'react';
import { View, FlatList } from 'react-native';
import API from '../services/api';
import SearchBar from '../components/SearchBar';
import ItemCard from '../components/ItemCard';

export default function HomeScreen() {
  const [data, setData] = useState([]);
  const [query, setQuery] = useState('');

  useEffect(() => {
    API.get('/items')
      .then(res => setData(res.data))
      .catch(err => console.log(err));
  }, []);

  const filteredData = data.filter(item =>
    item.name.toLowerCase().includes(query.toLowerCase())
  );

  return (
    <View style={{ marginTop: 50, padding: 10 }}>
      
      <SearchBar value={query} onChange={setQuery} />

      <FlatList
        data={filteredData}
        keyExtractor={(item) => item.id.toString()}
        renderItem={({ item }) => <ItemCard item={item} />}
      />

    </View>
  );
}