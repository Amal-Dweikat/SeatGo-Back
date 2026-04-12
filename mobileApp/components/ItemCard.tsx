import { View, Text, StyleSheet } from "react-native";

type Item = {
  id: number;
  name: string;
  city: string;
  transport: string;
  price: number;
  passengers: number;
};

export default function ItemCard({ item }: { item: Item }) {
  return (
    <View style={styles.card}>

      <View style={styles.header}>
        <Text style={styles.title}>{item.name}</Text>
        <Text style={styles.price}>{item.price} ₪</Text>
      </View>

      <Text style={styles.city}>📍 {item.city}</Text>

      <View style={styles.row}>
        <Text style={styles.tag}>🚗 {item.transport}</Text>
        <Text style={styles.tag}>👥 {item.passengers} people</Text>
      </View>

    </View>
  );
}

const styles = StyleSheet.create({
  card: {
    backgroundColor: "#fff",
    padding: 15,
    marginBottom: 12,
    borderRadius: 16,

    // shadow (iOS)
    shadowColor: "#000",
    shadowOpacity: 0.1,
    shadowRadius: 10,
    shadowOffset: { width: 0, height: 5 },

    // shadow (Android)
    elevation: 4,
  },

  header: {
    flexDirection: "row",
    justifyContent: "space-between",
    marginBottom: 6,
  },

  title: {
    fontSize: 18,
    fontWeight: "bold",
    color: "#222",
    flex: 1,
  },

  price: {
    fontSize: 16,
    fontWeight: "bold",
    color: "#4A90E2",
  },

  city: {
    fontSize: 14,
    color: "#666",
    marginBottom: 10,
  },

  row: {
    flexDirection: "row",
    gap: 10,
  },

  tag: {
    backgroundColor: "#f2f6ff",
    paddingVertical: 5,
    paddingHorizontal: 10,
    borderRadius: 20,
    fontSize: 12,
    color: "#333",
  },
});