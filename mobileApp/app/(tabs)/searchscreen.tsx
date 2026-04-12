import { View, FlatList, Text } from "react-native";
import { useEffect, useState } from "react";
import SearchBar from "../../components/SearchBar";
import FilterBar from "../../components/FilterBar";
import ItemCard from "@/components/ItemCard";

type Item = {
  id: number;
  name: string;
  city: string;
  transport: string;
  price: number;
  passengers: number;
};

export default function Home() {
  const [search, setSearch] = useState("");
  const [filters, setFilters] = useState({
    city: "",
    transport: "",
    price: "",
    passengers: "",
  });

  const [data, setData] = useState<Item[]>([]);

  // 📡 API CALL
  const fetchData = async (params = {}) => {
    const query = new URLSearchParams(params).toString();

    const res = await fetch(
      `http://192.168.1.103:8000/api/items?${query}`
    );

    const json = await res.json();
    setData(json);
  };

  // 🔥 دمج search + filters
  const applyFilters = (newSearch = search, newFilters = filters) => {
    fetchData({
      search: newSearch,
      ...newFilters,
    });
  };

  // 📌 أول تحميل
  useEffect(() => {
    fetchData({});
  }, []);

  return (
    <View style={{ padding: 10, flex: 1 }}>

      {/* 🔍 Search */}
      <SearchBar
        value={search}
        onChange={(text) => {
          setSearch(text);
          applyFilters(text, filters);
        }}
      />

      {/* 🎛️ Filters */}
      <FilterBar
        onChange={(f) => {
          setFilters(f);
          applyFilters(search, f);
        }}
      />

      {/* 📦 List */}
      <FlatList
  data={data}
  keyExtractor={(item) => item.id.toString()}
  renderItem={({ item }) => <ItemCard item={item} />}
/>
      
          <View style={{ marginTop: 50, alignItems: "center" }}>
            <Text>لا يوجد نتائج 🔍</Text>
          </View>
        
      
    </View>
  );
}