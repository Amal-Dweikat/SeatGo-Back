import { View,TouchableOpacity , FlatList, ImageBackground, Text, StyleSheet } from "react-native";
import { useLocalSearchParams } from "expo-router";
import { useEffect, useState } from "react";
import ItemCard from "../components/ItemCard";
import { useRouter } from "expo-router";
import SortFilterDropdown from "@/components/SortFilterDropdown";
import { ScrollView } from "react-native";


export default function ResultsScreen() {

  const [data, setData] = useState<item[]>([]);

const [filters, setFilters] = useState<Filters>({
  passengers: null,
  sort: null,
  price: null,
  time: null,
});
  const { from, to, time } = useLocalSearchParams();
const router = useRouter();
  const fromValue = Array.isArray(from) ? from[0] : from;
  const toValue = Array.isArray(to) ? to[0] : to;
  const timeValue = Array.isArray(time) ? time[0] : time;

type item = {
  id: number;
  from_city: string;
  to_city: string;
  time: string;
  transport: string;
  price: number;
  passengers: number;
  driver_name: string;
  driver_image: string;
};

  useEffect(() => {
    const fetchData = async () => {
      const query = new URLSearchParams();

      if (fromValue) query.append("from_city", fromValue);
      if (toValue) query.append("to_city", toValue);
      if (timeValue) {
  let formattedTime = timeValue;

  if (!timeValue.includes(":")) {
    formattedTime = timeValue.padStart(2, "0") + ":00";
  }

  else if (timeValue.length === 4) {
    formattedTime = "0" + timeValue;
  }

  query.append("time", formattedTime);
}

      console.log("QUERY:", query.toString());

      const res = await fetch(
        `http://192.168.1.103:8000/api/search?${query.toString()}`
      );

      const json = await res.json();
      console.log("RESULTS:", json);

      setData(json);
    };

    fetchData();
  }, [fromValue, toValue, timeValue]);

  const timeToMinutes = (t: string) => {
  const [h, m] = t.split(":").map(Number);
  return h * 60 + m;
};
const filteredData = data
  .filter((item) => {
    if (filters.passengers) {
      return item.passengers >= filters.passengers;
    }
    return true;
  })
  .sort((a, b) => {
  if (filters.price === "low")
    return Number(a.price) - Number(b.price);

  if (filters.price === "high")
    return Number(b.price) - Number(a.price);

  if (filters.time === "earliest") {
  return timeToMinutes(a.time) - timeToMinutes(b.time);
}

if (filters.time === "latest") {
  return timeToMinutes(b.time) - timeToMinutes(a.time);
}
  if (filters.sort === "new") return b.id - a.id;
  if (filters.sort === "old") return a.id - b.id;

  return 0;
});
  //الفلتر 

  type Filters = {
  passengers: number | null;
  sort: "new" | "old" | null;
  price: "low" | "high" | null;
  time: "earliest" | "latest" | null;
};


  return (
    <View>
  <ImageBackground
    source={{
      uri: "https://images.unsplash.com/photo-1500530855697-b586d89ba3ee",
    }}
    style={styles.header}
  >
    <View style={styles.overlay}>
      <Text style={styles.title}>Trips from</Text>
      <Text style={styles.subtitle}>
        {fromValue} → {toValue}
      </Text>
    <TouchableOpacity onPress={() => router.back()}>
  <Text style={styles.backLink}>Edit search</Text>
</TouchableOpacity>
  </View>
  </ImageBackground>
  



  <SortFilterDropdown filters={filters} onChange={setFilters} />


  <FlatList
  data={filteredData}
  keyExtractor={(item) => String(item.id)}
  renderItem={({ item }) => <ItemCard item={item} />}
  contentContainerStyle={{ paddingBottom: 30 }}
/>
</View>



  );
}

const styles = StyleSheet.create({
  header: {
    height: 180,
    marginBottom: 5,
  },

  overlay: {
    flex: 1,
    backgroundColor: "rgba(0,0,0,0.5)", 
    justifyContent: "center",
    padding: 20,
  },

  title: {
    color: "white",
    fontSize: 28,
    fontWeight: "300",
  },

  subtitle: {
    color: "white",
    fontSize: 32,
    fontWeight: "bold",
  },
  backLink: {
  color: "#ffffff",
  backgroundColor: "#ff9914e0",
  borderRadius: 15,
  width: 90,
  marginTop: 2,
  padding: 8,
  fontSize: 13,
  textAlign: "center",
  fontWeight: "bold",},

  
});