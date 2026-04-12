import { View, Text, StyleSheet, TouchableOpacity } from "react-native";
import { useState } from "react";

type Filters = {
  city: string;
  transport: string;
  price: string;
  passengers: string;
};

type Props = {
  onChange?: (filters: Filters) => void;
};

export default function FilterBar({ onChange }: Props) {
  const [filters, setFilters] = useState<Filters>({
    city: "",
    transport: "",
    price: "",
    passengers: "",
  });

  const [open, setOpen] = useState<string | null>(null);

  const options = {
    city: ["Ramallah", "Jerusalem", "Nablus"],
    transport: ["Bus", "Taxi", "Van", "Car"],
    price: ["20", "50", "100", "200"],
    passengers: ["5", "10", "15", "20"],
  };

  const selectOption = (key: keyof Filters, value: string) => {
    const updated = {
      ...filters,
      [key]: filters[key] === value ? "" : value,
    };

    setFilters(updated);
    onChange?.(updated);
  };

  const renderDropdown = (
    key: keyof Filters,
    label: string,
    values: string[]
  ) => (
    <View style={styles.dropdownContainer}>
      <TouchableOpacity
        style={styles.dropdownHeader}
        onPress={() => setOpen(open === key ? null : key)}
      >
        <Text style={styles.dropdownTitle}>
          {label}: {filters[key] || "All"}
        </Text>
        <Text>{open === key ? "▲" : "▼"}</Text>
      </TouchableOpacity>

      {open === key && (
        <View style={styles.dropdownList}>
          {values.map((item) => (
            <TouchableOpacity
              key={item}
              style={[
                styles.option,
                filters[key] === item && styles.activeOption,
              ]}
              onPress={() => {
                selectOption(key, item);
                setOpen(null); // close after select
              }}
            >
              <Text
                style={filters[key] === item ? styles.activeText : null}
              >
                {item}
              </Text>
            </TouchableOpacity>
          ))}
        </View>
      )}
    </View>
  );

  return (
    <View style={styles.container}>
      {renderDropdown("city", "City", options.city)}
      {renderDropdown("transport", "Transport", options.transport)}
      {renderDropdown("price", "Price", options.price)}
      {renderDropdown("passengers", "Passengers", options.passengers)}
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
  marginTop: 10,
  padding: 10,
  backgroundColor: "#f5f5f5",
  borderRadius: 10,

  flexDirection: "row",   
  flexWrap: "wrap",      
  gap: 8,
},

  dropdownContainer: {
  marginBottom: 8,
  width: "48%",   
},

  dropdownHeader: {
  flexDirection: "row",
  justifyContent: "space-between",
  padding: 8,          
  backgroundColor: "#fff",
  borderRadius: 8,
},

  dropdownTitle: {
    fontWeight: "bold",
    fontSize: 12,
  },

  dropdownList: {
    marginTop: 5,
    backgroundColor: "#fff",
    borderRadius: 8,
    padding: 5,
  },

  option: {
    padding: 6,
  borderRadius: 6,
  },

  activeOption: {
    backgroundColor: "#4A90E2",
  },

  activeText: {
    color: "white",
    fontWeight: "bold",
  },
});