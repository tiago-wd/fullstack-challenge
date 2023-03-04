<script>
import axios from "axios";
const apiUrl = import.meta.env.VITE_APP_URL;

export default {
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      weatherData: null,
    };
  },
  created() {
    this.loadWeatherData();
  },
  methods: {
    async loadWeatherData() {
      const response = await axios.get(
        `${apiUrl}users/${this.user.id}/weather`
      );
      this.weatherData = response.data.data.main;
    },
  },
  mounted() {
    window.Echo.channel("weather").listen(".weatherUpdated", (data) => {
      if (data.user.id === this.user.id) {
        this.weatherData = data.data.main;
      }
    });
  },
};
</script>

<template>
  <div>
    <v-card>
      <v-card-title>{{ user.name }}'s Weather</v-card-title>
      <v-card-text>
        <div v-if="weatherData">
          <p>Max temperature: {{ weatherData.temp_max }}°C</p>
          <p>Min description: {{ weatherData.temp_min }}</p>
          <p>Feels Like: {{ weatherData.feels_like }}</p>
          <p>Humidity: {{ weatherData.humidity }} km/h</p>
        </div>
        <div v-else>
          <p>Loading weather data...</p>
        </div>
      </v-card-text>
    </v-card>
  </div>
</template>
