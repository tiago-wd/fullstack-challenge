<script>
import axios from "axios";
import UserWeather from "./UserWeather.vue";

const apiUrl = import.meta.env.VITE_APP_URL;

export default {
  components: {
    UserWeather,
  },
  data() {
    return {
      users: [],
      selectedUser: null,
    };
  },
  created() {
    this.loadUsers();
  },
  methods: {
    async loadUsers() {
      const response = await axios.get(apiUrl);
      this.users = response.data.users;
    },
    async showWeather(user) {
      this.selectedUser = user;
    },
  },
};
</script>
<template>
  <div>
    <v-card class="mb-3" v-for="user in users" :key="user.id">
      <v-card-title class="text-h5">{{ user.name }}</v-card-title>
      <v-card-actions>
        <v-btn color="primary" @click="showWeather(user)">Show Weather</v-btn>
      </v-card-actions>
      <UserWeather
        v-if="selectedUser && selectedUser.id === user.id"
        :user="selectedUser"
      />
    </v-card>
  </div>
</template>
